<?php

namespace Modules\Hms\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Superadmin\Entities\Subscription;

class EnableHmsModuleSeeder extends Seeder
{
    /**
     * Enable HMS module for the admin business subscription.
     *
     * @return void
     */
    public function run()
    {
        $businessId = 1; // Waobiz admin account

        // Get the active subscription for the business
        $subscription = Subscription::where('business_id', $businessId)
            ->where('status', 'approved')
            ->whereDate('end_date', '>=', now())
            ->first();

        if (!$subscription) {
            $this->command->error('No active subscription found for business ID: ' . $businessId);
            return;
        }

        // Get current package_details
        $packageDetails = $subscription->package_details ?? [];

        // Enable HMS module
        $packageDetails['hms_module'] = 1;

        // Update the subscription
        $subscription->package_details = $packageDetails;
        $subscription->save();

        $this->command->info('HMS module enabled successfully for business ID: ' . $businessId);
        $this->command->info('Subscription ID: ' . $subscription->id);
        $this->command->info('Package details updated: ' . json_encode($packageDetails));
    }
}
