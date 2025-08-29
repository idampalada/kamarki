<div>
    <label for="project-{{ $type }}" class="font-medium form-label text-slate-900 dark:text-white">{{ __('Project:') }}</label>
    <div class="relative mt-2 filter-search-form filter-border">
        <i class="mdi mdi-magnify icons"></i>
        <input name="project" type="text" id="project-{{ $type }}" class="border-0 form-input filter-input-box bg-gray-50 dark:bg-slate-800" autocomplete="off" placeholder="{{ __('Search your project') }}" data-url="{{ route('public.ajax.projects-filter') }}" value="{{ BaseHelper::stringify(request()->query('project')) }}">
        <i class="absolute hidden mdi mdi-loading mdi-spin top-5 end-5"></i>
    </div>
</div>
