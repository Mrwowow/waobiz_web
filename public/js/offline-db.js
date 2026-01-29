/**
 * WaoBiz Offline Database Manager
 * Uses IndexedDB for offline data storage and sync queue
 */

const WaoBizOfflineDB = (function() {
    const DB_NAME = 'waobiz_offline';
    const DB_VERSION = 1;
    let db = null;

    // Store configurations
    const STORES = {
        products: { keyPath: 'id', indexes: ['sku', 'name', 'category_id', 'brand_id'] },
        contacts: { keyPath: 'id', indexes: ['name', 'type', 'mobile'] },
        categories: { keyPath: 'id', indexes: ['name'] },
        brands: { keyPath: 'id', indexes: ['name'] },
        taxRates: { keyPath: 'id', indexes: ['name'] },
        locations: { keyPath: 'id', indexes: ['name'] },
        syncQueue: { keyPath: 'id', autoIncrement: true, indexes: ['timestamp', 'type', 'synced'] },
        pendingSales: { keyPath: 'id', autoIncrement: true, indexes: ['timestamp', 'synced'] },
        settings: { keyPath: 'key' }
    };

    /**
     * Initialize the database
     */
    async function init() {
        return new Promise((resolve, reject) => {
            const request = indexedDB.open(DB_NAME, DB_VERSION);

            request.onerror = (event) => {
                console.error('[OfflineDB] Error opening database:', event.target.error);
                reject(event.target.error);
            };

            request.onsuccess = (event) => {
                db = event.target.result;
                console.log('[OfflineDB] Database opened successfully');
                resolve(db);
            };

            request.onupgradeneeded = (event) => {
                console.log('[OfflineDB] Upgrading database...');
                const database = event.target.result;

                // Create object stores
                Object.entries(STORES).forEach(([storeName, config]) => {
                    if (!database.objectStoreNames.contains(storeName)) {
                        const store = database.createObjectStore(storeName, {
                            keyPath: config.keyPath,
                            autoIncrement: config.autoIncrement || false
                        });

                        // Create indexes
                        if (config.indexes) {
                            config.indexes.forEach(index => {
                                store.createIndex(index, index, { unique: false });
                            });
                        }
                    }
                });
            };
        });
    }

    /**
     * Get all records from a store
     */
    async function getAll(storeName) {
        await ensureDb();
        return new Promise((resolve, reject) => {
            const transaction = db.transaction(storeName, 'readonly');
            const store = transaction.objectStore(storeName);
            const request = store.getAll();

            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }

    /**
     * Get a single record by key
     */
    async function get(storeName, key) {
        await ensureDb();
        return new Promise((resolve, reject) => {
            const transaction = db.transaction(storeName, 'readonly');
            const store = transaction.objectStore(storeName);
            const request = store.get(key);

            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }

    /**
     * Add or update a record
     */
    async function put(storeName, data) {
        await ensureDb();
        return new Promise((resolve, reject) => {
            const transaction = db.transaction(storeName, 'readwrite');
            const store = transaction.objectStore(storeName);
            const request = store.put(data);

            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }

    /**
     * Add multiple records
     */
    async function putMany(storeName, dataArray) {
        await ensureDb();
        return new Promise((resolve, reject) => {
            const transaction = db.transaction(storeName, 'readwrite');
            const store = transaction.objectStore(storeName);

            dataArray.forEach(data => store.put(data));

            transaction.oncomplete = () => resolve();
            transaction.onerror = () => reject(transaction.error);
        });
    }

    /**
     * Delete a record
     */
    async function remove(storeName, key) {
        await ensureDb();
        return new Promise((resolve, reject) => {
            const transaction = db.transaction(storeName, 'readwrite');
            const store = transaction.objectStore(storeName);
            const request = store.delete(key);

            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    }

    /**
     * Clear all records from a store
     */
    async function clear(storeName) {
        await ensureDb();
        return new Promise((resolve, reject) => {
            const transaction = db.transaction(storeName, 'readwrite');
            const store = transaction.objectStore(storeName);
            const request = store.clear();

            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    }

    /**
     * Search records by index
     */
    async function searchByIndex(storeName, indexName, value) {
        await ensureDb();
        return new Promise((resolve, reject) => {
            const transaction = db.transaction(storeName, 'readonly');
            const store = transaction.objectStore(storeName);
            const index = store.index(indexName);
            const request = index.getAll(value);

            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }

    /**
     * Add to sync queue
     */
    async function addToSyncQueue(type, url, method, data) {
        const item = {
            type: type,
            url: url,
            method: method,
            data: data,
            timestamp: Date.now(),
            synced: false,
            attempts: 0
        };
        return put('syncQueue', item);
    }

    /**
     * Get pending sync items
     */
    async function getPendingSyncItems() {
        const allItems = await getAll('syncQueue');
        return allItems.filter(item => !item.synced && item.attempts < 3);
    }

    /**
     * Mark sync item as synced
     */
    async function markAsSynced(id) {
        const item = await get('syncQueue', id);
        if (item) {
            item.synced = true;
            item.syncedAt = Date.now();
            await put('syncQueue', item);
        }
    }

    /**
     * Increment sync attempt count
     */
    async function incrementSyncAttempt(id) {
        const item = await get('syncQueue', id);
        if (item) {
            item.attempts = (item.attempts || 0) + 1;
            item.lastAttempt = Date.now();
            await put('syncQueue', item);
        }
    }

    /**
     * Save pending sale for offline
     */
    async function savePendingSale(saleData) {
        const sale = {
            ...saleData,
            timestamp: Date.now(),
            synced: false,
            localId: `local_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`
        };
        return put('pendingSales', sale);
    }

    /**
     * Get pending sales
     */
    async function getPendingSales() {
        const allSales = await getAll('pendingSales');
        return allSales.filter(sale => !sale.synced);
    }

    /**
     * Mark sale as synced
     */
    async function markSaleAsSynced(id, serverData) {
        const sale = await get('pendingSales', id);
        if (sale) {
            sale.synced = true;
            sale.syncedAt = Date.now();
            sale.serverData = serverData;
            await put('pendingSales', sale);
        }
    }

    /**
     * Sync products from server
     */
    async function syncProducts(products) {
        await clear('products');
        await putMany('products', products);
        await put('settings', { key: 'products_last_sync', value: Date.now() });
    }

    /**
     * Sync contacts from server
     */
    async function syncContacts(contacts) {
        await clear('contacts');
        await putMany('contacts', contacts);
        await put('settings', { key: 'contacts_last_sync', value: Date.now() });
    }

    /**
     * Get last sync time
     */
    async function getLastSyncTime(type) {
        const setting = await get('settings', `${type}_last_sync`);
        return setting ? setting.value : null;
    }

    /**
     * Ensure database is initialized
     */
    async function ensureDb() {
        if (!db) {
            await init();
        }
    }

    /**
     * Get database statistics
     */
    async function getStats() {
        await ensureDb();
        const stats = {};

        for (const storeName of Object.keys(STORES)) {
            const items = await getAll(storeName);
            stats[storeName] = items.length;
        }

        return stats;
    }

    // Public API
    return {
        init,
        getAll,
        get,
        put,
        putMany,
        remove,
        clear,
        searchByIndex,
        addToSyncQueue,
        getPendingSyncItems,
        markAsSynced,
        incrementSyncAttempt,
        savePendingSale,
        getPendingSales,
        markSaleAsSynced,
        syncProducts,
        syncContacts,
        getLastSyncTime,
        getStats
    };
})();

// Initialize on load
if (typeof window !== 'undefined') {
    window.WaoBizOfflineDB = WaoBizOfflineDB;
}
