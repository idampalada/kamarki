@php
    Theme::set('navStyle', 'light');
@endphp

{!! Theme::partial('breadcrumb') !!}

<div class="container mt-16 lg:mt-24">
    @include(Theme::getThemeNamespace('views.real-estate.partials.agents-list'))

    {{ $accounts->links(Theme::getThemeNamespace('partials.pagination')) }}
</div>
