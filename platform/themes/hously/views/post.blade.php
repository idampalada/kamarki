@php
    Theme::set('navStyle', 'light');
    Theme::set('pageDescription', $post->description)
@endphp

{!! Theme::partial('breadcrumb') !!}

<div class="container mt-16 lg:mt-24">
    <div class="grid grid-cols-1 md:grid-cols-6 md:gap-10">
        <div class="col-span-1 mb-16 md:col-span-4 md:mb-0">
            <div>
                <div>
                    <ul class="flex gap-3 ps-0 my-2 text-sm list-none text-slate-700 dark:text-slate-300">
                        <li>
                            <i class="mdi mdi-calendar-outline"></i>
                            <span>{{ $post->created_at->translatedFormat('M d, Y') }}</span>
                        </li>
                        @if($post->firstCategory)
                            <li>
                                <a href="{{ $post->firstCategory->url }}" class="hover:text-primary">
                                    <i class="mdi mdi-tag-outline"></i>
                                    <span>{{ $post->firstCategory->name }}</span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <i class="mdi mdi-eye-outline"></i>
                            <span>{{ number_format($post->views) }}</span>
                        </li>
                    </ul>
                </div>
                <div class="post-detail">
                     <div class="ck-content">{!! BaseHelper::clean($post->content) !!}</div>
                </div>

                {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, theme_option('facebook_comment_enabled_in_post', 'yes') == 'yes' ? Theme::partial('comment') : null) !!}

                <div class="flex flex-wrap items-center justify-between gap-5 pt-5 mt-5 border-t">
                    @if ($post->tags->count())
                        <div>
                            <span class="font-semibold">{{ __('Tags:') }}</span>
                            @foreach ($post->tags as $tag)
                                <a href="{{ $tag->url }}" class="transition-colors text-primary hover:text-secondary">{{ $tag->name }}</a>@if (! $loop->last), @endif
                            @endforeach
                        </div>
                    @endif
                    <div class="flex items-center text-slate-500 dark:text-slate-300">
                        <span>{{ __('Share:') }}</span>
                        <ul class="flex gap-2.5 ms-3">
                            <li>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}&title={{ $post->description }}" target="_blank" title="{{ __('Share on Facebook') }}">
                                    <i class="text-2xl transition-all mdi mdi-facebook hover:text-primary"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&summary={{ rawurldecode($post->description) }}&source=Linkedin" title="{{ __('Share on Linkedin') }}" target="_blank">
                                    <i class="text-2xl transition-all mdi mdi-linkedin hover:text-primary"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ $post->description }}" target="_blank" title="{{ __('Share on Twitter') }}">
                                    <i class="text-2xl transition-all mdi mdi-twitter hover:text-primary"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-2 space-y-12">
            {!! dynamic_sidebar('blog_sidebar') !!}
        </div>
    </div>
</div>
