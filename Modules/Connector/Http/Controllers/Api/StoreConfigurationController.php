<?php

namespace Modules\Connector\Http\Controllers\Api;

use App\StoreConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

/**
 * @group Store Configuration
 *
 * APIs for managing public store configurations
 */
class StoreConfigurationController extends ApiController
{
    /**
     * Get store configuration by store name (Public - No Authentication)
     *
     * @urlParam storeName required The unique store name/slug Example: awesome-shop
     *
     * @response {
     *   "success": true,
     *   "data": {
     *     "id": 1,
     *     "business_id": 1,
     *     "store_name": "awesome-shop",
     *     "business_name": "Awesome Shop",
     *     "logo": "/uploads/store_logos/logo_123456.png",
     *     "logo_url": "http://example.com/uploads/store_logos/logo_123456.png",
     *     "banner": "/uploads/store_banners/banner_123456.jpg",
     *     "banner_url": "http://example.com/uploads/store_banners/banner_123456.jpg",
     *     "theme_color": "#f97316",
     *     "custom_css": ".store-header { color: red; }",
     *     "whatsapp_number": "+1234567890",
     *     "email": "contact@awesomeshop.com",
     *     "phone": "+1234567890",
     *     "address": "123 Main St, City, Country",
     *     "description": "Welcome to our online store",
     *     "currency": "NGN",
     *     "opening_hours": "09:00",
     *     "closing_hours": "18:00",
     *     "is_active": true,
     *     "social_media": {
     *       "facebook": "https://facebook.com/awesomeshop",
     *       "instagram": "@awesomeshop"
     *     },
     *     "payment_methods": ["cash", "card", "bank_transfer"],
     *     "delivery_options": {
     *       "pickup": true,
     *       "delivery": true,
     *       "deliveryFee": 500
     *     },
     *     "seo_title": "Awesome Shop - Best Products Online",
     *     "seo_description": "Shop the best products at Awesome Shop",
     *     "seo_keywords": "shop, products, online",
     *     "created_at": "2025-11-11T01:56:06.000000Z",
     *     "updated_at": "2025-11-11T01:56:06.000000Z"
     *   }
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Store not found"
     * }
     */
    public function getByStoreName($storeName)
    {
        try {
            $store = StoreConfiguration::where('store_name', $storeName)
                ->where('is_active', true)
                ->first();

            if (!$store) {
                return response()->json([
                    'success' => false,
                    'message' => 'Store not found'
                ], 404);
            }

            // Add full URLs for logo and banner (include custom_css for public)
            $storeData = $store->makeVisible('custom_css')->toArray();
            $storeData['logo_url'] = $store->logo ? url($store->logo) : null;
            $storeData['banner_url'] = $store->banner ? url($store->banner) : null;

            return response()->json([
                'success' => true,
                'data' => $storeData
            ]);
        } catch (\Exception $e) {
            return $this->otherExceptions($e);
        }
    }

    /**
     * Create store configuration (Admin - Authentication Required)
     *
     * @bodyParam business_id integer required The business ID Example: 1
     * @bodyParam store_name string required URL-safe store name (lowercase, hyphens only) Example: awesome-shop
     * @bodyParam business_name string required Display name of the business Example: Awesome Shop
     * @bodyParam logo file optional Logo image file (jpg, jpeg, png, gif, max 2MB)
     * @bodyParam banner file optional Banner image file (jpg, jpeg, png, gif, max 2MB)
     * @bodyParam theme_color string optional Hex color code Example: #f97316
     * @bodyParam whatsapp_number string optional WhatsApp contact number Example: +1234567890
     * @bodyParam email string optional Contact email Example: contact@awesomeshop.com
     * @bodyParam phone string optional Contact phone Example: +1234567890
     * @bodyParam address string optional Physical address Example: 123 Main St
     * @bodyParam description string optional Store description Example: Welcome to our store
     * @bodyParam currency string optional Currency code (ISO 4217) Example: NGN
     * @bodyParam opening_hours string optional Opening hours Example: 09:00
     * @bodyParam closing_hours string optional Closing hours Example: 18:00
     * @bodyParam is_active boolean optional Store active status Example: true
     * @bodyParam social_media string optional Social media links as JSON string Example: {"facebook": "https://facebook.com/page"}
     * @bodyParam payment_methods string optional Payment methods as JSON string Example: ["cash", "card"]
     * @bodyParam delivery_options string optional Delivery configuration as JSON string Example: {"pickup": true, "delivery": true, "deliveryFee": 500}
     * @bodyParam custom_css string optional Custom CSS for styling
     * @bodyParam seo_title string optional SEO page title Example: Awesome Shop
     * @bodyParam seo_description string optional SEO meta description
     * @bodyParam seo_keywords string optional SEO keywords
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Store configuration created successfully",
     *   "data": {
     *     "id": 1,
     *     "business_id": 1,
     *     "store_name": "awesome-shop",
     *     "business_name": "Awesome Shop",
     *     "logo": "/uploads/store_logos/logo_123456.png",
     *     "logo_url": "http://example.com/uploads/store_logos/logo_123456.png",
     *     "banner": "/uploads/store_banners/banner_123456.jpg",
     *     "banner_url": "http://example.com/uploads/store_banners/banner_123456.jpg"
     *   }
     * }
     *
     * @response 422 {
     *   "success": false,
     *   "message": "Validation error",
     *   "errors": {
     *     "store_name": ["The store name has already been taken."]
     *   }
     * }
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'business_id' => 'required|integer|unique:store_configurations,business_id',
                'store_name' => 'required|string|max:255|unique:store_configurations,store_name|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                'business_name' => 'required|string|max:255',
                'logo' => 'nullable|file|image|mimes:jpeg,jpg,png,gif|max:2048',
                'banner' => 'nullable|file|image|mimes:jpeg,jpg,png,gif|max:2048',
                'theme_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
                'whatsapp_number' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'description' => 'nullable|string',
                'currency' => 'nullable|string|size:3',
                'opening_hours' => 'nullable|string|max:50',
                'closing_hours' => 'nullable|string|max:50',
                'is_active' => 'nullable|boolean',
                'social_media' => 'nullable|string',
                'payment_methods' => 'nullable|string',
                'delivery_options' => 'nullable|string',
                'custom_css' => 'nullable|string',
                'seo_title' => 'nullable|string|max:255',
                'seo_description' => 'nullable|string',
                'seo_keywords' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            // Ensure store_name is URL-safe (lowercase with hyphens)
            $data['store_name'] = Str::slug($data['store_name']);

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $data['logo'] = $this->uploadFile($request->file('logo'), 'store_logos');
            }

            // Handle banner upload
            if ($request->hasFile('banner')) {
                $data['banner'] = $this->uploadFile($request->file('banner'), 'store_banners');
            }

            // Parse JSON fields if they're strings
            if (isset($data['social_media']) && is_string($data['social_media'])) {
                $data['social_media'] = json_decode($data['social_media'], true);
            }

            if (isset($data['payment_methods']) && is_string($data['payment_methods'])) {
                $data['payment_methods'] = json_decode($data['payment_methods'], true);
            }

            if (isset($data['delivery_options']) && is_string($data['delivery_options'])) {
                $data['delivery_options'] = json_decode($data['delivery_options'], true);
            }

            $storeConfig = StoreConfiguration::create($data);

            // Add URLs to response
            $responseData = $storeConfig->toArray();
            $responseData['logo_url'] = $storeConfig->logo ? url($storeConfig->logo) : null;
            $responseData['banner_url'] = $storeConfig->banner ? url($storeConfig->banner) : null;

            return response()->json([
                'success' => true,
                'message' => 'Store configuration created successfully',
                'data' => $responseData
            ], 201);
        } catch (\Exception $e) {
            return $this->otherExceptions($e);
        }
    }

    /**
     * Get store configuration by business ID (Admin - Authentication Required)
     *
     * This endpoint allows administrators to retrieve the complete store configuration
     * for a specific business, including all fields such as custom CSS and inactive stores.
     *
     * @authenticated
     * @urlParam business_id required The business ID Example: 30
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "id": 2,
     *     "business_id": 30,
     *     "store_name": "nailshop-lagos",
     *     "business_name": "NAILSHOP LAGOS",
     *     "logo": "/uploads/store_logos/1731423600_673316d0a1234.jpg",
     *     "logo_url": "http://localhost/uploads/store_logos/1731423600_673316d0a1234.jpg",
     *     "banner": "/uploads/store_banners/1731423600_673316d0b5678.jpg",
     *     "banner_url": "http://localhost/uploads/store_banners/1731423600_673316d0b5678.jpg",
     *     "theme_color": "#f97316",
     *     "custom_css": ".custom-header { background: blue; }",
     *     "whatsapp_number": "08105184157",
     *     "email": "houseofarastudio@yahoo.com",
     *     "phone": "08105184157",
     *     "address": "16, Odozi Street, Ojodu, Lagos, Nigeria",
     *     "description": "Head Office: 16, Odozie Street, Ojodu Berger. Branch Office: 53, Aina Street, Ojodu Berger, Lagos, Nigeria",
     *     "currency": "NGN",
     *     "opening_hours": "9:00 AM",
     *     "closing_hours": "10:00 PM",
     *     "is_active": true,
     *     "social_media": {
     *       "facebook": null,
     *       "instagram": null,
     *       "twitter": null
     *     },
     *     "payment_methods": [],
     *     "delivery_options": {
     *       "pickup": true,
     *       "delivery": true,
     *       "deliveryFee": 4000
     *     },
     *     "seo_title": "NAILSHOP LAGOS - Best Nail Services",
     *     "seo_description": "Professional nail services in Lagos",
     *     "seo_keywords": "nail salon, lagos, beauty",
     *     "created_at": "2025-11-12T14:19:15.000000Z",
     *     "updated_at": "2025-11-12T14:20:46.000000Z"
     *   }
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Store configuration not found"
     * }
     */
    public function getByBusinessId($business_id)
    {
        try {
            $store = StoreConfiguration::where('business_id', $business_id)->first();

            if (!$store) {
                return response()->json([
                    'success' => false,
                    'message' => 'Store configuration not found'
                ], 404);
            }

            // Add full URLs for logo and banner (include custom_css for admin)
            $storeData = $store->makeVisible('custom_css')->toArray();
            $storeData['logo_url'] = $store->logo ? url($store->logo) : null;
            $storeData['banner_url'] = $store->banner ? url($store->banner) : null;

            return response()->json([
                'success' => true,
                'data' => $storeData
            ]);
        } catch (\Exception $e) {
            return $this->otherExceptions($e);
        }
    }

