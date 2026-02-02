/**
 * WaoBiz Offline Sync Manager
 * Handles synchronization between local IndexedDB and server
 */

const WaoBizSync = (function() {
    let isOnline = navigator.onLine;
    let syncInProgress = false;
    let syncInterval = null;

    // Get base URL from the current page (handles subdirectory installations)
    const getBaseUrl = () => {
        const base = document.querySelector('base')?.href ||
                     document.querySelector('meta[name="base-url"]')?.content ||
                     window.APP_URL ||
                     window.location.origin + window.location.pathname.replace(/\/[^\/]*$/, '');
        return base.replace(/\/$/, '');
    };
    const BASE_URL = getBaseUrl();

    /**
     * Initialize sync manager
     */
    async function init() {
        // Initialize offline database
        await WaoBizOfflineDB.init();

        // Set up online/offline listeners
        window.addEventListener('online', handleOnline);
        window.addEventListener('offline', handleOffline);

        // Listen for service worker messages
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.addEventListener('message', handleServiceWorkerMessage);
        }

        // Initial sync if online
        if (navigator.onLine) {
            await syncAllData();
        }

        // Set up periodic sync check
        syncInterval = setInterval(checkAndSync, 30000); // Every 30 seconds

        console.log('[Sync] Initialized');
        updateUI();
    }

    /**
     * Handle coming online
     */
    async function handleOnline() {
        console.log('[Sync] Connection restored');
        isOnline = true;
        updateUI();

        // Process sync queue
        await processSyncQueue();
        await syncPendingSales();

        // Refresh data from server
        await syncAllData();
    }

    /**
     * Handle going offline
     */
    function handleOffline() {
        console.log('[Sync] Connection lost');
        isOnline = false;
        updateUI();
        showNotification('You are offline. Changes will be saved locally and synced when connection is restored.', 'warning');
    }

    /**
     * Handle service worker messages
     */
    async function handleServiceWorkerMessage(event) {
        const { type, payload } = event.data;

        switch (type) {
            case 'QUEUE_REQUEST':
                await WaoBizOfflineDB.addToSyncQueue(
                    payload.method,
                    payload.url,
                    payload.method,
                    payload.body
                );
                break;

            case 'PROCESS_SYNC_QUEUE':
                await processSyncQueue();
                break;
        }
    }

    /**
     * Check connection and sync if needed
     */
    async function checkAndSync() {
        if (navigator.onLine && !syncInProgress) {
            const pendingItems = await WaoBizOfflineDB.getPendingSyncItems();
            const pendingSales = await WaoBizOfflineDB.getPendingSales();

            if (pendingItems.length > 0 || pendingSales.length > 0) {
                await processSyncQueue();
                await syncPendingSales();
            }
        }
    }

    /**
     * Process the sync queue
     */
    async function processSyncQueue() {
        if (syncInProgress || !navigator.onLine) return;

        syncInProgress = true;
        updateUI('syncing');

        try {
            const pendingItems = await WaoBizOfflineDB.getPendingSyncItems();
            console.log(`[Sync] Processing ${pendingItems.length} queued items`);

            for (const item of pendingItems) {
                try {
                    const response = await fetch(item.url, {
                        method: item.method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                            'Accept': 'application/json'
                        },
                        body: item.data
                    });

                    if (response.ok) {
                        await WaoBizOfflineDB.markAsSynced(item.id);
                        console.log(`[Sync] Successfully synced item ${item.id}`);
                    } else {
                        await WaoBizOfflineDB.incrementSyncAttempt(item.id);
                        console.error(`[Sync] Failed to sync item ${item.id}:`, response.status);
                    }
                } catch (error) {
                    await WaoBizOfflineDB.incrementSyncAttempt(item.id);
                    console.error(`[Sync] Error syncing item ${item.id}:`, error);
                }
            }
        } finally {
            syncInProgress = false;
            updateUI();
        }
    }

    /**
     * Sync pending sales
     */
    async function syncPendingSales() {
        if (!navigator.onLine) return;

        const pendingSales = await WaoBizOfflineDB.getPendingSales();
        console.log(`[Sync] Syncing ${pendingSales.length} pending sales`);

        for (const sale of pendingSales) {
            try {
                const response = await fetch(`${BASE_URL}/api/sales/sync`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(sale)
                });

                if (response.ok) {
                    const serverData = await response.json();
                    await WaoBizOfflineDB.markSaleAsSynced(sale.id, serverData);
                    console.log(`[Sync] Sale ${sale.localId} synced successfully`);
                }
            } catch (error) {
                console.error(`[Sync] Error syncing sale ${sale.localId}:`, error);
            }
        }
    }

    /**
     * Sync all data from server to local
     */
    async function syncAllData() {
        if (!navigator.onLine) return;

        console.log('[Sync] Starting full data sync...');
        updateUI('syncing');

        try {
            await Promise.all([
                syncProducts(),
                syncContacts(),
                syncCategories(),
                syncBrands(),
                syncTaxRates(),
                syncLocations()
            ]);

            await WaoBizOfflineDB.put('settings', {
                key: 'last_full_sync',
                value: Date.now()
            });

            console.log('[Sync] Full sync completed');
            showNotification('Data synchronized successfully', 'success');
        } catch (error) {
            console.error('[Sync] Full sync failed:', error);
            showNotification('Sync failed. Will retry later.', 'error');
        } finally {
            updateUI();
        }
    }

    /**
     * Sync products
     */
    async function syncProducts() {
        try {
            const response = await fetch(`${BASE_URL}/api/cache/products?per_page=10000`);
            if (response.ok) {
                const data = await response.json();
                const products = data.data || data;
                if (Array.isArray(products) && products.length > 0) {
                    await WaoBizOfflineDB.syncProducts(products);
                    console.log(`[Sync] Synced ${products.length} products`);
                }
            } else {
                console.log('[Sync] Products API returned:', response.status);
            }
        } catch (error) {
            console.error('[Sync] Failed to sync products:', error);
        }
    }

    /**
     * Sync contacts
     */
    async function syncContacts() {
        try {
            const response = await fetch(`${BASE_URL}/api/cache/contacts?per_page=10000`);
            if (response.ok) {
                const data = await response.json();
                const contacts = data.data || data;
                if (Array.isArray(contacts) && contacts.length > 0) {
                    await WaoBizOfflineDB.syncContacts(contacts);
                    console.log(`[Sync] Synced ${contacts.length} contacts`);
                }
            } else {
                console.log('[Sync] Contacts API returned:', response.status);
            }
        } catch (error) {
            console.error('[Sync] Failed to sync contacts:', error);
        }
    }

    /**
     * Sync categories
     */
    async function syncCategories() {
        try {
            const response = await fetch(`${BASE_URL}/api/cache/categories`);
            if (response.ok) {
                const result = await response.json();
                const categories = result.data || result;
                if (Array.isArray(categories) && categories.length > 0) {
                    await WaoBizOfflineDB.clear('categories');
                    await WaoBizOfflineDB.putMany('categories', categories);
                }
            }
        } catch (error) {
            console.error('[Sync] Failed to sync categories:', error);
        }
    }

    /**
     * Sync brands
     */
    async function syncBrands() {
        try {
            const response = await fetch(`${BASE_URL}/api/cache/brands`);
            if (response.ok) {
                const result = await response.json();
                const brands = result.data || result;
                if (Array.isArray(brands) && brands.length > 0) {
                    await WaoBizOfflineDB.clear('brands');
                    await WaoBizOfflineDB.putMany('brands', brands);
                }
            }
        } catch (error) {
            console.error('[Sync] Failed to sync brands:', error);
        }
    }

    /**
     * Sync tax rates
     */
    async function syncTaxRates() {
        try {
            const response = await fetch(`${BASE_URL}/api/cache/tax-rates`);
            if (response.ok) {
                const result = await response.json();
                const taxRates = result.data || result;
                if (Array.isArray(taxRates) && taxRates.length > 0) {
                    await WaoBizOfflineDB.clear('taxRates');
                    await WaoBizOfflineDB.putMany('taxRates', taxRates);
                }
            }
        } catch (error) {
            console.error('[Sync] Failed to sync tax rates:', error);
        }
    }

    /**
     * Sync locations
     */
    async function syncLocations() {
        try {
            const response = await fetch(`${BASE_URL}/api/cache/business-locations`);
            if (response.ok) {
                const result = await response.json();
                const locations = result.data || result;
                if (Array.isArray(locations) && locations.length > 0) {
                    await WaoBizOfflineDB.clear('locations');
                    await WaoBizOfflineDB.putMany('locations', locations);
                }
            }
        } catch (error) {
            console.error('[Sync] Failed to sync locations:', error);
        }
    }

    /**
     * Save a sale offline
     */
    async function saveSaleOffline(saleData) {
        await WaoBizOfflineDB.savePendingSale(saleData);
        showNotification('Sale saved offline. Will sync when connection is restored.', 'info');

        // Try to sync immediately if online
        if (navigator.onLine) {
            await syncPendingSales();
        }
    }

    /**
     * Get products from local database
     */
    async function getLocalProducts() {
        return await WaoBizOfflineDB.getAll('products');
    }

    /**
     * Get contacts from local database
     */
    async function getLocalContacts() {
        return await WaoBizOfflineDB.getAll('contacts');
    }

    /**
     * Search products locally
     */
    async function searchProductsLocal(query) {
        const products = await WaoBizOfflineDB.getAll('products');
        const lowerQuery = query.toLowerCase();

        return products.filter(p =>
            p.name?.toLowerCase().includes(lowerQuery) ||
            p.sku?.toLowerCase().includes(lowerQuery)
        );
    }

    /**
     * Search contacts locally
     */
    async function searchContactsLocal(query) {
        const contacts = await WaoBizOfflineDB.getAll('contacts');
        const lowerQuery = query.toLowerCase();

        return contacts.filter(c =>
            c.name?.toLowerCase().includes(lowerQuery) ||
            c.mobile?.includes(query)
        );
    }

    /**
     * Update UI based on online/offline status
     */
    function updateUI(status) {
        const indicator = document.getElementById('offline-indicator');
        const syncButton = document.getElementById('sync-button');

        if (indicator) {
            if (!navigator.onLine) {
                indicator.classList.remove('hidden');
                indicator.classList.add('offline');
                indicator.innerHTML = '<i class="fa fa-wifi-slash"></i> Offline';
            } else if (status === 'syncing') {
                indicator.classList.remove('hidden', 'offline');
                indicator.classList.add('syncing');
                indicator.innerHTML = '<i class="fa fa-sync fa-spin"></i> Syncing...';
            } else {
                indicator.classList.add('hidden');
                indicator.classList.remove('offline', 'syncing');
            }
        }

        if (syncButton) {
            syncButton.disabled = !navigator.onLine || status === 'syncing';
        }

        // Dispatch custom event
        window.dispatchEvent(new CustomEvent('waobiz:connection-status', {
            detail: { online: navigator.onLine, syncing: status === 'syncing' }
        }));
    }

    /**
     * Show notification
     */
    function showNotification(message, type = 'info') {
        // Use toastr if available
        if (typeof toastr !== 'undefined') {
            toastr[type](message);
        } else {
            console.log(`[${type.toUpperCase()}] ${message}`);
        }
    }

    /**
     * Manual sync trigger
     */
    async function manualSync() {
        await syncAllData();
        await processSyncQueue();
        await syncPendingSales();
    }

    /**
     * Get sync status
     */
    async function getSyncStatus() {
        const stats = await WaoBizOfflineDB.getStats();
        const lastSync = await WaoBizOfflineDB.get('settings', 'last_full_sync');
        const pendingItems = await WaoBizOfflineDB.getPendingSyncItems();
        const pendingSales = await WaoBizOfflineDB.getPendingSales();

        return {
            online: navigator.onLine,
            syncing: syncInProgress,
            lastSync: lastSync?.value,
            pendingQueue: pendingItems.length,
            pendingSales: pendingSales.length,
            localData: stats
        };
    }

    // Public API
    return {
        init,
        syncAllData,
        manualSync,
        saveSaleOffline,
        getLocalProducts,
        getLocalContacts,
        searchProductsLocal,
        searchContactsLocal,
        getSyncStatus,
        isOnline: () => navigator.onLine
    };
})();

// Initialize when DOM is ready
if (typeof window !== 'undefined') {
    window.WaoBizSync = WaoBizSync;

    document.addEventListener('DOMContentLoaded', () => {
        WaoBizSync.init().catch(console.error);
    });
}
