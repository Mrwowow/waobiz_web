@extends('layouts.app')

@section('title', __('crm::lang.crm_module'))

@section('content')
<section class="content-header">
    <h1>
        <span class="tw-text-xl tw-font-bold tw-text-white">@lang('crm::lang.crm_module')</span>
    </h1>
</section>

<section class="content">
    <div class="tw-max-w-2xl tw-mx-auto">
        <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-border tw-border-gray-700/50">
            <div class="tw-p-6 tw-text-center">
                <div class="tw-w-20 tw-h-20 tw-mx-auto tw-mb-4 tw-rounded-full tw-bg-orange-500/20 tw-flex tw-items-center tw-justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tw-text-orange-400">
                        <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                        <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                        <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                        <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                        <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                        <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                    </svg>
                </div>

                <h2 class="tw-text-2xl tw-font-bold tw-text-white tw-mb-2">@lang('crm::lang.crm_module')</h2>
                <p class="tw-text-gray-400 tw-mb-6">Customer Relationship Management</p>

                <div class="tw-text-left tw-mb-6">
                    <h3 class="tw-text-lg tw-font-semibold tw-text-white tw-mb-3">Features:</h3>
                    <ul class="tw-space-y-2 tw-text-gray-300">
                        <li class="tw-flex tw-items-center">
                            <i class="fas fa-check tw-text-green-400 tw-mr-2"></i>
                            Follow-ups with Leads, Customers & Suppliers
                        </li>
                        <li class="tw-flex tw-items-center">
                            <i class="fas fa-check tw-text-green-400 tw-mr-2"></i>
                            One-time & Recurring Follow-ups
                        </li>
                        <li class="tw-flex tw-items-center">
                            <i class="fas fa-check tw-text-green-400 tw-mr-2"></i>
                            Lead Management with Kanban View
                        </li>
                        <li class="tw-flex tw-items-center">
                            <i class="fas fa-check tw-text-green-400 tw-mr-2"></i>
                            Convert Leads to Customers
                        </li>
                        <li class="tw-flex tw-items-center">
                            <i class="fas fa-check tw-text-green-400 tw-mr-2"></i>
                            Email & SMS Campaigns
                        </li>
                        <li class="tw-flex tw-items-center">
                            <i class="fas fa-check tw-text-green-400 tw-mr-2"></i>
                            Contact Login Portal
                        </li>
                        <li class="tw-flex tw-items-center">
                            <i class="fas fa-check tw-text-green-400 tw-mr-2"></i>
                            Proposals & Templates
                        </li>
                        <li class="tw-flex tw-items-center">
                            <i class="fas fa-check tw-text-green-400 tw-mr-2"></i>
                            CRM Reports
                        </li>
                    </ul>
                </div>

                {!! Form::open(['url' => url('crm/install'), 'method' => 'POST']) !!}
                    <button type="submit" class="tw-dw-btn tw-dw-btn-primary tw-dw-btn-lg tw-w-full">
                        <i class="fas fa-download tw-mr-2"></i> Install Module
                    </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection
