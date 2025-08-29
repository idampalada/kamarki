<div class="form-group mb-3">
    <label class="control-label">{{ __('Style') }}</label>
    {!!
        Form::customSelect('style', $styles, Arr::get($attributes, 'style'))
    !!}
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Title') }}</label>
    <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control">
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Title highlight') }}</label>
    <input name="title_highlight" value="{{ Arr::get($attributes, 'title_highlight') }}" class="form-control">
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Subtitle') }}</label>
    <textarea name="subtitle" class="form-control">{{ Arr::get($attributes, 'subtitle') }}</textarea>
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Background Image') }}</label>
    {!! Form::mediaImages('background_images', explode(',', Arr::get($attributes, 'background_images'))) !!}
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Youtube video URL') }}</label>
    <input name="youtube_video_url" value="{{ Arr::get($attributes, 'youtube_video_url') }}" class="form-control">
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Enable search box on hero banner?') }}</label>
    {!! Form::customSelect('enabled_search_box', [
            true => trans('core/base::base.yes'),
            false => trans('core/base::base.no'),
        ], Arr::get($attributes, 'enabled_search_box', true))
    !!}
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Search type') }}</label>
    {!! Form::customSelect('search_type', [
            'properties' => __('Properties search'),
            'projects' => __('Projects search'),
        ], Arr::get($attributes, 'search_type', true))
    !!}
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Enable search projects in search box?') }}</label>
    {!! Form::customSelect('enabled_search_projects', [
            true => trans('core/base::base.yes'),
            false => trans('core/base::base.no'),
        ], Arr::get($attributes, 'enabled_search_projects', true))
    !!}
</div>
