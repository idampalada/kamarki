<div>
    <label for="keyword-rent" class="font-medium form-label text-slate-900 dark:text-white">{{ __('Keyword:') }}</label>
    <div class="relative mt-2 filter-search-form filter-border">
        <i class="mdi mdi-magnify icons"></i>
        <input name="k" type="text" id="keyword-rent" class="border-0 form-input filter-input-box bg-gray-50 dark:bg-slate-800" autocomplete="off" placeholder="{{ __('Search your keyword') }}" value="{{ BaseHelper::stringify(request()->query('k')) }}">
        <i class="absolute hidden mdi mdi-loading mdi-spin top-5 end-5"></i>
    </div>
</div>
