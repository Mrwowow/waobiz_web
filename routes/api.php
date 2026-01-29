<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| PWA Offline Sync Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:api'])->prefix('offline')->group(function () {
    // Sync offline sales
    Route::post('/sales/sync', 'App\Http\Controllers\Api\OfflineSyncController@syncSale');

    // Batch sync multiple sales
    Route::post('/sales/sync-batch', 'App\Http\Controllers\Api\OfflineSyncController@syncSalesBatch');

    // Get sync status
    Route::get('/status', 'App\Http\Controllers\Api\OfflineSyncController@getSyncStatus');
});

// Public API endpoints for offline data caching
// Uses web middleware for session-based authentication
Route::middleware(['web', 'auth'])->prefix('cache')->group(function () {
    Route::get('/products', 'App\Http\Controllers\Api\OfflineCacheController@getProducts');
    Route::get('/contacts', 'App\Http\Controllers\Api\OfflineCacheController@getContacts');
    Route::get('/categories', 'App\Http\Controllers\Api\OfflineCacheController@getCategories');
    Route::get('/brands', 'App\Http\Controllers\Api\OfflineCacheController@getBrands');
    Route::get('/tax-rates', 'App\Http\Controllers\Api\OfflineCacheController@getTaxRates');
    Route::get('/business-locations', 'App\Http\Controllers\Api\OfflineCacheController@getBusinessLocations');
});
