@php
    Theme::asset()->usePath()->add('leaflet-css', 'plugins/leaflet/leaflet.css');
    Theme::asset()->container('footer')->usePath()->add('leaflet-js', 'plugins/leaflet/leaflet.js');
    Theme::asset()->add('ckeditor-content-styles', 'vendor/core/core/base/libraries/ckeditor/content-styles.css');

    $relatedProperties = app(\Botble\RealEstate\Repositories\Interfaces\PropertyInterface::class)->getRelatedProperties(
        $property->id,
        (int) theme_option('number_of_related_properties', 6),
        RealEstateHelper::getPropertyRelationsQuery(),
        RealEstateHelper::getReviewExtraData()
    );
@endphp

<section class="relative mt-28" data-property-id="{{ $property->id }}">
    {!! Theme::partial('real-estate.properties.slider', ['item' => $property]) !!}

    <div class="container md:mt-16 mt-14">
        <div class="md:flex">
            <div class="px-3 lg:w-2/3 md:w-1/2 md:p-4">
                <h4 class="text-2xl font-medium">{{ $property->name }}</h4>
               <div class="flex flex-wrap gap-3 mt-2">
                    @if ($property->city->name || $property->state->name)
                       <p class="inline text-gray-500 dark:text-gray-400"><i class="mdi mdi-map-marker"></i>{{ $property->city->name }}{{ $property->city->name ? ', ' : '' }}{{ $property->state->name }}</p>
                    @endif
                    @if(setting('real_estate_display_views_count_in_detail_page', true))
                        <p class="inline text-gray-500 dark:text-gray-400"><i class="px-1 mdi mdi-eye"></i>{{ __(':count views', ['count' => number_format($property->views)]) }}</p>
                    @endif
                   <p class="inline text-gray-500 dark:text-gray-400"><i class="px-1 mdi mdi-calendar"></i>{{ $property->created_at->translatedFormat('M d, Y')}}</p>
                    @if(RealEstateHelper::isEnabledReview())
                        @include(Theme::getThemeNamespace('views.real-estate.partials.review-star'), ['avgStar' => $property->reviews_avg_star, 'count' => $property->reviews_count])
                    @endif
               </div>
                <ul class="flex items-center px-0 py-6 m-0 list-none">
                    @if ($property->square)
                        <li class="flex items-center lg:me-6 me-4">
                            <i class="text-2xl text-primary mdi mdi-arrow-collapse-all me-2"></i>
                            <span class="lg:text-xl">{{ $property->square_text }}</span>
                        </li>
                    @endif

                    @if ($numberBeds = $property->number_bedroom)
                        <li class="flex items-center lg:me-6 me-4">
                            <i class="text-2xl mdi mdi-bed-double lg:text-3xl me-2 text-primary"></i>
                            <span class="lg:text-xl">{{ __(':number Bed(s)', ['number' => $numberBeds]) }}</span>
                        </li>
                    @endif

                    @if ($numberBathrooms = $property->number_bathroom)
                        <li class="flex items-center">
                            <i class="text-2xl text-primary mdi mdi-shower me-2"></i>
                            <span class="lg:text-xl">{{ __(':number Bath(s)', ['number' => $numberBathrooms]) }}</span>
                        </li>
                    @endif
                </ul>
                <div class="text-slate-600 dark:text-slate-200 ck-content">{!! BaseHelper::clean($property->content) !!}</div>

                @if ($property->features->count())
                    <h5 class="pt-5 mb-5 pb-2 text-xl font-bold border-b border-gray-300 dark:border-gray-700">{{ __('Features') }}</h5>
                    <div class="grid gap-4 lg:grid-cols-3 sm:grid-cols-1">
                        @foreach($property->features as $feature)
                            <li class="flex items-center col-span-1 me-4 lg:me-6">
                                <i class="{{ $feature->icon ?? 'mdi mdi-check' }} lg:text-3xl text-2xl me-2 text-primary"></i>
                                <span class="lg:text-lg">{{ $feature->name }}</span>
                            </li>
                        @endforeach
                    </div>
                @endif

                @if ($property->facilities->count())
                    <h5 class="pt-5 mb-5 pb-2 text-xl font-bold border-b border-gray-300 dark:border-gray-700">{{ __('Distance key between facilities') }}</h5>
                    <div class="grid gap-4 lg:grid-cols-3 sm:grid-cols-1">
                        @foreach($property->facilities as $facility)
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

                {{-- @if ($property->project_id && $project = $property->project)
                    <h5 class="pt-5 mb-5 pb-2 text-xl font-bold border-b border-gray-300 dark:border-gray-700">{{ __("Project's information") }}</h5>
                    <div class="grid gap-4 md:grid-cols-5 sm:grid-cols-1">
                        <div class="mt-4 md:col-span-2 lg:col-span-2 sm:w-full">
                            <img class="rounded md:h-40 md:w-80 sm:w-full sm:h-full" src="{{ RvMedia::getImageUrl($project->image, null, false, RvMedia::getDefaultImage()) }}" alt="{{ $project->name }}">
                        </div>
                        <div class="md:col-span-3 lg:col-span-3 sm:w-full sm:mt-3">
                            <a href="{{ $project->url }}"><p class="mb-1 text-xl font-bold">{!! BaseHelper::clean($project->name) !!}</p></a>
                            <div class="mb-1 text-gray-500 dark:text-gray-300">{!! BaseHelper::clean(Str::limit($project->description, 180)) !!}</div>
                            <a href="{{ $project->url }}" class="text-white btn bg-primary hover:bg-secondary">{{ __('View project') }}</a>
                        </div>
                    </div>
                @endif --}}

                @if ($property->latitude && $property->longitude)
                    <h5 class="pt-5 mb-5 pb-2 text-xl font-bold border-b border-gray-300 dark:border-gray-700">{{ __('Location') }}</h5>
                    <div class="box-map property-street-map-container">
                        <div class="property-street-map"
                             data-popup-id="#street-map-popup-template"
                             data-center="{{ json_encode([$property->latitude, $property->longitude]) }}"
                             data-map-icon="{{ $property->type->label() }}: {{ $property->price_html }}"
                             style="height: 300px;"
                        >
                            <div class="hidden property-template-popup-map">
                                <table width="100%">
                                    <tr>
                                        <td width="90">
                                            <div class="blii"><img src="{{ $property->image_thumb }}" width="80" alt="{{ $property->name }}">
                                                <div class="status">{!! BaseHelper::clean($property->status_html) !!}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="infomarker text-start">
                                                <h5><a href="{{ $property->url }}" target="_blank">{!! BaseHelper::clean($property->name) !!}</a></h5>
                                                <div class="text-info"><strong>{{ $property->price_html }}</strong></div>
                                                <div>{{ $property->city_name }}</div>
                                                <div class="ltr:flex">
                                                    <span> {{ $property->square_text }}</span>
                                                    <span class="px-2">
                                                        <i class="mdi mdi-bed-empty"></i>
                                                        <i>{{ $property->number_bedroom }}</i>
                                                    </span >
                                                    <span>
                                                        <i class="mdi mdi-shower"></i>
                                                        <i>{{ $property->number_bathroom }}</i>
                                                    </span>
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
                            <h5 class="text-2xl font-medium">{{ __('Price:') }}</h5>

                            <div class="flex items-center justify-between mt-4">
                                <span class="text-xl font-medium">{{ $property->price_html }}</span>

                                <span class="bg-primary/10 text-primary text-sm px-2.5 py-0.75 rounded h-6">{{ $property->type->label() }}</span>
                            </div>

                            <ul class="mx-0 mt-4 mb-0 list-none">
                                @if ($uniqueId = $property->unique_id)
                                    <li class="flex items-center justify-between">
                                        <span class="text-sm text-slate-400">{{ __('ID') }}</span>
                                        <span class="text-sm font-medium">{{ $uniqueId }}</span>
                                    </li>
                                @endif

                                @if ($property->square)
                                    <li class="flex items-center justify-between mt-2">
                                        <span class="text-sm text-slate-400">{{ __('Square') }}</span>
                                        <span class="text-sm font-medium">{{ $property->square_text }}</span>
                                    </li>
                                @endif

                                @if ($bedrooms = $property->number_bedroom)
                                    <li class="flex items-center justify-between mt-2">
                                        <span class="text-sm text-slate-400">{{ __('Number of bedrooms') }}</span>
                                        <span class="text-sm font-medium">{{ $bedrooms }}</span>
                                    </li>
                                @endif

                                @if ($bathrooms = $property->number_bathroom)
                                    <li class="flex items-center justify-between mt-2">
                                        <span class="text-sm text-slate-400">{{ __('Number of bathrooms') }}</span>
                                        <span class="text-sm font-medium">{{ $bathrooms }}</span>
                                    </li>
                                @endif

                                @if ($floors = $property->number_floor)
                                    <li class="flex items-center justify-between mt-2">
                                        <span class="text-sm text-slate-400">{{ __('Number of floors') }}</span>
                                        <span class="text-sm font-medium">{{ $floors }}</span>
                                    </li>
                                @endif

                                @if(RealestateHelper::isEnabledCustomFields())
                                    @foreach($property->customFields as $customField)
                                        @if($customField->name != 'youtube_url')
                                            <li class="flex items-center justify-between mt-2">
                                                <span class="text-sm text-slate-400">{!! BaseHelper::clean($customField->name) !!}</span>
                                                <span class="text-sm font-medium">{!! BaseHelper::clean($customField->value) !!}</span>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                                {!! apply_filters('property_details_extra_info', null, $property) !!}
                            </ul>
                        </div>
                    </div>

                    <div class="mb-6 rounded-md shadow bg-slate-50 dark:bg-slate-800 dark:shadow-gray-700">
                        {!! Theme::partial('consult-form', ['type' => 'property', 'data' => $property]) !!}
                    </div>

                    <div class="mt-12 text-center">
                        {!! dynamic_sidebar('property_sidebar') !!}
                    </div>
                </div>
            </div>
        </div>

        @if(RealEstateHelper::isEnabledReview())
            @include(Theme::getThemeNamespace('views.real-estate.partials.reviews'), ['model' => $property])
        @endif

        @if ($relatedProperties->count())
            <div class="mx-3 mt-10 mb-5">
                <h5 class="text-xl font-bold border-b border-gray-300 dark:border-gray-700 pb-2">{{ __('Related properties') }}</h5>
                {!! Theme::partial('real-estate.properties.items', ['properties' => $relatedProperties]) !!}
            </div>
        @endif
    </div>
</section>
