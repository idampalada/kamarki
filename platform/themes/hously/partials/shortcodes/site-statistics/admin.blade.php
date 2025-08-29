<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Subtitle') }}</label>
    <input type="text" name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control" placeholder="{{ __('Subtitle') }}">
</div>

@for($i = 1; $i <= 3; $i++)
    <div class="form-group">
        <label class="control-label">{{ __('Title :number', ['number' => $i]) }}</label>
        <input type="text" name="title_{{ $i }}" value="{{ Arr::get($attributes, 'title_' . $i) }}" class="form-control" placeholder="{{ __('Title') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Number :number', ['number' => $i]) }}</label>
        <input type="text" name="number_{{ $i }}" value="{{ Arr::get($attributes, 'number_' . $i) }}" class="form-control" placeholder="{{ __('Number') }}">
    </div>
@endfor

<div class="form-group">
    <label class="control-label">{{ __('Background Image') }}</label>
    {!! Form::mediaImage('background_image', Arr::get($attributes, 'background_image')) !!}
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Style') }}</label>
    {!! Form::customSelect('style', ['no-title' => __('No title'), 'has-title' => __('Has title')], Arr::get($attributes, 'style')) !!}
</div>
