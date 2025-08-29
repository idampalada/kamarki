@php
    Theme::asset()->usePath()->add('leaflet-css', 'plugins/leaflet/leaflet.css');
    Theme::asset()->container('footer')->usePath()->add('leaflet-js', 'plugins/leaflet/leaflet.js');
    Theme::asset()->add('ckeditor-content-styles', 'vendor/core/core/base/libraries/ckeditor/content-styles.css');

    $project->loadMissing('categories');
    $categories = $project->categories->map->name->implode(', ');
    $propertiesForRent = app('Botble\RealEstate\Repositories\Interfaces\PropertyInterface')->advancedGet(array_merge([
        'condition' => [
            'project_id' => $project->id,
            'type' => \Botble\RealEstate\Enums\PropertyTypeEnum::RENT,
        ],
    ], RealEstateHelper::getReviewExtraData()));
    $propertiesForSale = app('Botble\RealEstate\Repositories\Interfaces\PropertyInterface')->advancedGet(array_merge([
        'condition' => [
            'project_id' => $project->id,
            'type' => \Botble\RealEstate\Enums\PropertyTypeEnum::SALE,
        ],
    ], RealEstateHelper::getReviewExtraData()));
@endphp

<section class="relative mt-28">
    {!! Theme::partial('real-estate.properties.slider', ['item' => $project]) !!}

    <div class="container md:mt-16 mt-14">
        <div class="md:flex">
            <div class="px-3 lg:w-2/3 md:w-1/2 md:p-4">
                <h4 class="text-2xl font-medium">{{ $project->name }}</h4>
                <div class="flex flex-wrap gap-3 mt-2">
                    @if ($project->city->name || $project->state->name)
                        <p class="inline text-gray-500 dark:text-gray-400"><i class="mdi mdi-map-marker pe-1"></i>{{ $project->city->name }}{{ $project->city->name ? ', ' : '' }}{{ $project->state->name }}</p>
                    @endif
                    @if(setting('real_estate_display_views_count_in_detail_page', true))
                        <p class="inline text-gray-500 dark:text-gray-400"><i class="px-1 mdi mdi-eye"></i>{{ __(':count views', ['count' => number_format($project->views)]) }}</p>
                    @endif
                    <p class="inline text-gray-500 dark:text-gray-400"><i class="px-1 mdi mdi-calendar"></i>{{ $project->created_at->translatedFormat('M d, Y')}}</p>
                    @if(RealEstateHelper::isEnabledReview())
                        @include(Theme::getThemeNamespace('views.real-estate.partials.review-star'), ['avgStar' => $project->reviews_avg_star, 'count' => $project->reviews_count])
                    @endif
                </div>
                <ul class="flex items-center px-0 py-6 m-0 list-none">
                    @if ($project->square)
                        <li class="flex items-center me-4 lg:me-6">
                            <i class="text-2xl text-primary mdi mdi-arrow-collapse-all me-2"></i>
                            <span class="lg:text-xl">{{ $project->square_text }}</span>
                        </li>
                    @endif

                    @if ($numberBeds = $project->number_bedroom)
                        <li class="flex items-center me-4 lg:me-6">
                            <i class="text-2xl mdi mdi-bed-double lg:text-3xl me-2 text-primary"></i>
                            <span class="lg:text-xl">{{ __(':number Bed(s)', ['number' => $numberBeds]) }}</span>
                        </li>
                    @endif

                    @if ($numberBathrooms = $project->number_bathroom)
                        <li class="flex items-center">
                            <i class="text-2xl text-primary mdi mdi-shower me-2"></i>
                            <span class="lg:text-xl">{{ __(':number Bath(s)', ['number' => $numberBathrooms]) }}</span>
                        </li>
                    @endif
                </ul>
                <div class="text-slate-600 ck-content dark:text-gray-200">{!! BaseHelper::clean($project->content) !!}</div>

                @if ($project->features->count())
                    <h5 class="pt-5 mb-5 pb-2 text-xl font-bold border-b border-gray-300 dark:border-gray-700">{{ __('Features') }}</h5>
                    <div class="grid gap-4 lg:grid-cols-3 sm:grid-cols-1">
                        @foreach($project->features as $feature)
                            <li class="flex items-center col-span-1 me-4 lg:me-6">
                                <i class="{{ $feature->icon ?? 'mdi mdi-check' }} lg:text-3xl text-2xl me-2 text-primary"></i>
                                <span class="lg:text-lg">{{ $feature->name }}</span>
                            </li>
                        @endforeach
                    </div>
                @endif

                @if ($project->facilities->count())
                    <h5 class="pt-5 mb-5 pb-2 text-xl font-bold border-b border-gray-300 dark:border-gray-700">{{ __('Distance key between facilities') }}</h5>
                    <div class="grid gap-4 lg:grid-cols-3 sm:grid-cols-1">
                        @foreach($project->facilities as $facility)
                            <li class="flex items-center col-span-1 me-4 lg:me-6">
                                @if ($facility->getMetaData('icon_image', true))
                                    <p><i><img src="{{ RvMedia::getImageUrl($facility->getMetaData('icon_image', true)) }}" alt="{{ $facility->name }}" style="vertical-align: top; margin-top: 3px;" width="18" height="18"></i> {{ $facility->name }} - {{ $facility->pivot->distance }}</p>
                                @else
                                    <i class="@if ($facility->icon) {{ $facility->icon }} @else mdi mdi-check @endif lg:text-3xl text-2xl me-2 text-primary"></i>
                                    <span class="lg:text-lg">{{ $facility->name }} - {{ $facility->pivot->distance }}</span>
                                @endif
                            </li>
                        @endforeach
                    </div>
                @endif

                @if ($project->latitude && $project->longitude)
                    <h5 class="pt-5 mb-5 pb-2 text-xl font-bold border-b border-gray-300 dark:border-gray-700">{{ __("Location") }}</h5>
                    <div class="box-map property-street-map-container">
                        <div class="property-street-map"
                             data-popup-id="#street-map-popup-template"
                             data-center="{{ json_encode([$project->latitude, $project->longitude]) }}"
                             data-map-icon="{{ $project->name }}"
                             style="height: 300px;"
                        >
                            <div class="hidden property-template-popup-map">
                                <table width="100%">
                                    <tr>
                                        <td width="90">
                                            <div class="blii"><img src="{{ $project->image_thumb }}" width="80" alt="{{ $project->name }}">
                                                <div class="status"><span class="label-success status-label">{{ $project->status->label() }}</span></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="infomarker text-start">
                                                <h5><a href="{{ $project->url }}" target="_blank">{!! BaseHelper::clean($project->name) !!}</a></h5>
                                                @if($project->categories->isNotEmpty())
                                                    <span>{{ $categories }}</span>
                                                @endif

                                                <div class="ltr:flex">
                                                    @if ($project->city->name || $project->state->name)
                                                        <span class="mt-2">
                                                            <i class="mdi mdi-map-marker"></i>
                                                            <strong>{{ $project->city->name }}{{ $project->city->name ? ', ' : '' }}{{ $project->state->name }}</strong>
                                                        </span >
                                                    @endif
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="px-3 mt-8 lg:w-1/3 md:w-1/2 md:p-4 md:mt-0">
                <div class="sticky top-20">
                    <div class="mb-6 rounded-md shadow bg-slate-50 dark:bg-slate-800 dark:shadow-gray-700">
                        <div class="p-6">
                            <h5 class="text-2xl font-medium">{{ __('Overview:') }}</h5>


                            <ul class="mx-0 mt-4 mb-0 list-none">
                                @if($project->price_from || $project->price_to)
                                <li class="flex items-center justify-between mb-2">
                                    <span class="text-sm text-slate-400">{{ __('Price') }}</span>
                                    <span class="text-xl font-medium">{{ __(':from - :to', ['from' => format_price($project->price_from), 'to' => format_price($project->price_to)]) }}</span>
                                </li>
                                @endif

                                @if ($project->status)
                                    <li class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-slate-400">{{ __('Status') }}</span>
                                        <span class="bg-primary/10 text-primary text-sm px-2.5 py-0.75 rounded h-6">{{ $project->status->label() }}</span>
                                    </li>
                                @endif

                                @if($project->categories->isNotEmpty())
                                    <li class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-slate-400">{{ __('Categories') }}</span>
                                        <span class="text-sm font-medium" title="{{ BaseHelper::clean($categories) }}">
                                            {{ Str::limit($categories, 30) }}
                                        </span>
                                    </li>
                                @endif

                                @if ($uniqueId = $project->unique_id)
                                    <li class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-slate-400">{{ __('ID') }}</span>
                                        <span class="text-sm font-medium">{{ $uniqueId }}</span>
                                    </li>
                                @endif

                                @if ($numberBlock = $project->number_block)
                                    <li class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-slate-400">{{ __('Number of blocks') }}</span>
                                        <span class="text-sm font-medium">{{ $numberBlock }}</span>
                                    </li>
                                @endif

                                @if ($numberFlats = $project->number_flat)
                                    <li class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-slate-400">{{ __('Number of flats') }}</span>
                                        <span class="text-sm font-medium">{{ $numberFlats }}</span>
                                    </li>
                                @endif

                                @if ($project->square)
                                    <li class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-slate-400">{{ __('Square') }}</span>
                                        <span class="text-sm font-medium">{{ $project->square_text }}</span>
                                    </li>
                                @endif

                                @if ($bedrooms = $project->number_bedroom)
                                    <li class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-slate-400">{{ __('Number of bedrooms') }}</span>
                                        <span class="text-sm font-medium">{{ $bedrooms }}</span>
                                    </li>
                                @endif

                                @if ($bathrooms = $project->number_bathroom)
                                    <li class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-slate-400">{{ __('Number of bathrooms') }}</span>
                                        <span class="text-sm font-medium">{{ $bathrooms }}</span>
                                    </li>
                                @endif

                                @if ($floors = $project->number_floor)
                                    <li class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-slate-400">{{ __('Number of floors') }}</span>
                                        <span class="text-sm font-medium">{{ $floors }}</span>
                                    </li>
                                @endif

                                @if(RealestateHelper::isEnabledCustomFields())
                                    @foreach($project->customFields as $customField)
                                        <li class="flex items-center justify-between mb-2">
                                            <span class="text-sm text-slate-400">{!! BaseHelper::clean($customField->name) !!}</span>
                                            <span class="text-sm font-medium">{!! BaseHelper::clean($customField->value) !!}</span>
                                        </li>
                                    @endforeach
                                @endif
                                {!! apply_filters('property_details_extra_info', null, $project) !!}
                            </ul>
                        </div>
                    </div>

                    <div class="mb-6 rounded-md shadow bg-slate-50 dark:bg-slate-800 dark:shadow-gray-700">
                        {!! Theme::partial('consult-form', ['type' => 'project', 'data' => $project]) !!}
                    </div>

                    <div class="mt-12 text-center">
                        {!! dynamic_sidebar('property_sidebar') !!}
                    </div>
                </div>
            </div>
        </div>

        @include(Theme::getThemeNamespace('views.real-estate.partials.reviews'), ['model' => $project])

        @if ($propertiesForSale->isNotEmpty())
            <div class="mx-3 mt-10 mb-5">
                <h5 class="text-xl font-bold border-b border-gray-300 dark:border-gray-700 pb-2">{{ __('Properties for Sale') }}</h5>
                {!! Theme::partial('real-estate.properties.items', ['properties' => $propertiesForSale]) !!}
            </div>
        @endif

        @if ($propertiesForRent->isNotEmpty())
            <div class="mx-3 mt-10 mb-5">
                <h5 class="text-xl font-bold border-b border-gray-300 dark:border-gray-700 pb-2">{{ __('Properties for Rent') }}</h5>
                {!! Theme::partial('real-estate.properties.items', ['properties' => $propertiesForRent]) !!}
            </div>
        @endif
    </div>
</section>
