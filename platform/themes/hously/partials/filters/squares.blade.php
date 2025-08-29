<div>
    <label for="min-square" class="font-medium form-label text-slate-900 dark:text-white">{{ __('Square From:') }} <small>({{ setting('real_estate_square_unit', 'm²') }})</small></label>
    <div class="relative mt-2 filter-search-form filter-border">
        <i class="mdi mdi-currency-usd icons"></i>
        <input name="min_square" type="number" id="min-square" class="border-0 form-input filter-input-box bg-gray-50 dark:bg-slate-800" placeholder="{{ __('Square From') }}">
    </div>
</div>

<div>
    <label for="max-square" class="font-medium form-label text-slate-900 dark:text-white">{{ __('Square To:') }} <small>({{ setting('real_estate_square_unit', 'm²') }})</small></label>
    <div class="relative mt-2 filter-search-form filter-border">
        <i class="mdi mdi-currency-usd icons"></i>
        <input name="max_square" type="number" id="max-square" class="border-0 form-input filter-input-box bg-gray-50 dark:bg-slate-800" placeholder="{{ __('Square To') }}">
    </div>
</div>
