@php
    Theme::set('pageCoverImage', $page->getMetaData('cover_image', true));
    Theme::set('pageDescription', $page->description);
    Theme::set('navStyle', $page->getMetaData('navbar_style', true));
@endphp

{!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, Html::tag('div', BaseHelper::clean($page->content), ['class' => 'ck-content'])->toHtml(), 
$page) !!}
