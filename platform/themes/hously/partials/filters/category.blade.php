<div>
    <label for="choices-category-{{ $type }}" class="font-medium form-label text-slate-900 dark:text-white">{{ __('Select Category:') }}</label>
    <div class="relative mt-2 filter-search-form filter-border">
        <i class="mdi mdi-home-outline icons"></i>
        <select class="form-select z-2" data-trigger name="category_id" id="choices-category-{{ $id ?? $type }}" aria-label="{{ __('Category') }}">
            <option value="">{{ __('All Category') }}</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
</div>
