 @extends('plugins/real-estate::account.layouts.skeleton')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ trans('Verify Your Contact Number ') }}</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-success" role="alert">
                            {{ trans('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('otplogin') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user_id}}" />
                        <div class="row mb-3">
                            <label for="mobile_no" class="col-md-4 col-form-label text-md-end">{{ __('OTP') }}</label>

                            <div class="col-md-6">
                                <input id="otp" type="text" class="form-control @error('otp') is-invalid @enderror" name="otp" value="{{ old('otp') }}" required autocomplete="otp" autofocus placeholder="Enter OTP">

                                @error('otp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">

                            <div class="col-md-2 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>

                    </form>
                    @isset ($resend)
                    <div class="col-md-3">
                        <form action="{{route('opt.resend')}}" method="POST" >
                            @csrf
                            <input type="hidden" name="user_id" value="{{$user_id}}" />

                            <button type="submit" class="btn btn-primary">
                                Resend Otp
                            </button>
                        </form>
                    </div>
                    @endisset
                </div>

                    {{-- {{ trans('Before proceeding, please check your contact for a verification code.') }}
                    {{ trans('If you did not receive the code') }}, <a href="{{ route('public.account.resend_confirmation') }}">{{ trans('click here to request another') }}</a>. --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
