{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
    <div class="row page-titles mx-0 mb-3">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
				<h4>{{ __('common.welcome_back_title') }}</h4>
				<p class="mb-0">{{ __('common.welcome_back_desc') }}</p>
		    </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.notification.index') }}">{{ __('common.notification_template') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.edit_notification_template') }}</a></li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('common.edit_notification_template') }}</h4>
        </div>
        <form action="{{ route('admin.notification.edit_template', $config_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        @php 
                            $templates = $templatesObj->get_notification_template($config_id, 1)
                        @endphp
                        <div id="EmailNotificationSec">
                            <div class="form-group">
                                <label for="subject"><strong>{{ __('common.subject') }}</strong></label>
                                <input type="text" name="subject" id="subject" class="form-control" value="{!! $templates->subject !!}">
                            </div>
                    	   <h5>{{ __('common.email_template') }}</h5>
                    	   <hr>
                            <div class="form-group">
                                <textarea name="content[1]" class="form-control W3cmsCkeditor" id="EmailContent" rows="5">{!! $templates->content !!}</textarea>
                            </div>
                        </div>

                        @php 
                            $templates = $templatesObj->get_notification_template($config_id, 2);
                        @endphp
                        <h5>{{ __('common.web_template') }}</h5>
                    	<hr>
                        <div id="WebNotificationSec">
                            <div class="form-group">
                                <textarea name="content[2]" class="form-control W3cmsCkeditor" id="WebContent" rows="5">{!! $templates->content !!}</textarea>
                            </div>
                        </div>

                        @php 
                            $templates = $templatesObj->get_notification_template($config_id, 3);
                        @endphp
                        <h5>{{ __('common.sms_template') }}</h5>
                    	<hr>
                        <div id="SMSNotificationSec">
                            <div class="form-group">
                                <textarea name="content[3]" class="form-control W3cmsCkeditor" id="SMSContent" rows="5">{!! $templates->content !!}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        {!! $notification_config->placeholders !!}
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>
                <a href="{{ route('admin.notification.index') }}" class="btn btn-danger">{{ __('common.back') }}</a>
            </div>
        </form>
    </div>

</div>

@endsection