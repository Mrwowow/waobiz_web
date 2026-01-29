@php
    $is_mobile = isMobile();
@endphp

<style>
    .pos-action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
        background: transparent !important;
        border: none;
        cursor: pointer;
        padding: 0.5rem;
        min-width: fit-content;
        transition: opacity 0.2s ease;
    }
    .pos-action-btn:hover {
        opacity: 0.8;
    }
    .pos-action-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .pos-action-btn i {
        font-size: 1.25rem;
    }
    .pos-action-btn span {
        color: #e2e8f0 !important;
        font-weight: 600;
        font-size: 0.75rem;
        white-space: nowrap;
    }
    @media (min-width: 768px) {
        .pos-action-btn i {
            font-size: 1.5rem;
        }
        .pos-action-btn span {
            font-size: 0.875rem;
        }
    }
    .pos-primary-btn {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: none;
        border-radius: 0.375rem;
        padding: 0.5rem 1rem;
        cursor: pointer;
        font-weight: 700;
        font-size: 0.75rem;
        transition: opacity 0.2s ease, transform 0.1s ease;
    }
    .pos-primary-btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }
    .pos-primary-btn:active {
        transform: translateY(0);
    }
    .pos-primary-btn i,
    .pos-primary-btn span {
        color: #ffffff !important;
    }
    @media (min-width: 768px) {
        .pos-primary-btn {
            font-size: 0.875rem;
            padding: 0.625rem 1.25rem;
        }
    }
    .pos-btn-navy { background-color: #001F3E !important; }
    .pos-btn-green { background-color: #28b77b !important; }
    .pos-btn-red { background-color: #dc2626 !important; }
    .pos-btn-purple { background-color: #646EE4 !important; }
    .pos-btn-purple:hover { background-color: #414aac !important; }

    .pos-total-label {
        color: #e2e8f0 !important;
        font-weight: 700;
        font-size: 0.875rem;
        line-height: 1.2;
    }
    .pos-total-amount {
        color: #4ade80 !important;
        font-weight: 700;
        font-size: 1.25rem;
    }
    @media (min-width: 768px) {
        .pos-total-label {
            font-size: 1.25rem;
        }
        .pos-total-amount {
            font-size: 1.5rem;
        }
    }
</style>

<div class="row">
    <div class="pos-form-actions tw-rounded-t-xl tw-shadow-lg tw-py-3 tw-px-4" style="background-color: #1e293b !important;">

        {{-- Mobile Layout (< 768px) --}}
        <div class="tw-flex md:tw-hidden tw-flex-col tw-gap-3">

            {{-- Row 1: Total Payable (left) + Recent Transactions (right) --}}
            <div class="tw-flex tw-items-center tw-justify-between">
                <div class="tw-flex tw-items-center tw-gap-2">
                    <span class="pos-total-label">@lang('sale.total_payable'):</span>
                    <input type="hidden" name="final_total" id="final_total_input" value="0.00">
                    <span id="total_payable" class="pos-total-amount number">0.00</span>
                </div>
                @if (!isset($pos_settings['hide_recent_trans']) || $pos_settings['hide_recent_trans'] == 0)
                    <button type="button" class="pos-primary-btn pos-btn-purple tw-rounded-full tw-px-3 tw-py-2"
                        data-toggle="modal" data-target="#recent_transactions_modal" id="recent-transactions">
                        <i class="fas fa-clock"></i>
                    </button>
                @endif
            </div>

            {{-- Row 2: All Action Buttons --}}
            <div class="tw-flex tw-items-center tw-justify-between tw-gap-2">
                {{-- Primary Actions (Cash first and prominent) --}}
                <div class="tw-flex tw-items-center tw-gap-2">
                    @if (!Gate::check('disable_express_checkout') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
                        <button type="button" class="pos-primary-btn pos-btn-green no-print pos-express-finalize @if ($pos_settings['disable_express_checkout'] != 0 || !array_key_exists('cash', $payment_types)) hide @endif"
                            data-pay_method="cash" title="@lang('tooltip.express_checkout')">
                            <i class="fas fa-money-bill-alt"></i>
                            <span>@lang('lang_v1.express_checkout_cash')</span>
                        </button>
                    @endif

                    @if (!Gate::check('disable_pay_checkout') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
                        <button type="button" class="pos-primary-btn pos-btn-navy no-print @if ($pos_settings['disable_pay_checkout'] != 0) hide @endif"
                            id="pos-finalize" title="@lang('lang_v1.tooltip_checkout_multi_pay')">
                            <i class="fas fa-money-check-alt"></i>
                            <span>@lang('lang_v1.checkout_multi_pay')</span>
                        </button>
                    @endif

                    @if (empty($edit))
                        <button type="button" class="pos-primary-btn pos-btn-red" id="pos-cancel">
                            <i class="fas fa-times"></i>
                            <span>@lang('sale.cancel')</span>
                        </button>
                    @else
                        <button type="button" class="pos-primary-btn pos-btn-red hide"
                            id="pos-delete" @if (!empty($only_payment)) disabled @endif>
                            <i class="fas fa-trash-alt"></i>
                            <span>@lang('messages.delete')</span>
                        </button>
                    @endif
                </div>

                {{-- Secondary Actions --}}
                <div class="tw-flex tw-items-center tw-gap-2">
                    @if (!Gate::check('disable_draft') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
                        <button type="button" class="pos-action-btn @if ($pos_settings['disable_draft'] != 0) hide @endif"
                            id="pos-draft" @if (!empty($only_payment)) disabled @endif>
                            <i class="fas fa-edit" style="color: #009ce4 !important;"></i>
                            <span>@lang('sale.draft')</span>
                        </button>
                    @endif

                    @if (!Gate::check('disable_quotation') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
                        <button type="button" class="pos-action-btn"
                            id="pos-quotation" @if (!empty($only_payment)) disabled @endif>
                            <i class="fas fa-file-alt" style="color: #E7A500 !important;"></i>
                            <span>@lang('lang_v1.quotation')</span>
                        </button>
                    @endif

                    @if (!Gate::check('disable_card') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
                        <button type="button" class="pos-action-btn no-print pos-express-finalize @if (!array_key_exists('card', $payment_types)) hide @endif"
                            data-pay_method="card" title="@lang('lang_v1.tooltip_express_checkout_card')">
                            <i class="fas fa-credit-card" style="color: #D61B60 !important;"></i>
                            <span>@lang('lang_v1.express_checkout_card')</span>
                        </button>
                    @endif
                </div>
            </div>

            {{-- Hidden inputs for mobile --}}
            @if (!Gate::check('disable_credit_sale') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
                @if (empty($pos_settings['disable_credit_sale_button']))
                    <input type="hidden" name="is_credit_sale" value="0" id="is_credit_sale">
                @endif
            @endif
        </div>

        {{-- Desktop Layout (>= 768px) --}}
        <div class="tw-hidden md:tw-flex tw-items-center tw-justify-between tw-gap-4">

            {{-- Left: Total Payable --}}
            <div class="tw-flex tw-items-center tw-gap-3">
                <div class="tw-flex tw-flex-col tw-items-start tw-leading-tight">
                    <span class="pos-total-label">Total</span>
                    <span class="pos-total-label">Payable:</span>
                </div>
                <input type="hidden" name="final_total" id="final_total_input" value="0.00">
                <span id="total_payable" class="pos-total-amount number">0.00</span>
            </div>

            {{-- Center: All Action Buttons --}}
            <div class="tw-flex tw-items-center tw-gap-4 lg:tw-gap-6">
                {{-- Primary Actions (Cash first and prominent) --}}
                <div class="tw-flex tw-items-center tw-gap-2 lg:tw-gap-3">
                    @if (!Gate::check('disable_express_checkout') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
                        <button type="button" class="pos-primary-btn pos-btn-green no-print pos-express-finalize tw-py-3 tw-px-6 @if ($pos_settings['disable_express_checkout'] != 0 || !array_key_exists('cash', $payment_types)) hide @endif"
                            data-pay_method="cash" title="@lang('tooltip.express_checkout')"
                            style="font-size: 1rem;">
                            <i class="fas fa-money-bill-alt" style="font-size: 1.25rem;"></i>
                            <span>@lang('lang_v1.express_checkout_cash')</span>
                        </button>
                    @endif

                    @if (!Gate::check('disable_pay_checkout') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
                        <button type="button" class="pos-primary-btn pos-btn-navy no-print @if ($pos_settings['disable_pay_checkout'] != 0) hide @endif"
                            id="pos-finalize" title="@lang('lang_v1.tooltip_checkout_multi_pay')">
                            <i class="fas fa-money-check-alt"></i>
                            <span>@lang('lang_v1.checkout_multi_pay')</span>
                        </button>
                    @endif

                    @if (empty($edit))
                        <button type="button" class="pos-primary-btn pos-btn-red" id="pos-cancel">
                            <i class="fas fa-times"></i>
                            <span>@lang('sale.cancel')</span>
                        </button>
                    @else
                        <button type="button" class="pos-primary-btn pos-btn-red hide"
                            id="pos-delete" @if (!empty($only_payment)) disabled @endif>
                            <i class="fas fa-trash-alt"></i>
                            <span>@lang('messages.delete')</span>
                        </button>
                    @endif
                </div>

                {{-- Secondary Actions --}}
                <div class="tw-flex tw-items-center tw-gap-2 lg:tw-gap-4">
                    @if (!Gate::check('disable_draft') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
                        <button type="button" class="pos-action-btn @if ($pos_settings['disable_draft'] != 0) hide @endif"
                            id="pos-draft" @if (!empty($only_payment)) disabled @endif>
                            <i class="fas fa-edit" style="color: #009ce4 !important;"></i>
                            <span>@lang('sale.draft')</span>
                        </button>
                    @endif

                    @if (!Gate::check('disable_quotation') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
                        <button type="button" class="pos-action-btn"
                            id="pos-quotation" @if (!empty($only_payment)) disabled @endif>
                            <i class="fas fa-file-alt" style="color: #E7A500 !important;"></i>
                            <span>@lang('lang_v1.quotation')</span>
                        </button>
                    @endif

                    @if (!Gate::check('disable_suspend_sale') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
                        @if (empty($pos_settings['disable_suspend']))
                            <button type="button" class="pos-action-btn no-print pos-express-finalize"
                                data-pay_method="suspend" title="@lang('lang_v1.tooltip_suspend')"
                                @if (!empty($only_payment)) disabled @endif>
                                <i class="fas fa-pause-circle" style="color: #EF4B51 !important;"></i>
                                <span>@lang('lang_v1.suspend')</span>
                            </button>
                        @endif
                    @endif

                    @if (!Gate::check('disable_credit_sale') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
                        @if (empty($pos_settings['disable_credit_sale_button']))
                            <input type="hidden" name="is_credit_sale" value="0" id="is_credit_sale">
                            <button type="button" class="pos-action-btn no-print pos-express-finalize"
                                data-pay_method="credit_sale" title="@lang('lang_v1.tooltip_credit_sale')"
                                @if (!empty($only_payment)) disabled @endif>
                                <i class="fas fa-hand-holding-usd" style="color: #5E5CA8 !important;"></i>
                                <span>@lang('lang_v1.credit_sale')</span>
                            </button>
                        @endif
                    @endif

                    @if (!Gate::check('disable_card') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
                        <button type="button" class="pos-action-btn no-print pos-express-finalize @if (!array_key_exists('card', $payment_types)) hide @endif"
                            data-pay_method="card" title="@lang('lang_v1.tooltip_express_checkout_card')">
                            <i class="fas fa-credit-card" style="color: #D61B60 !important;"></i>
                            <span>@lang('lang_v1.express_checkout_card')</span>
                        </button>
                    @endif
                </div>
            </div>

            {{-- Right: Recent Transactions --}}
            @if (!isset($pos_settings['hide_recent_trans']) || $pos_settings['hide_recent_trans'] == 0)
                <button type="button" class="pos-primary-btn pos-btn-purple tw-rounded-full tw-h-11"
                    data-toggle="modal" data-target="#recent_transactions_modal" id="recent-transactions">
                    <i class="fas fa-clock"></i>
                    <span class="tw-whitespace-nowrap">@lang('lang_v1.recent_transactions')</span>
                </button>
            @endif
        </div>
    </div>
</div>

@if (isset($transaction))
    @include('sale_pos.partials.edit_discount_modal', [
        'sales_discount' => $transaction->discount_amount,
        'discount_type' => $transaction->discount_type,
        'rp_redeemed' => $transaction->rp_redeemed,
        'rp_redeemed_amount' => $transaction->rp_redeemed_amount,
        'max_available' => !empty($redeem_details['points']) ? $redeem_details['points'] : 0,
    ])
@else
    @include('sale_pos.partials.edit_discount_modal', [
        'sales_discount' => $business_details->default_sales_discount,
        'discount_type' => 'percentage',
        'rp_redeemed' => 0,
        'rp_redeemed_amount' => 0,
        'max_available' => 0,
    ])
@endif

@if (isset($transaction))
    @include('sale_pos.partials.edit_order_tax_modal', ['selected_tax' => $transaction->tax_id])
@else
    @include('sale_pos.partials.edit_order_tax_modal', [
        'selected_tax' => $business_details->default_sales_tax,
    ])
@endif

@include('sale_pos.partials.edit_shipping_modal')
