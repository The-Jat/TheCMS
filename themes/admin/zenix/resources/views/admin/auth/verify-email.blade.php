@extends('admin.layout.fullwidth')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('common.verify_email_text') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('common.verification_link_sent_on_email') }}
                            </div>
                        @endif

                        {{ __('common.check_email_verification_link') }}
                        {{ __('common.if_not_receive_email') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('common.click_to_request_another') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection