@php
    $breadcrumbs = Theme::breadcrumb()->getCrumbs();
    $currentPage = $breadcrumbs[array_key_last($breadcrumbs)] ?? [];
    $pageCoverImage = Theme::get('pageCoverImage') !== '' ? Theme::get('pageCoverImage') : theme_option('default_page_cover_image');
@endphp

<section class="relative table w-full py-32 bg-center bg-no-repeat breadcrumb lg:py-36" style="background-image: url('{{ RvMedia::getImageUrl($pageCoverImage) }}')">
    <div class="absolute inset-0 bg-black opacity-80"></div>
    <div class="container">
        <div class="grid grid-cols-1 mt-10 text-center">
            <h3 class="text-3xl font-medium leading-normal text-white md:text-4xl md:leading-normal">{{ Arr::get($currentPage, 'label') }}</h3>
            @if(Theme::has('pageDescription'))
                <p class="max-w-2xl mx-auto mt-5 text-white">{!! BaseHelper::clean(Theme::get('pageDescription')) !!}</p>
            @endif
        </div>
    </div>
</section>
<div class="relative">
    <div class="overflow-hidden text-white shape z-1 dark:text-slate-900">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
        </svg>
    </div>
</div>
