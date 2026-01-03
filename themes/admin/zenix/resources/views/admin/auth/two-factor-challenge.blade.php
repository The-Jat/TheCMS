@extends('admin.layout.fullwidth')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-2" id="secretCodeForm">
                    <div class="card-header">{{ __('common.two_factor_secret_code') }}</div>
                    <div class="card-body">
                        <p class="fw-bold">{{ __('common.two_fac_secret_code_text') }}</p>

                        <form method="POST" action="{{ route('two-factor.login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('common.secret_code') }}</label>

                                <div class="col-md-6">
                                    <input id="code" type="password" class="form-control @error('code') is-invalid @enderror" name="code" required autocomplete="current-code">

                                    @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('common.submit') }}
                                    </button>
                                    <div class="btn btn-link TwoFactorAuthForm" rel="recovery_form">
                                        {{ __('common.use_recovery_code') }}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="card mt-2 d-none" id="recoveryCodeForm">
                    <div class="card-header">{{ __('common.2fa_recovery_code') }}</div>

                    <div class="card-body">
                        <p class="fw-bold">{{ __('common.2fa_recovery_code_text') }}</p>

                        <form method="POST" action="{{ route('two-factor.login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="recovery_code" class="col-md-4 col-form-label text-md-right">{{ __('Recovery Code') }}:</label>

                                <div class="col-md-6">
                                    <input id="recovery_code" type="password" class="form-control @error('recovery_code') is-invalid @enderror" name="recovery_code" required autocomplete="current-recovery_code">

                                    @error('recovery_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('common.submit') }}
                                    </button>
                                    <div class="btn btn-link TwoFactorAuthForm" rel="secret_code">
                                        {{ __('Use Secret Code') }}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection