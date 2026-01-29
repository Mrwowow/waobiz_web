<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use App\Contact;
use App\Category;
use App\Brand;
use App\TaxRate;
use App\BusinessLocation;
use Illuminate\Http\Request;

class OfflineCacheController extends Controller
{
    /**
     * Get products for offline caching
     */
    public function getProducts(Request $request)
    {
        $businessId = auth()->user()->business_id;
        $perPage = $request->input('per_page', 1000);

        $products = Product::where('business_id', $businessId)
            ->where('is_inactive', 0)
            ->with(['variations', 'product_tax', 'unit', 'category', 'brand'])
            ->select([
                'id', 'name', 'sku', 'type', 'unit_id', 'brand_id', 'category_id',
                'tax', 'tax_type', 'enable_stock', 'alert_quantity', 'image'
            ])
            ->take($perPage)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'type' => $product->type,
                    'category_id' => $product->category_id,
                    'category_name' => $product->category->name ?? null,
                    'brand_id' => $product->brand_id,
                    'brand_name' => $product->brand->name ?? null,
                    'unit_id' => $product->unit_id,
                    'unit_name' => $product->unit->short_name ?? null,
                    'tax_id' => $product->tax,
                    'tax_type' => $product->tax_type,
                    'image' => $product->image,
                    'variations' => $product->variations->map(function ($v) {
                        return [
                            'id' => $v->id,
                            'name' => $v->name,
                            'sub_sku' => $v->sub_sku,
                            'default_sell_price' => $v->default_sell_price,
                            'sell_price_inc_tax' => $v->sell_price_inc_tax,
                            'default_purchase_price' => $v->default_purchase_price,
                        ];
                    })
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $products,
            'meta' => [
                'total' => $products->count(),
                'cached_at' => now()->timestamp
            ]
        ]);
    }

    /**
     * Get contacts for offline caching
     */
    public function getContacts(Request $request)
    {
        $businessId = auth()->user()->business_id;
        $type = $request->input('type'); // customer, supplier, or both
        $perPage = $request->input('per_page', 1000);

        $query = Contact::where('business_id', $businessId)
            ->where('contact_status', 'active');

        if ($type) {
            $query->where('type', $type);
        }

        $contacts = $query->select([
            'id', 'type', 'name', 'mobile', 'email', 'tax_number',
            'city', 'state', 'country', 'address_line_1', 'address_line_2',
            'customer_group_id', 'credit_limit'
        ])
            ->take($perPage)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $contacts,
            'meta' => [
                'total' => $contacts->count(),
                'cached_at' => now()->timestamp
            ]
        ]);
    }

    /**
     * Get categories for offline caching
     */
    public function getCategories(Request $request)
    {
        $businessId = auth()->user()->business_id;

        $categories = Category::where('business_id', $businessId)
            ->select(['id', 'name', 'short_code', 'parent_id', 'category_type'])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
            'meta' => [
                'total' => $categories->count(),
                'cached_at' => now()->timestamp
            ]
        ]);
    }

    /**
     * Get brands for offline caching
     */
    public function getBrands(Request $request)
    {
        $businessId = auth()->user()->business_id;

        $brands = Brand::where('business_id', $businessId)
            ->select(['id', 'name', 'description'])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $brands,
            'meta' => [
                'total' => $brands->count(),
                'cached_at' => now()->timestamp
            ]
        ]);
    }

    /**
     * Get tax rates for offline caching
     */
    public function getTaxRates(Request $request)
    {
        $businessId = auth()->user()->business_id;

        $taxRates = TaxRate::where('business_id', $businessId)
            ->select(['id', 'name', 'amount', 'is_tax_group'])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $taxRates,
            'meta' => [
                'total' => $taxRates->count(),
                'cached_at' => now()->timestamp
            ]
        ]);
    }

    /**
     * Get business locations for offline caching
     */
    public function getBusinessLocations(Request $request)
    {
        $businessId = auth()->user()->business_id;

        $locations = BusinessLocation::where('business_id', $businessId)
            ->select([
                'id', 'name', 'landmark', 'city', 'state', 'country',
                'zip_code', 'mobile', 'email', 'invoice_scheme_id',
                'invoice_layout_id', 'default_payment_accounts'
            ])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $locations,
            'meta' => [
                'total' => $locations->count(),
                'cached_at' => now()->timestamp
            ]
        ]);
    }
}
