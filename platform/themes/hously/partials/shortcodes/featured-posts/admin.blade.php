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
    <input type="number" name="limit" value="{{ Arr::get($attributes, 'limit', 3) }}" class="form-control" placeholder="{{ __('Number of posts to show, default is 3') }}">
</div>