    /**
     * Update store configuration (Admin - Authentication Required)
     *
     * @urlParam id required The store configuration ID Example: 1
     * @bodyParam store_name string optional URL-safe store name Example: awesome-shop
     * @bodyParam business_name string optional Display name Example: Awesome Shop
     * @bodyParam logo file optional Logo image file (jpg, jpeg, png, gif, max 2MB)
     * @bodyParam banner file optional Banner image file (jpg, jpeg, png, gif, max 2MB)
     * @bodyParam theme_color string optional Hex color code Example: #3b82f6
     * @bodyParam whatsapp_number string optional WhatsApp number Example: +1234567890
     * @bodyParam email string optional Email Example: contact@shop.com
     * @bodyParam phone string optional Phone Example: +1234567890
     * @bodyParam address string optional Address Example: 123 Main St
     * @bodyParam description string optional Description Example: Updated description
     * @bodyParam currency string optional Currency code Example: USD
     * @bodyParam opening_hours string optional Opening hours Example: 08:00
     * @bodyParam closing_hours string optional Closing hours Example: 20:00
     * @bodyParam is_active boolean optional Active status Example: true
     * @bodyParam social_media string optional Social media links as JSON string
     * @bodyParam payment_methods string optional Payment methods as JSON string
     * @bodyParam delivery_options string optional Delivery options as JSON string
     * @bodyParam custom_css string optional Custom CSS
     * @bodyParam seo_title string optional SEO title
     * @bodyParam seo_description string optional SEO description
     * @bodyParam seo_keywords string optional SEO keywords
     *
     * @response {
     *   "success": true,
     *   "message": "Store configuration updated successfully",
     *   "data": {
     *     "id": 1,
     *     "business_id": 1,
     *     "store_name": "awesome-shop",
     *     "business_name": "Awesome Shop Updated",
     *     "logo": "/uploads/store_logos/logo_123456.png",
     *     "logo_url": "http://example.com/uploads/store_logos/logo_123456.png",
     *     "banner": "/uploads/store_banners/banner_123456.jpg",
     *     "banner_url": "http://example.com/uploads/store_banners/banner_123456.jpg"
     *   }
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Store configuration not found"
     * }
     */
    public function update(Request $request, $id)
    {
        try {
            $storeConfig = StoreConfiguration::find($id);

            if (!$storeConfig) {
                return response()->json([
                    'success' => false,
                    'message' => 'Store configuration not found'
                ], 404);
            }

            // Log request data for debugging
            Log::info('Update request data:', ['all' => $request->all(), 'method' => $request->method()]);

            $validator = Validator::make($request->all(), [
                'store_name' => 'sometimes|string|max:255|unique:store_configurations,store_name,' . $id . '|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                'business_name' => 'sometimes|string|max:255',
                'logo' => 'nullable|file|image|mimes:jpeg,jpg,png,gif|max:2048',
                'banner' => 'nullable|file|image|mimes:jpeg,jpg,png,gif|max:2048',
                'theme_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
                'whatsapp_number' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'description' => 'nullable|string',
                'currency' => 'nullable|string|size:3',
                'opening_hours' => 'nullable|string|max:50',
                'closing_hours' => 'nullable|string|max:50',
                'is_active' => 'nullable',
                'social_media' => 'nullable',
                'payment_methods' => 'nullable',
                'delivery_options' => 'nullable',
                'custom_css' => 'nullable|string',
                'seo_title' => 'nullable|string|max:255',
                'seo_description' => 'nullable|string',
                'seo_keywords' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get only the fields that exist in the request
            $input = $request->except(['_method', '_token']);

            // Build update data array
            $updateData = [];

            $simpleFields = [
                'store_name', 'business_name', 'theme_color', 'whatsapp_number',
                'email', 'phone', 'address', 'description', 'currency',
                'opening_hours', 'closing_hours', 'is_active', 'custom_css',
                'seo_title', 'seo_description', 'seo_keywords'
            ];

            foreach ($simpleFields as $field) {
                if (array_key_exists($field, $input)) {
                    $updateData[$field] = $input[$field];
                }
            }

            // Ensure store_name is URL-safe if provided
            if (isset($updateData['store_name'])) {
                $updateData['store_name'] = Str::slug($updateData['store_name']);
            }

            // Handle is_active boolean conversion
            if (array_key_exists('is_active', $updateData)) {
                $updateData['is_active'] = filter_var($updateData['is_active'], FILTER_VALIDATE_BOOLEAN);
            }

            // Handle logo upload
            if ($request->hasFile('logo')) {
                if ($storeConfig->logo) {
                    $this->deleteFile($storeConfig->logo);
                }
                $updateData['logo'] = $this->uploadFile($request->file('logo'), 'store_logos');
            }

            // Handle banner upload
            if ($request->hasFile('banner')) {
                if ($storeConfig->banner) {
                    $this->deleteFile($storeConfig->banner);
                }
                $updateData['banner'] = $this->uploadFile($request->file('banner'), 'store_banners');
            }

            // Handle JSON fields
            if (array_key_exists('social_media', $input)) {
                $socialMedia = $input['social_media'];
                $updateData['social_media'] = is_string($socialMedia) ? json_decode($socialMedia, true) : $socialMedia;
            }

            if (array_key_exists('payment_methods', $input)) {
                $paymentMethods = $input['payment_methods'];
                $updateData['payment_methods'] = is_string($paymentMethods) ? json_decode($paymentMethods, true) : $paymentMethods;
            }

            if (array_key_exists('delivery_options', $input)) {
                $deliveryOptions = $input['delivery_options'];
                $updateData['delivery_options'] = is_string($deliveryOptions) ? json_decode($deliveryOptions, true) : $deliveryOptions;
            }

            // Log what we're updating
            Log::info('Update data:', $updateData);

            // Perform the update
            if (!empty($updateData)) {
                $storeConfig->fill($updateData);
                $saved = $storeConfig->save();
                Log::info('Save result:', ['saved' => $saved, 'updated' => $storeConfig->getChanges()]);
            }

            // Refresh the model
            $storeConfig = $storeConfig->fresh();

            // Add URLs to response
            $responseData = $storeConfig->toArray();
            $responseData['logo_url'] = $storeConfig->logo ? url($storeConfig->logo) : null;
            $responseData['banner_url'] = $storeConfig->banner ? url($storeConfig->banner) : null;

            return response()->json([
                'success' => true,
                'message' => 'Store configuration updated successfully',
                'data' => $responseData
            ]);
        } catch (\Exception $e) {
            Log::error('Update error:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return $this->otherExceptions($e);
        }
    }

    /**
     * Upload file to public directory
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @return string
     */
    private function uploadFile($file, $directory)
    {
        $uploadPath = public_path('uploads/' . $directory);

        // Create directory if it doesn't exist
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Move file to public directory
        $file->move($uploadPath, $filename);

        // Return relative path
        return '/uploads/' . $directory . '/' . $filename;
    }

    /**
     * Delete file from public directory
     *
     * @param string $path
     * @return bool
     */
    private function deleteFile($path)
    {
        $fullPath = public_path($path);

        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }

        return false;
    }
}
