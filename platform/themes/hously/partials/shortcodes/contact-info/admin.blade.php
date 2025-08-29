<div class="form-group">
    <label class="control-label">{{ __('Phone') }}</label>
    <input type="text" name="phone" value="{{ Arr::get($attributes, 'phone') }}" class="form-control" placeholder="{{ __('Phone') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Phone description') }}</label>
    <textarea name="phone_description" class="form-control" rows="3" placeholder="{{ __('Phone description') }}">{{ Arr::get($attributes, 'phone_description') }}</textarea>
</div>

<div class="form-group">
    <label class="control-label">{{ __('Email') }}</label>
    <input type="text" name="email" value="{{ Arr::get($attributes, 'email') }}" class="form-control" placeholder="{{ __('Email') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Email description') }}</label>
    <textarea name="email_description" class="form-control" rows="3" placeholder="{{ __('Email description') }}">{{ Arr::get($attributes, 'email_description') }}</textarea>
</div>

<div class="form-group">
    <label class="control-label">{{ __('Address') }}</label>
    <input type="text" name="address" value="{{ Arr::get($attributes, 'address') }}" class="form-control" placeholder="{{ __('Address') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Address description') }}</label>
    <textarea name="address_description" class="form-control" rows="3" placeholder="{{ __('Address description') }}">{{ Arr::get($attributes, 'address_description') }}</textarea>
</div>
