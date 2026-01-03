@extends('admin.layout.fullwidth')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.password.email') }}">
                            @csrf
                            <div class="mb-4 text-center">
                                <img src="{{ asset('storage/configuration-images/'.config('Admin.logo_dark')) }}">
                                <h4 class="form-title">{{ __('passwords.forgot_pass') }}</h4>
                            </div>
                            <div class="form-group row">
                                <p>{{ __('passwords.reset_password_by_email') }}</p>
                                <div class="col-12">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('passwords.enter_email') }}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="">
                                    <a class="link ms-2 text-primary" href="{{ url('/admin/login') }}"> <i class="fas fa-arrow-left"></i> {{ __('common.back') }} </a>
                                    <button type="submit" class="float-end text-primary shadow-none bg-transparent border-0">
                                        {{ __('common.send') }} <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
