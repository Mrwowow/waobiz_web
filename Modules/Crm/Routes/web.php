<?php

use Illuminate\Support\Facades\Route;
use Modules\Crm\Http\Controllers\CrmController;
use Modules\Crm\Http\Controllers\DataController;
use Modules\Crm\Http\Controllers\InstallController;
use Modules\Crm\Http\Controllers\LeadController;
use Modules\Crm\Http\Controllers\ScheduleController;
use Modules\Crm\Http\Controllers\CampaignController;
use Modules\Crm\Http\Controllers\ContactLoginController;
use Modules\Crm\Http\Controllers\SourceController;
use Modules\Crm\Http\Controllers\LifeStageController;
use Modules\Crm\Http\Controllers\ProposalController;
use Modules\Crm\Http\Controllers\ReportController;

Route::middleware(['web', 'authh', 'auth', 'SetSessionData', 'language', 'timezone', 'AdminSidebarMenu'])
    ->prefix('crm')
    ->group(function () {
        // Installation routes
        Route::get('/install', [InstallController::class, 'index']);
        Route::post('/install', [InstallController::class, 'install']);
        Route::get('/install/uninstall', [InstallController::class, 'uninstall']);
        Route::get('/install/update', [InstallController::class, 'update']);

        // Main CRM dashboard
        Route::get('/', [CrmController::class, 'index'])->name('crm.index');

        // Schedules / Follow-ups
        Route::resource('schedules', ScheduleController::class);
        Route::get('schedules/get-followups', [ScheduleController::class, 'getFollowups'])->name('crm.schedules.get-followups');
        Route::post('schedules/update-status/{id}', [ScheduleController::class, 'updateStatus'])->name('crm.schedules.update-status');

        // Leads
        Route::resource('leads', LeadController::class);
        Route::get('leads-kanban', [LeadController::class, 'kanban'])->name('crm.leads.kanban');
        Route::post('leads/convert-to-customer/{id}', [LeadController::class, 'convertToCustomer'])->name('crm.leads.convert');
        Route::post('leads/update-life-stage/{id}', [LeadController::class, 'updateLifeStage'])->name('crm.leads.update-life-stage');
        Route::get('leads/get-leads', [LeadController::class, 'getLeads'])->name('crm.leads.get-leads');

        // Campaigns
        Route::resource('campaigns', CampaignController::class);
        Route::post('campaigns/send-notification/{id}', [CampaignController::class, 'sendNotification'])->name('crm.campaigns.send');
        Route::get('campaigns/get-campaigns', [CampaignController::class, 'getCampaigns'])->name('crm.campaigns.get-campaigns');

        // Contact Login
        Route::resource('contacts-login', ContactLoginController::class);
        Route::get('contacts-login/get-contacts', [ContactLoginController::class, 'getContacts'])->name('crm.contacts-login.get-contacts');

        // Sources
        Route::resource('sources', SourceController::class);
        Route::get('sources/get-sources', [SourceController::class, 'getSources'])->name('crm.sources.get-sources');

        // Life Stages
        Route::resource('life-stages', LifeStageController::class);
        Route::get('life-stages/get-life-stages', [LifeStageController::class, 'getLifeStages'])->name('crm.life-stages.get-life-stages');

        // Proposals
        Route::resource('proposals', ProposalController::class);
        Route::post('proposals/send/{id}', [ProposalController::class, 'send'])->name('crm.proposals.send');
        Route::get('proposals/get-proposals', [ProposalController::class, 'getProposals'])->name('crm.proposals.get-proposals');

        // Reports
        Route::get('reports', [ReportController::class, 'index'])->name('crm.reports.index');
        Route::get('reports/followups-by-user', [ReportController::class, 'followupsByUser'])->name('crm.reports.followups-by-user');
        Route::get('reports/followups-by-contacts', [ReportController::class, 'followupsByContacts'])->name('crm.reports.followups-by-contacts');
        Route::get('reports/lead-conversion', [ReportController::class, 'leadConversion'])->name('crm.reports.lead-conversion');
    });

// Contact login portal routes (separate auth)
Route::middleware(['web', 'SetSessionData', 'language', 'timezone'])
    ->prefix('contact')
    ->group(function () {
        Route::get('/home', [ContactLoginController::class, 'home'])->name('contact.home');
        Route::get('/sales', [ContactLoginController::class, 'sales'])->name('contact.sales');
        Route::get('/ledger', [ContactLoginController::class, 'ledger'])->name('contact.ledger');
        Route::get('/bookings', [ContactLoginController::class, 'bookings'])->name('contact.bookings');
    });
