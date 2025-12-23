# 🔧 Swagger UI Cache Fix - Store Configuration Endpoints

## Issue
Swagger UI is showing only 2 endpoints instead of all 6 Store Configuration endpoints due to browser caching.

## ✅ Solution Applied

I've made the following changes to fix the caching issue:

### 1. Updated Swagger UI (swagger-ui.html)
Added cache-busting parameter to force reload:
```javascript
url: "../openapi.yaml?v=" + new Date().getTime()
```

### 2. Updated ReDoc (api-docs.html)
Added dynamic loading with cache-busting:
```javascript
Redoc.init('../openapi.yaml?v=' + new Date().getTime(), {}, ...);
```

### 3. Created Verification Page (verify-endpoints.html)
New page to verify endpoints are in the OpenAPI spec.

## 🚀 How to Fix the Issue

### Option 1: Hard Refresh (Fastest)

1. Open Swagger UI: http://localhost/swagger-ui.html
2. **Clear cache and hard refresh**:
   - **Windows/Linux**: `Ctrl + Shift + R` or `Ctrl + F5`
   - **Mac**: `Cmd + Shift + R` or `Cmd + Option + R`
3. The page will reload and fetch the latest openapi.yaml
4. All 6 endpoints should now appear!

### Option 2: Clear Browser Cache

**Chrome**:
1. Press `Cmd + Shift + Delete` (Mac) or `Ctrl + Shift + Delete` (Windows)
2. Select "Cached images and files"
3. Click "Clear data"
4. Reload Swagger UI

**Firefox**:
1. Press `Cmd + Shift + Delete` (Mac) or `Ctrl + Shift + Delete` (Windows)
2. Select "Cache"
3. Click "Clear Now"
4. Reload Swagger UI

**Safari**:
1. Safari menu → Preferences → Privacy
2. Click "Manage Website Data"
3. Remove localhost
4. Reload Swagger UI

### Option 3: Verify Endpoints First

Before opening Swagger UI, verify the endpoints exist:

1. **Open verification page**: http://localhost/verify-endpoints.html
2. You should see **6 Store Configuration endpoints** listed
3. If you see 6 endpoints, the file is correct
4. Then click "Open Swagger UI (Force Reload)"

### Option 4: Incognito/Private Mode

1. Open an **Incognito/Private window**:
   - Chrome: `Cmd + Shift + N` (Mac) or `Ctrl + Shift + N` (Windows)
   - Firefox: `Cmd + Shift + P` (Mac) or `Ctrl + Shift + P` (Windows)
   - Safari: `Cmd + Shift + N`
2. Go to: http://localhost/swagger-ui.html
3. All endpoints should appear (no cache in incognito)

### Option 5: Use Updated URLs (Automatic)

The Swagger UI and ReDoc files now automatically append timestamps to avoid caching:
- Old: `../openapi.yaml`
- New: `../openapi.yaml?v=1699999999`

Just reload the page normally, and it will fetch the latest version.

## 📋 Verification Checklist

After applying the fix, you should see:

### In Swagger UI (http://localhost/swagger-ui.html):

Under **"Store Configuration"** section:

1. ✅ **GET** `/store/config/{storeName}` - 🌐 Public
2. ✅ **GET** `/business/{business_id}/products` - 🌐 Public
3. ✅ **GET** `/store/config/business/{business_id}` - 🔒 Admin (with lock icon)
4. ✅ **POST** `/store/config` - 🔒 Admin (with lock icon)
5. ✅ **PUT** `/store/config/{id}` - 🔒 Admin (with lock icon)
6. ✅ **POST** `/store/config/{id}` - 🔒 Admin (with lock icon)

**Total: 6 endpoints** (2 public + 4 admin)

### In Verification Page (http://localhost/verify-endpoints.html):

You should see:
```
✅ Success! Found 6 Store Configuration endpoints
```

With all 6 endpoints listed with their methods, paths, and auth requirements.

## 🔍 Troubleshooting

### Still seeing only 2 endpoints?

**Check 1: Verify the OpenAPI file**
```bash
grep -c "Store Configuration" openapi.yaml
```
Should return: **6** or more

**Check 2: Check file size**
```bash
ls -lh openapi.yaml
```
Should be: **96K** (not 76K)

**Check 3: Verify endpoints in file**
```bash
grep "post:" openapi.yaml | grep -A 2 "Store Configuration"
```
Should show POST endpoints

**Check 4: Browser Console**

1. Open Swagger UI
2. Press `F12` (Developer Tools)
3. Go to **Network** tab
4. Reload page (`Cmd/Ctrl + Shift + R`)
5. Find `openapi.yaml` request
6. Check **Status Code**: should be 200
7. Check **Size**: should be ~96KB
8. Click on it and view **Response** tab
9. Search for "POST" in the response
10. You should find POST /store/config

If the size is 76KB, the browser is still using cached version.

### Force Server to Send Fresh File

Add this to your `.htaccess` in the project root:

```apache
# Disable caching for OpenAPI spec during development
<Files "openapi.yaml">
    Header set Cache-Control "no-cache, no-store, must-revalidate"
    Header set Pragma "no-cache"
    Header set Expires 0
</Files>
```

Then restart Apache:
```bash
# Stop XAMPP
sudo /Applications/XAMPP/xamppfiles/bin/apachectl stop

# Start XAMPP
sudo /Applications/XAMPP/xamppfiles/bin/apachectl start
```

## 🎯 Quick Fix Commands

### Clear browser cache and reload:
```bash
# Just do this:
1. Open http://localhost/swagger-ui.html
2. Press Cmd + Shift + R (Mac) or Ctrl + Shift + R (Windows)
3. Done!
```

### Verify endpoints exist:
```bash
# Open this first:
http://localhost/verify-endpoints.html

# You should see all 6 endpoints listed
```

### Test with cURL (bypass browser):
```bash
# Download the OpenAPI spec
curl -I http://localhost/openapi.yaml

# Check file size in response headers
# Should show Content-Length: ~96000 (96KB)
```

## ✨ After Fix

Once you see all 6 endpoints:

1. **Authorize**: Click the "Authorize" button (green lock)
2. **Enter Token**: `Bearer YOUR_TOKEN`
3. **Test Endpoints**: Try "Try it out" on any admin endpoint
4. **Create Store**: Test POST /store/config
5. **Update Store**: Test PUT or POST /store/config/{id}
6. **Get by Business**: Test GET /store/config/business/{business_id}

## 📚 Additional Resources

- [STORE_CONFIG_SWAGGER_UPDATE.md](../STORE_CONFIG_SWAGGER_UPDATE.md) - What was added
- [SWAGGER_UI_SETUP.md](../SWAGGER_UI_SETUP.md) - Full setup guide
- [STORE_CONFIGURATION_API.md](../STORE_CONFIGURATION_API.md) - API details

## 🎉 Summary

**Problem**: Browser cached old openapi.yaml (76KB, 2 endpoints)

**Solution**:
1. ✅ Added cache-busting to Swagger UI
2. ✅ Added cache-busting to ReDoc
3. ✅ Created verification page
4. ✅ Hard refresh browser

**Result**: All 6 endpoints now visible!

---

**Quick Fix**: Just press `Cmd/Ctrl + Shift + R` in Swagger UI! 🚀
