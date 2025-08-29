
<style>
.btn-custom {

}

</style>
<div @class(['grid grid-cols-1', 'mt-10' => $style === 2])>
    <ul @class([
            'flex-wrap justify-center inline-block w-full p-4 text-center bg-white border-b sm:w-fit rounded-t-xl dark:border-gray-800 mb-0',
            'dark:bg-slate-900' => $style === 1,
            'mx-auto mt-10 sm:w-fit bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm' => $style === 2,
        ]) id="searchTab" data-tabs-toggle="#search-filter" role="tablist">
            @if($shortcode->enabled_search_projects)
                <li role="presentation" class="inline-block">
                    <button
                        @class(['w-full px-6 py-2 text-base font-medium transition-all duration-500 ease-in-out hover:text-primary',
                                'rounded-md' => $style === 1,
                                'rounded-xl' => $style === 2,
                                'rounded-3xl' => $style === 4])
                        id="projects-tab"
                        data-tabs-target="#projects"
                        type="button"
                        role="tab"
                        aria-controls="projects"
                        aria-selected="true"
                       style="background-color: #00adee !important; border-color: #00adee !important; color: white !important;"
                    >
                        {{ __('Rent') }}
                    </button>
                </li>
            @endif
        </ul>

    <div class="p-6 bg-white shadow-md search-filter dark:bg-slate-900 rounded-ss-none rounded-se-none md:rounded-se-xl rounded-xl dark:shadow-gray-700">
        @if($shortcode->enabled_search_projects)
            <div id="projects" role="tabpanel" aria-labelledby="projects-tab">
                {!! Theme::partial('filters.project', ['type' => 'projects', 'categories' => $categories]) !!}
            </div>
        @endif

        <div class="hidden" id="sale" role="tabpanel" aria-labelledby="sale-tab">
            {!! Theme::partial('filters.property', ['type' => 'sale', 'categories' => $categories]) !!}
        </div>

        <div class="hidden" id="rent" role="tabpanel" aria-labelledby="rent-tab">
            {!! Theme::partial('filters.property', ['type' => 'rent', 'categories' => $categories]) !!}
        </div>
    </div>
</div>
