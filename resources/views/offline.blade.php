<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offline - WaoBiz</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e5e7eb;
        }
        .offline-container {
            text-align: center;
            padding: 40px;
            max-width: 500px;
        }
        .offline-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .offline-icon svg {
            width: 60px;
            height: 60px;
            fill: #f59e0b;
        }
        h1 {
            font-size: 28px;
            margin-bottom: 15px;
            color: #fff;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
            color: #9ca3af;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #3c8dbc;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background: #2d6d96;
        }
        .btn-secondary {
            background: transparent;
            border: 2px solid #3c8dbc;
            margin-left: 10px;
        }
        .btn-secondary:hover {
            background: rgba(60, 141, 188, 0.1);
        }
        .status {
            margin-top: 30px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
        }
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #ef4444;
            margin-right: 8px;
            animation: pulse 2s infinite;
        }
        .status-indicator.online {
            background: #22c55e;
            animation: none;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .pending-info {
            margin-top: 20px;
            font-size: 14px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="offline-container">
        <div class="offline-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" fill="none"/>
                <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4c-1.48 0-2.85.43-4.01 1.17l1.46 1.46C10.21 6.23 11.08 6 12 6c3.04 0 5.5 2.46 5.5 5.5v.5H19c1.66 0 3 1.34 3 3 0 1.13-.64 2.11-1.56 2.62l1.45 1.45C23.16 18.16 24 16.68 24 15c0-2.64-2.05-4.78-4.65-4.96zM3 5.27l2.75 2.74C2.56 8.15 0 10.77 0 14c0 3.31 2.69 6 6 6h11.73l2 2L21 20.73 4.27 4 3 5.27zM7.73 10l8 8H6c-2.21 0-4-1.79-4-4s1.79-4 4-4h1.73z"/>
            </svg>
        </div>
        <h1>You're Offline</h1>
        <p>It looks like you've lost your internet connection. Don't worry - any changes you've made will be saved and synced when you're back online.</p>

        <button class="btn" onclick="tryReconnect()">Try Again</button>
        <a href="/pos/create" class="btn btn-secondary">Open POS (Offline)</a>

        <div class="status">
            <span class="status-indicator" id="status-indicator"></span>
            <span id="status-text">Waiting for connection...</span>
        </div>

        <div class="pending-info" id="pending-info"></div>
    </div>

    <script>
        function tryReconnect() {
            window.location.reload();
        }

        // Check connection status
        function updateStatus() {
            const indicator = document.getElementById('status-indicator');
            const statusText = document.getElementById('status-text');

            if (navigator.onLine) {
                indicator.classList.add('online');
                statusText.textContent = 'Connection restored! Redirecting...';
                setTimeout(() => {
                    window.location.href = '/';
                }, 1500);
            } else {
                indicator.classList.remove('online');
                statusText.textContent = 'Waiting for connection...';
            }
        }

        // Check pending items
        async function checkPendingItems() {
            if (typeof WaoBizOfflineDB !== 'undefined') {
                await WaoBizOfflineDB.init();
                const stats = await WaoBizOfflineDB.getStats();
                const pendingInfo = document.getElementById('pending-info');

                if (stats.pendingSales > 0 || stats.syncQueue > 0) {
                    pendingInfo.textContent = `${stats.pendingSales || 0} pending sales and ${stats.syncQueue || 0} queued actions will sync when online.`;
                }
            }
        }

        window.addEventListener('online', updateStatus);
        window.addEventListener('offline', updateStatus);

        updateStatus();
        checkPendingItems();
    </script>
</body>
</html>
