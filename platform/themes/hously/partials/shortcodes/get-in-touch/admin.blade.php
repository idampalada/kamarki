<div class="form-group mb-3">
    <label class="control-label">{{ __('Title') }}</label>
    <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control">
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Subtitle') }}</label>
    <textarea name="subtitle" class="form-control">{{ Arr::get($attributes, 'subtitle') }}</textarea>
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Button label') }}</label>
    <input name="button_label" value="{{ Arr::get($attributes, 'button_label') }}" class="form-control">
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Button URL') }}</label>
    <input name="button_url" value="{{ Arr::get($attributes, 'button_url') }}" class="form-control">
</div>
