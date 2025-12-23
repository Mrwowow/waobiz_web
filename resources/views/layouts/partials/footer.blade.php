<!-- Modern Dark Footer -->
<div class="tw-mt-auto modern-footer">
    <div class="tw-py-4 tw-px-8 no-print">
        <div class="tw-flex tw-items-center tw-justify-between tw-flex-wrap tw-gap-4">
            <p class="tw-text-sm tw-font-normal tw-text-gray-500">
                &copy; {{ date('Y') }} <span class="tw-font-semibold tw-text-orange-500">{{ config('app.name', 'WaoBiz') }}</span>. All rights reserved.
            </p>
            <div class="tw-flex tw-items-center tw-gap-4">
                <span class="tw-text-xs tw-text-gray-600 tw-font-mono" style="display:none;">V{{config('author.app_version')}}</span>
            </div>
        </div>
    </div>
</div>

<style>
    .modern-footer {
        background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 100%);
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }
</style>
