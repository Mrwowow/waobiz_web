<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Transaction;
use App\TransactionSellLine;
use App\Utils\TransactionUtil;
use App\Utils\ProductUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OfflineSyncController extends Controller
{
    protected $transactionUtil;
    protected $productUtil;

    public function __construct(TransactionUtil $transactionUtil, ProductUtil $productUtil)
    {
        $this->transactionUtil = $transactionUtil;
        $this->productUtil = $productUtil;
    }

    /**
     * Sync a single offline sale
     */
    public function syncSale(Request $request)
    {
        try {
            $saleData = $request->all();
            $businessId = auth()->user()->business_id;

            // Check for duplicate using localId
            if (!empty($saleData['localId'])) {
                $existing = Transaction::where('business_id', $businessId)
                    ->where('additional_notes', 'LIKE', '%' . $saleData['localId'] . '%')
                    ->first();

                if ($existing) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Sale already synced',
                        'data' => [
                            'id' => $existing->id,
                            'invoice_no' => $existing->invoice_no,
                            'already_synced' => true
                        ]
                    ]);
                }
            }

            DB::beginTransaction();

            // Process the sale using existing transaction utility
            $result = $this->processSale($saleData, $businessId);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sale synced successfully',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Offline sync failed: ' . $e->getMessage(), [
                'sale_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Sync failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Sync multiple offline sales in batch
     */
    public function syncSalesBatch(Request $request)
    {
        $sales = $request->input('sales', []);
        $results = [];
        $successCount = 0;
        $failCount = 0;

        foreach ($sales as $saleData) {
            try {
                $businessId = auth()->user()->business_id;

                // Check for duplicate
                if (!empty($saleData['localId'])) {
                    $existing = Transaction::where('business_id', $businessId)
                        ->where('additional_notes', 'LIKE', '%' . $saleData['localId'] . '%')
                        ->first();

                    if ($existing) {
                        $results[] = [
                            'localId' => $saleData['localId'],
                            'success' => true,
                            'already_synced' => true,
                            'server_id' => $existing->id
                        ];
                        $successCount++;
                        continue;
                    }
                }

                DB::beginTransaction();
                $result = $this->processSale($saleData, $businessId);
                DB::commit();

                $results[] = [
                    'localId' => $saleData['localId'] ?? null,
                    'success' => true,
                    'server_id' => $result['id'] ?? null,
                    'invoice_no' => $result['invoice_no'] ?? null
                ];
                $successCount++;
            } catch (\Exception $e) {
                DB::rollBack();
                $results[] = [
                    'localId' => $saleData['localId'] ?? null,
                    'success' => false,
                    'error' => $e->getMessage()
                ];
                $failCount++;

                Log::error('Batch sync item failed: ' . $e->getMessage(), [
                    'sale_data' => $saleData
                ]);
            }
        }

        return response()->json([
            'success' => $failCount === 0,
            'message' => "Synced {$successCount} sales, {$failCount} failed",
            'results' => $results,
            'summary' => [
                'total' => count($sales),
                'success' => $successCount,
                'failed' => $failCount
            ]
        ]);
    }

    /**
     * Get sync status
     */
    public function getSyncStatus(Request $request)
    {
        $businessId = auth()->user()->business_id;

        // Get last sync timestamp from request or default to 24 hours ago
        $lastSync = $request->input('last_sync', now()->subDay()->timestamp);

        // Get counts of new/updated data since last sync
        $newTransactions = Transaction::where('business_id', $businessId)
            ->where('created_at', '>', date('Y-m-d H:i:s', $lastSync))
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'server_time' => now()->timestamp,
                'new_transactions' => $newTransactions,
                'sync_required' => $newTransactions > 0
            ]
        ]);
    }

    /**
     * Process a sale transaction
     */
    protected function processSale(array $saleData, $businessId)
    {
        $userId = auth()->user()->id;
        $locationId = $saleData['location_id'] ?? auth()->user()->business->locations->first()->id;

        // Prepare transaction data
        $transactionData = [
            'business_id' => $businessId,
            'location_id' => $locationId,
            'type' => 'sell',
            'status' => $saleData['status'] ?? 'final',
            'contact_id' => $saleData['contact_id'] ?? null,
            'transaction_date' => $saleData['transaction_date'] ?? now(),
            'created_by' => $userId,
            'discount_type' => $saleData['discount_type'] ?? 'fixed',
            'discount_amount' => $saleData['discount_amount'] ?? 0,
            'tax_id' => $saleData['tax_id'] ?? null,
            'tax_amount' => $saleData['tax_amount'] ?? 0,
            'total_before_tax' => $saleData['total_before_tax'] ?? 0,
            'final_total' => $saleData['final_total'] ?? 0,
            'additional_notes' => ($saleData['additional_notes'] ?? '') . ' [Offline: ' . ($saleData['localId'] ?? 'unknown') . ']',
            'is_direct_sale' => 1,
        ];

        // Generate invoice number
        $transactionData['invoice_no'] = $this->transactionUtil->getInvoiceNumber($businessId, 'final', $locationId);

        // Create the transaction
        $transaction = Transaction::create($transactionData);

        // Process sell lines
        if (!empty($saleData['products'])) {
            foreach ($saleData['products'] as $product) {
                $sellLine = [
                    'transaction_id' => $transaction->id,
                    'product_id' => $product['product_id'],
                    'variation_id' => $product['variation_id'] ?? $product['product_id'],
                    'quantity' => $product['quantity'],
                    'unit_price' => $product['unit_price'],
                    'unit_price_inc_tax' => $product['unit_price_inc_tax'] ?? $product['unit_price'],
                    'line_discount_type' => $product['discount_type'] ?? 'fixed',
                    'line_discount_amount' => $product['discount_amount'] ?? 0,
                    'item_tax' => $product['tax'] ?? 0,
                ];

                TransactionSellLine::create($sellLine);

                // Update stock if needed
                if ($transaction->status === 'final') {
                    $this->productUtil->decreaseProductQuantity(
                        $product['product_id'],
                        $product['variation_id'] ?? $product['product_id'],
                        $locationId,
                        $product['quantity']
                    );
                }
            }
        }

        // Process payment if provided
        if (!empty($saleData['payment'])) {
            $paymentData = [
                'amount' => $saleData['payment']['amount'] ?? $transaction->final_total,
                'method' => $saleData['payment']['method'] ?? 'cash',
                'note' => $saleData['payment']['note'] ?? 'Offline payment',
            ];

            $this->transactionUtil->createOrUpdatePaymentLines($transaction, [$paymentData]);
            $this->transactionUtil->updatePaymentStatus($transaction->id, $transaction->final_total);
        }

        return [
            'id' => $transaction->id,
            'invoice_no' => $transaction->invoice_no,
            'final_total' => $transaction->final_total
        ];
    }
}
