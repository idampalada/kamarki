@php
    $currentLayout = BaseHelper::stringify(request()->query('layout')) ?? (theme_option('projects_list_layout') ?: 'grid');

    if (! in_array($currentLayout, ['grid', 'list'])) {
        $currentLayout = 'grid';
    }
@endphp

{!! Theme::partial("real-estate.projects.items-$currentLayout", compact('projects')) !!}

@if ($projects instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $projects->links(Theme::getThemeNamespace('partials.pagination')) }}
@endif
