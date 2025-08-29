<div>
    <label for="choices-type-{{ $type }}" class="font-medium form-label text-slate-900 dark:text-white">{{ __('Type:') }}</label>
    <div class="relative mt-2 filter-search-form filter-border">
        <i class="mdi mdi-currency-Rp icons"></i>
        <select data-trigger name="type" id="choices-type-{{ $id ?? $type }}" aria-label="{{ __('Type') }}">
            <option value="" selected >{{ __('All Type') }}</option>
            <!--@foreach(['sale' => __('Sale'), 'rent' => __('Rent')] as $key => $value)-->
            <!--    <option value="{{ $key }}">{{ $value }}</option>-->
            <!--@endforeach-->
        </select>
    </div>
</div>
