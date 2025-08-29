@foreach(['facebook', 'linkedin', 'instagram'] as $social)
    <div class="form-group mb-3">
        <label>{{ __(':social URL', ['social' => ucfirst($social)]) }}</label>
        {!! Form::text('social_' . $social, old('social_' . $social, MetaBox::getMetaData($account, 'social_' . $social, true)), ['class' => 'form-control']) !!}
    </div>
@endforeach
