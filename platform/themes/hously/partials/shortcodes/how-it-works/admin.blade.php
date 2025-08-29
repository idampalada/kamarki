<div class="form-group mb-3">
    <label class="control-label">{{ __('Title') }}</label>
    <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control">
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Subtitle') }}</label>
    <textarea name="subtitle" class="form-control">{{ Arr::get($attributes, 'subtitle') }}</textarea>
</div>

@foreach(range(1, 3) as $i)
    <div style="border: 1px dashed #000; padding: 10px; margin: 15px auto;">
        <div class="form-group mb-3">
            <label class="control-label">{{ __('Icon :i', ['i' => $i]) }}</label>
            <input name="icon_{{ $i }}" value="{{ Arr::get($attributes, 'icon_' . $i) }}" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label class="control-label">{{ __('Title :i', ['i' => $i]) }}</label>
            <input name="title_{{ $i }}" value="{{ Arr::get($attributes, 'title_' . $i) }}" class="form-control">
        </div>
        <div class="form-group mb-3">
            <label class="control-label">{{ __('Description :i', ['i' => $i]) }}</label>
            <textarea name="description_{{ $i }}" class="form-control">{{ Arr::get($attributes, 'description_' . $i) }}</textarea>
        </div>
    </div>
@endforeach
