<form action="{{ $actionUrl ?? RealEstateHelper::getPropertiesListPageUrl() }}" data-ajax-url="{{ $ajaxUrl ?? route('public.properties') }}">
    <input type="hidden" name="type" value="rent">
    <div class="space-y-5 registration-form text-dark text-start">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 lg:gap-0">
            {!! Theme::partial('filters.keyword', compact('type')) !!}

            {!! Theme::partial('filters.location', compact('type')) !!}

            <!-- {!! Theme::partial('filters.by-project', compact('type')) !!} -->
        </div>

        {{-- <button type="button" class="flex items-center gap-2 toggle-advanced-search text-secondary hover:text-primary">
            {{ __('Advanced') }}
            <i class="mdi mdi-chevron-down-circle-outline"></i>
        </button> --}}

        <div class="grid hidden grid-cols-1 gap-6 transition-all duration-200 ease-in-out lg:grid-cols-4 md:grid-cols-2 lg:gap-0 advanced-search">
            {!! Theme::partial('filters.category', compact('type', 'categories')) !!}

            {!! Theme::partial('filters.bedroom', compact('type')) !!}

            {!! Theme::partial('filters.bathroom', compact('type')) !!}

            {!! Theme::partial('filters.floor', compact('type')) !!}
        </div>

        <button type="submit"
                class="btn text-white submit-btn w-full md:w-1/4 !h-12 rounded transition-all ease-in-out duration-200"
                style="background-color: #00adee; border-color: #00adee;">
            <i class="mdi mdi-magnify me-2"></i>
            {{ __('Search') }}
        </button>
    </div>
</form>
