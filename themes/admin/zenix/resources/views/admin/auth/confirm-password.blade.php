{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('passwords.confirm_password') }}</h4>
        </div>
        <div class="authincation-content">
            <div class="row no-gutters">
                <div class="col-xl-12">
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="auth-form">
                        <h4 class="text-center mb-4">{{ __('passwords.password_confirm_text') }}</h4>
                        <form method="POST" action="{{ route('admin.password.confirm') }}">
                        @csrf
                            <div class="form-group">
                                <label class="mb-1"><strong>{{ __('passwords.password') }}</strong></label>
                                <input type="password" name="password" id="password" class="form-control" required autocomplete="current-password">
                                @error('password')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('passwords.confirm') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection