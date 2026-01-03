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
				<li class="breadcrumb-item"><a href="{{ route('admin.notification.index') }}">{{ __('common.notifications_config') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.add_notification_config') }}</a></li>
			</ol>
		</div>
	</div>

	<div class="card">
		<div class="card-header">
			<h4 class="card-title">{{ __('common.add_notification_config') }}</h4>
		</div>
		<form action="{{ route('admin.notification.store') }}" name="NotificationAdd" method="POST" enctype="multipart/form-data">
		@csrf
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12 form-group">
								<label>{{ __('common.event_title') }}</label>
								<input type="text" name="title" id="Title" class="form-control" autocomplete="title" value="{{ old('title') }}">
								@error('title')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
							<div class="col-md-12 form-group">
								<label for="Code">{{ __('common.code') }}</label>
								<input type="text" name="code" id="Code" class="form-control" autocomplete="code" value="{{ old('code') }}">
								@error('code')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
							<div class="col-md-12 form-group">
								<label for="TableModel">{{ __('common.table_model') }}</label>
								<input type="text" name="table_model" id="TableModel" class="form-control" autocomplete="table_model" value="{{ old('table_model') }}">
								<small>ex: User, Ticket, Category, Article... etc.</small>
								@error('table_model')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
							<div class="col-md-12 form-group">
								<label for="subject">{{ __('common.subject') }}</label>
								<input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12">
								<label for="Placeholders">{{ __('common.placeholders') }}</label>
								<textarea name="placeholders" id="Placeholders" class="form-control NotifyPlaceholderCkeditor">{!! old('placeholders') !!}</textarea>
								<button type="button" id="DefaultPlaceholder" class="btn btn-info mt-2">{{ __('common.add_default_placeholder') }}</button>
								<div id="PlaceholderSec" class="d-none">
									{{ $placeholderData }}
								</div>		
								@error('placeholders')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 mb-3">
						<label><input type="checkbox" name="notification_types[1]" class="EnableNotificationBox form-check-input mt-0" rel="EmailNotificationSec" @checked(old('notification_types.1'))> {{ __('common.email_notification') }}</label>
						<div class="form-group EmailNotificationSec {{ old('notification_types.1') ? '' : 'd-none' }}">
							<textarea name="content[1]" class="form-control W3cmsCkeditor" id="EmailContent" rows="5">{{ old('content.1') }}</textarea>
						</div>
					</div>
					<div class="col-md-12 mb-3">
						<label><input type="checkbox" name="notification_types[2]" class="EnableNotificationBox form-check-input mt-0" rel="WebNotificationSec" @checked(old("notification_types.2"))> {{ __('common.web_notification') }}</label>
						<div class="form-group WebNotificationSec {{ old('notification_types.2') ? '' : 'd-none' }}">
							<textarea name="content[2]" class="form-control W3cmsCkeditor" id="WebContent" rows="5">{{ old('content.2') }}</textarea>
						</div>
					</div>
					<div class="col-md-12">
						<label><input type="checkbox" name="notification_types[3]" class="EnableNotificationBox form-check-input mt-0" rel="SMSNotificationSec" @checked(old("notification_types.3"))> {{ __('common.sms_notification') }}</label>
						<div class="form-group SMSNotificationSec {{ old('notification_types.3') ? '' : 'd-none' }}">
							<textarea name="content[3]" class="form-control W3cmsCkeditor" id="SMSContent" rows="5">{{ old('content.3') }}</textarea>
						</div>
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