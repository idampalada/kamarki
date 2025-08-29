<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Subtitle') }}</label>
    <input type="text" name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control" placeholder="{{ __('Subtitle') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Time end') }}</label>
    <input type="date" name="time" value="{{ Arr::get($attributes, 'time') }}" class="form-control" placeholder="{{ __('Time end') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Enable "snow" effect?') }}</label>
    {!! Form::onOff('enable_snow_effect', Arr::get($attributes, 'enable_snow_effect')) !!}
</div>

<div class="form-group">
    <label class="control-label">{{ __('Background Image') }}</label>
    {!! Form::mediaImage('background_image', Arr::get($attributes, 'background_image')) !!}
</div>
