/**
 * WaoBiz Service Worker
 * Enables offline functionality for the PWA
 */

const CACHE_VERSION = 'waobiz-v2';
const STATIC_CACHE = `${CACHE_VERSION}-static`;
const DYNAMIC_CACHE = `${CACHE_VERSION}-dynamic`;
const API_CACHE = `${CACHE_VERSION}-api`;

// Static assets to cache on install
const STATIC_ASSETS = [
    '/',
    '/offline',
    '/css/app.css',
    '/css/vendor.css',
    '/js/app.js',
    '/js/init.js',
    '/manifest.json',
    '/img/icons/icon-192x192.png',
    '/img/icons/icon-512x512.png'
];

// API endpoints to cache for offline use
const API_ENDPOINTS = [
    '/api/products',
    '/api/contacts',
    '/api/business-locations',
    '/api/tax-rates',
    '/api/brands',
    '/api/categories'
];

// Install event - cache static assets
self.addEventListener('install', (event) => {
    console.log('[SW] Installing Service Worker...');
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then((cache) => {
                console.log('[SW] Caching static assets');
                return cache.addAll(STATIC_ASSETS).catch(err => {
                    console.log('[SW] Some static assets failed to cache:', err);
                });
            })
            .then(() => self.skipWaiting())
    );
});

// Activate event - clean up old caches
self.addEventListener('activate', (event) => {
    console.log('[SW] Activating Service Worker...');
    event.waitUntil(
        caches.keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames
                        .filter((name) => name.startsWith('waobiz-') && name !== STATIC_CACHE && name !== DYNAMIC_CACHE && name !== API_CACHE)
                        .map((name) => {
                            console.log('[SW] Deleting old cache:', name);
                            return caches.delete(name);
                        })
                );
            })
            .then(() => self.clients.claim())
    );
});

// Fetch event - serve from cache or network
self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);

    // Skip non-GET requests
    if (request.method !== 'GET') {
        // For POST/PUT/DELETE, try network and queue if offline
        if (request.method === 'POST' || request.method === 'PUT' || request.method === 'DELETE') {
            event.respondWith(handleMutationRequest(request));
        }
        return;
    }

    // Handle API requests
    if (url.pathname.startsWith('/api/')) {
        event.respondWith(handleApiRequest(request));
        return;
    }

    // Handle static assets and pages
    event.respondWith(handleStaticRequest(request));
});

// Handle API requests - network first, fallback to cache
async function handleApiRequest(request) {
    const cache = await caches.open(API_CACHE);

    try {
        const response = await fetch(request);
        // Only cache successful full responses (not partial 206 responses)
        if (response.ok && response.status !== 206) {
            cache.put(request, response.clone());
        }
        return response;
    } catch (error) {
        console.log('[SW] Network failed for API, trying cache:', request.url);
        const cachedResponse = await cache.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }
        // Return empty JSON response for offline
        return new Response(JSON.stringify({
            offline: true,
            error: 'You are offline. Data may be outdated.',
            data: []
        }), {
            headers: { 'Content-Type': 'application/json' }
        });
    }
}

// Handle static requests - cache first, fallback to network
async function handleStaticRequest(request) {
    const cachedResponse = await caches.match(request);

    if (cachedResponse) {
        // Return cached version and update cache in background
        fetchAndCache(request);
        return cachedResponse;
    }

    try {
        const response = await fetch(request);
        // Only cache successful full responses (not partial 206 responses)
        if (response.ok && response.status !== 206) {
            const cache = await caches.open(DYNAMIC_CACHE);
            cache.put(request, response.clone());
        }
        return response;
    } catch (error) {
        console.log('[SW] Network failed, no cache available:', request.url);
        // Return offline page for navigation requests
        if (request.mode === 'navigate') {
            const offlinePage = await caches.match('/offline');
            if (offlinePage) {
                return offlinePage;
            }
        }
        return new Response('Offline - Content not available', {
            status: 503,
            statusText: 'Service Unavailable'
        });
    }
}

// Handle mutation requests (POST, PUT, DELETE) - queue if offline
async function handleMutationRequest(request) {
    try {
        const response = await fetch(request.clone());
        return response;
    } catch (error) {
        console.log('[SW] Network failed for mutation, queueing:', request.url);

        // Queue the request for later sync
        const requestData = await serializeRequest(request);
        await queueRequest(requestData);

        // Return a response indicating the request was queued
        return new Response(JSON.stringify({
            queued: true,
            message: 'Your request has been saved and will be sent when you are back online.'
        }), {
            headers: { 'Content-Type': 'application/json' }
        });
    }
}

// Serialize a request for storage
async function serializeRequest(request) {
    const body = await request.text();
    return {
        url: request.url,
        method: request.method,
        headers: Object.fromEntries(request.headers.entries()),
        body: body,
        timestamp: Date.now()
    };
}

// Queue a request in IndexedDB
async function queueRequest(requestData) {
    const message = {
        type: 'QUEUE_REQUEST',
        payload: requestData
    };

    // Send message to all clients to store in IndexedDB
    const clients = await self.clients.matchAll();
    clients.forEach(client => client.postMessage(message));
}

// Background sync - process queued requests
self.addEventListener('sync', (event) => {
    console.log('[SW] Background sync triggered:', event.tag);

    if (event.tag === 'sync-queue') {
        event.waitUntil(syncQueuedRequests());
    }
});

// Process queued requests
async function syncQueuedRequests() {
    const message = { type: 'PROCESS_SYNC_QUEUE' };
    const clients = await self.clients.matchAll();
    clients.forEach(client => client.postMessage(message));
}

// Update cache in background
async function fetchAndCache(request) {
    try {
        const response = await fetch(request);
        // Only cache successful full responses (not partial 206 responses)
        if (response.ok && response.status !== 206) {
            const cache = await caches.open(DYNAMIC_CACHE);
            cache.put(request, response);
        }
    } catch (error) {
        // Silently fail background updates
    }
}

// Listen for messages from the main app
self.addEventListener('message', (event) => {
    if (event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }

    if (event.data.type === 'CACHE_URLS') {
        event.waitUntil(
            caches.open(DYNAMIC_CACHE).then(cache => {
                return cache.addAll(event.data.urls);
            })
        );
    }
});

// Push notification handler
self.addEventListener('push', (event) => {
    if (!event.data) return;

    const data = event.data.json();
    const options = {
        body: data.body || 'New notification from WaoBiz',
        icon: '/img/icons/icon-192x192.png',
        badge: '/img/icons/icon-72x72.png',
        vibrate: [100, 50, 100],
        data: {
            url: data.url || '/'
        }
    };

    event.waitUntil(
        self.registration.showNotification(data.title || 'WaoBiz', options)
    );
});

// Notification click handler
self.addEventListener('notificationclick', (event) => {
    event.notification.close();

    event.waitUntil(
        clients.openWindow(event.notification.data.url)
    );
});
