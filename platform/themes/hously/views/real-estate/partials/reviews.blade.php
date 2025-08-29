@php
    Theme::asset()->usePath()->add('jquery-bar-rating-css', 'plugins/jquery-bar-rating/css-stars.css');
    Theme::asset()->container('footer')->usePath()->add('jquery-bar-rating-js', 'plugins/jquery-bar-rating/jquery.barrating.min.js');
    Theme::asset()->container('footer')->usePath()->add('review-js', 'js/review.js');
@endphp

@if(RealEstateHelper::isEnabledReview())
    @php($canReview = auth('account')->check() && auth('account')->user()->canReview($model))
    <div class="px-3 lg:w-2/3 md:w-1/2 md:p-4">
        <div class="p-6 rounded-lg bg-slate-50 dark:bg-slate-800">
            <div>
                <h3 class="pb-5 text-xl font-semibold">{{ __('Write a review') }}</h3>
                <form action="{{ route('public.ajax.review.store', $model->slug) }}" method="post" class="space-y-3 review-form">
                    @csrf
                    <input type="hidden" name="reviewable_type" value="{{ get_class($model) }}">
                    <div class="text-start">
                        <select name="star" id="select-star">
                            @foreach(range(1, 5) as $i)
                                <option value="{{ $i }}" @selected(old('score', 5) === $i)>{{ $i }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <textarea name="content" id="content" class="h-20 bg-white form-input disabled:cursor-not-allowed disabled:bg-opacity-70 dark:disabled:bg-slate-700" placeholder="{{ __('Enter your message') }}" @disabled(! $canReview)>{{ old('content') }}</textarea>
                    </div>
                    @guest('account')
                        <p class="text-red-600">{{ __('Please log in to write review!') }}</p>
                    @endguest
                    <button @class(['btn bg-primary text-white hover:bg-secondary disabled:cursor-not-allowed disabled:bg-opacity-70 hover:disabled:bg-primary hover:disabled:bg-opacity-70']) @disabled(! $canReview)>
                        {{ __('Submit review') }}
                    </button>
                </form>
            </div>
            <div class="pt-8 mt-8 border-t dark:border-gray-700">
                @if($model->reviews_count)
                    <div class="flex justify-between">
                        <h3 class="text-xl">
                            <span class="reviews-count">{{ __(':count Review(s)', ['count' => $model->reviews_count]) }}</span>
                        </h3>

                        @include(Theme::getThemeNamespace('views.real-estate.partials.review-star'), ['avgStar' => $model->reviews_avg_star, 'count' => $model->reviews_count, 'style' => 2])
                    </div>
                @endif
                <div @class(['reviews-list space-y-7', 'mt-10' => $model->reviews_count]) data-url="{{ route('public.ajax.review.index', $model->slug) }}?reviewable_type={{ get_class($model) }}"></div>
            </div>
        </div>
    </div>
    <div class="flex items-start hidden animate-pulse">
        <div class="min-w-max">
            <div class="w-20 h-20 rounded-full bg-slate-200"></div>
        </div>
        <div class="w-full ms-5">
            <div class="-ms-1">
                @foreach(range(1, 5) as $i)
                    <i class="mdi mdi-star text-slate-200"></i>
                @endforeach
            </div>
            <div class="my-2 space-y-3">
                <div class="w-1/4 h-2 rounded-lg bg-slate-200"></div>
                <div class="w-1/5 h-2 rounded-lg bg-slate-200"></div>
            </div>
            <div class="mt-5 space-y-2">
                <div class="w-full h-2 rounded-lg bg-slate-200"></div>
                <div class="w-full h-2 rounded-lg bg-slate-200"></div>
            </div>
        </div>
    </div>
@endif
