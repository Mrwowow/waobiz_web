<?php

namespace Modules\Crm\Http\Controllers;

use App\System;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class InstallController extends Controller
{
    /**
     * Module name
     */
    protected $module_name = 'crm';

    /**
     * Application version
     */
    protected $appVersion;

    /**
     * Module display name
     */
    protected $module_display_name = 'CRM';

    public function __construct()
    {
        $this->appVersion = config('crm.module_version');
    }

    /**
     * Display module installation page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        $module = System::getProperty($this->module_name . '_version');

        if (!empty($module)) {
            return redirect()->back();
        }

        return view('crm::install.index');
    }

    /**
     * Install the module.
     *
     * @return \Illuminate\Http\Response
     */
    public function install(Request $request)
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            // Run module migrations
            Artisan::call('module:migrate', ['module' => 'Crm', '--force' => true]);

            // Store module version
            System::addProperty($this->module_name . '_version', $this->appVersion);

            // Seed default data
            $this->seedDefaultData();

            DB::commit();

            $output = [
                'success' => true,
                'msg' => __('crm::lang.module_installed_successfully'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $output = [
                'success' => false,
                'msg' => $e->getMessage(),
            ];
        }

        return redirect()
            ->action([\App\Http\Controllers\Install\ModulesController::class, 'index'])
            ->with('status', $output);
    }

    /**
     * Uninstall the module.
     *
     * @return \Illuminate\Http\Response
     */
    public function uninstall()
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Remove module version from system
            System::removeProperty($this->module_name . '_version');

            $output = [
                'success' => true,
                'msg' => __('crm::lang.module_uninstalled_successfully'),
            ];
        } catch (\Exception $e) {
            $output = [
                'success' => false,
                'msg' => $e->getMessage(),
            ];
        }

        return redirect()
            ->action([\App\Http\Controllers\Install\ModulesController::class, 'index'])
            ->with('status', $output);
    }

    /**
     * Update the module.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            // Run module migrations
            Artisan::call('module:migrate', ['module' => 'Crm', '--force' => true]);

            // Update module version
            System::setProperty($this->module_name . '_version', $this->appVersion);

            DB::commit();

            $output = [
                'success' => true,
                'msg' => __('crm::lang.module_updated_successfully'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $output = [
                'success' => false,
                'msg' => $e->getMessage(),
            ];
        }

        return redirect()
            ->action([\App\Http\Controllers\Install\ModulesController::class, 'index'])
            ->with('status', $output);
    }

    /**
     * Seed default data for the module.
     */
    private function seedDefaultData()
    {
        // Default life stages will be created per business when needed
        // Default sources will be created per business when needed
    }
}
