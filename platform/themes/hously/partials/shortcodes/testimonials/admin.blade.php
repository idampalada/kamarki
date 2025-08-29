<div class="form-group mb-3">
    <label class="control-label">{{ __('Title') }}</label>
    <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control">
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Subtitle') }}</label>
    <textarea name="subtitle" class="form-control">{{ Arr::get($attributes, 'subtitle') }}</textarea>
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Limit') }}</label>
    <input type="number" name="limit" value="{{ Arr::get($attributes, 'limit') }}" class="form-control" placeholder="{{ __('Limit number of testimonials to show') }}">
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Style') }}</label>
    {!! Form::customSelect('style', [
            'style-1' => __('Style 1'),
            'style-2' => __('Style 2'),
        ], Arr::get($attributes, 'style', true))
    !!}
</div>
