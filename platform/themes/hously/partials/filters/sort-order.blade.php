<div class="flex items-center gap-3">
    <div class="relative">
        <select name="per_page" id="per-page" class="px-3 py-2 pe-7 border rounded-lg cursor-pointer border-slate-300 focus-visible:outline-primary appearance-none dark:bg-slate-800 dark:text-slate-200 dark:border-slate-600">
            <option value="">{{ __('Showing') }}</option>
            @foreach($perPages as $perPage)
                <option value="{{ $perPage }}" @selected((int) BaseHelper::stringify(request()->query('per_page')) === $perPage)>{{ $perPage }}</option>
            @endforeach
        </select>
        <svg class="absolute top-[13px] end-2 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </div>
    <div class="relative">
        <select name="sort_by" id="sort-by" class="px-3 py-2 pe-7 border rounded-lg cursor-pointer border-slate-300 focus-visible:outline-primary appearance-none dark:bg-slate-800 dark:text-slate-200 dark:border-slate-600">
            <option value="">{{ __('Default') }}</option>
            @foreach(RealEstateHelper::getSortByList() as $key => $value)
                <option value="{{ $key }}" @selected(BaseHelper::stringify(request()->query('sort_by')) === $key)>{{ $value }}</option>
            @endforeach
        </select>
        <svg class="absolute top-[13px] end-2 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </div>
</div>
