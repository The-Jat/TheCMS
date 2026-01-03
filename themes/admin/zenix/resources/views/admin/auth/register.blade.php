@extends('admin.layout.fullwidth')

@section('content')

    <div class="col-md-6">
        <div class="authincation-content">
            <div class="row no-gutters">
                <div class="col-xl-12">
                    <div class="auth-form">
                        <div class="text-center mb-3">
                            @if (!empty(config('Admin.logo_dark')) && \Storage::exists('public/configuration-images/'.config('Admin.logo_dark')))
                                <img width="150px" src="{{ asset('storage/configuration-images/'.config('Admin.logo_dark')) }}">
                            @else
                                <img width="150px" src="{{ asset('images/logo-full-black.png') }}">
                            @endif
                        </div>
                        <h4 class="text-center mb-4">{{ __('common.register_account_text') }}</h4>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name" class="mb-1"><strong>{{ __('common.name') }}</strong></label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="{{ __('common.full_name') }}" required>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group ">
                                <label for="login_email" class="mb-1"><strong>{{ __('common.email') }}</strong></label>
                                <input id="login_email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" placeholder="{{ __('common.email') }}" required>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="password" class="mb-1"><strong>{{ __('common.password') }}</strong></label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('common.password') }}" required>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="password-confirm" class="mb-1"><strong>{{ __('common.confirm_password') }}</strong></label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('common.confirm_password') }}" required>
                                    @error('password-confirm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('common.register') }}</button>
                            </div>
                        </form>
                        <div class="new-account mt-3">
                            <p>{{ __('common.already_have_account') }} <a class="text-primary" href="{{ url('/admin/login') }}">{{ __('common.sign_in') }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
