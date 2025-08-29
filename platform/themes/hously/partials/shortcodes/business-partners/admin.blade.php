@foreach(range(1, 10) as $i)
    <div style="border: 1px dashed #000; padding: 10px; margin-bottom: {{ $i === 10 ? 0 : 15 }}px;">
        <div class="form-group mb-3">
            <label class="control-label">{{ __('Name :number', ['number' => $i]) }}</label>
            <input name="name_{{ $i }}" value="{{ Arr::get($attributes, 'name_' . $i) }}" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label class="control-label">{{ __('URL :number', ['number' => $i]) }}</label>
            <input name="url_{{ $i }}" value="{{ Arr::get($attributes, 'url_' . $i) }}" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label class="control-label">{{ __('Logo :number', ['number' => $i]) }}</label>
            {!! Form::mediaImage('logo_' . $i, Arr::get($attributes, 'logo_' . $i)) !!}
        </div>
    </div>
@endforeach
