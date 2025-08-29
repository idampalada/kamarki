@if($properties->isNotEmpty())
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[30px]">
        @foreach($properties as $property)
            <div class="overflow-hidden duration-500 ease-in-out bg-white shadow property-item group rounded-xl dark:bg-slate-800 hover:shadow-lg dark:shadow-gray-700 dark:hover:shadow-gray-700">
                <div class="relative overflow-hidden">
                    <a href="{{ $property->url }}">
                        <img src="{{ RvMedia::getImageUrl($property->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $property->name }}" class="transition-all duration-500 hover:scale-110">
                    </a>
                    <div class="absolute top-6 end-6">
                        <button type="button" class="text-lg text-red-600 bg-white rounded-full shadow btn btn-icon dark:bg-slate-900 dark:shadow-gray-700 add-to-wishlist" aria-label="{{ __('Add to wishlist') }}" data-box-type="property" data-id="{{ $property->id }}">
                            <i class="mdi mdi-heart-outline"></i>
                        </button>
                    </div>
                    @if($property->images && $imagesCount = count($property->images))
                        <div class="absolute top-6 start-6">
                            <div class="flex items-center justify-center content-center p-2 pt-2.5 bg-gray-700 rounded-md bg-opacity-60 text-white text-sm">
                                <i class="leading-none mdi mdi-camera-outline me-1"></i>
                                <span class="leading-none">{{ $imagesCount }}</span>
                            </div>
                        </div>
                    @endif
                    <div class="absolute bottom-0 flex text-sm start-0 item-info-wrap">
                        <span class="flex items-center py-1 ps-6 pe-4 text-white">{{ $property->category->name }}</span>
                        {!! $property->status->toHtml() !!}
                    </div>
                </div>

                <div class="p-6">
                    <div class="truncate">
                        <a href="{{ $property->url }}" class="text-lg font-medium uppercase duration-500 ease-in-out hover:text-primary" title="{{ $property->name }}">
                            {!! BaseHelper::clean($property->name) !!}
                        </a>
                        @if($property->city->name || $property->state->name)
                            <p class="truncate text-slate-600 dark:text-slate-300">{{ $property->city->name ? $property->city->name . ', ' : '' }}{{ $property->state->name }}</p>
                        @else
                            <p class="truncate text-slate-600 dark:text-slate-300">&nbsp;</p>
                        @endif
                    </div>

                    <ul class="flex items-center justify-between py-3 ps-0 mb-0 list-none border-b dark:border-gray-800">
                        @if($property->number_bedroom)
                            <li class="flex items-center me-2">
                                <i class="text-2xl text-primary mdi mdi-bed-empty me-2"></i>
                                <span>{{ trans_choice(__('1 Bed|:number Beds'), $property->number_bedroom, ['number' => $property->number_bedroom]) }}</span>
                            </li>
                        @endif

                        @if($property->number_bathroom)
                            <li class="flex items-center me-2">
                                <i class="text-2xl text-primary mdi mdi-shower me-2"></i>
                                <span>{{ trans_choice(__('1 Bath|:number Baths'), $property->number_bathroom, ['number' => $property->number_bathroom]) }}</span>
                            </li>
                        @endif

                        @if($property->square)
                            <li class="flex items-center me-2">
                                <i class="text-2xl text-primary mdi mdi-arrow-collapse-all me-2"></i>
                                <span>{{ $property->square_text }}</span>
                            </li>
                        @endif
                    </ul>

                    <ul class="flex flex-wrap gap-3 items-center justify-between pt-4 ps-0 mb-0 list-none">
                        <li>
                            <span class="text-slate-400">{{ __('Price') }}</span>
                            <p class="text-lg font-semibold">{{ format_price($property->price, $property->currency) }}</p>
                        </li>

                        @if(RealEstateHelper::isEnabledReview())
                            <li>
                                <span class="text-slate-400">{{ __('Rating') }}</span>
                                @include(Theme::getThemeNamespace('views.real-estate.partials.review-star'), ['avgStar' => $property->reviews_avg_star, 'count' => $property->reviews_count])
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="my-16 text-center">
        <svg class="mx-auto h-24 w-24 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819" />
        </svg>
        <p class="mt-3 text-xl text-gray-500 dark:text-gray-300">{{ __('No properties found.') }}</p>
    </div>
@endif
