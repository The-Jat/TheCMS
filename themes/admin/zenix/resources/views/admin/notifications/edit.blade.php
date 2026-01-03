{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

@php
	$templates1  = $templatesObj->get_notification_template($notification_template->id, 1);
	$templates2  = $templatesObj->get_notification_template($notification_template->id, 2);
	$templates3  = $templatesObj->get_notification_template($notification_template->id, 3);
@endphp

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
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.edit_notification_config') }}</a></li>
			</ol>
		</div>
	</div>

	<div class="card">
		<div class="card-header">
			<h4 class="card-title">{{ __('common.edit_notification_config') }}</h4>
		</div>
		<form action="{{ route('admin.notification.update', $notification_template->id) }}" method="POST" enctype="multipart/form-data">
		@csrf
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="row">
							<div class="form-group col-md-12">
								<label for="Title">{{ __('common.event_title') }}</label>
								<input type="text" name="title" id="Title" class="form-control" autocomplete="title" value="{{ old('title', $notification_template->title) }}">
								@error('title')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div> 
							<div class="form-group col-md-12">
								<label for="Code">{{ __('common.code') }}</label>
								<input type="text" name="code" id="Code" class="form-control" autocomplete="code" value="{{ old('code', $notification_template->code) }}">
								@error('code')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
							<div class="form-group col-md-12">
								<label for="TableModel">{{ __('common.table_model') }}</label>
								<input type="text" name="table_model" id="TableModel" class="form-control" autocomplete="table_model" value="{{ old('table_model', $notification_template->table_model) }}">
								<small>ex: User, Ticket, Category, Articles... etc.</small>
								@error('table_model')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
							<div class="form-group col-md-12">
								<div class="form-group">
									<label for="subject">{{ __('common.subject') }}</label>
									<input type="text" name="subject" id="subject" class="form-control" value="{!! $templates1->subject !!}">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="form-group col-md-12">
								<label for="Placeholders">{{ __('common.placeholders') }}</label>
								<textarea name="placeholders" id="Placeholders" class="form-control NotifyPlaceholderCkeditor" cols="30" rows="10">{{ old('placeholders', $notification_template->placeholders) }}</textarea>
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
					<div class="form-group col-md-12">
						<label>
							<input type="checkbox" name="notification_types[1]" class="EnableNotificationBox" rel="EmailNotificationSec" @checked(Str::contains($notification_template->notification_types, '1'))> {{ __('common.email_notification') }}
						</label>
						<div class="{{ Str::contains($notification_template->notification_types, '1') ? '' : 'd-none' }} EmailNotificationSec">
							<div class="form-group default-summernote">
								<textarea name="content[1]" class="form-control W3cmsCkeditor" id="EmailContent" rows="5">{!! $templates1->content !!}</textarea>
							</div>
						</div>
					</div>
					<div class="form-group col-md-12">
						<label>
							<input type="checkbox" name="notification_types[2]" class="EnableNotificationBox" rel="WebNotificationSec" @checked(Str::contains($notification_template->notification_types, '2'))> {{ __('common.web_notification') }}
						</label>
						<div class="{{ Str::contains($notification_template->notification_types, '2') ? '' : 'd-none' }} WebNotificationSec">
							<div class="form-group default-summernote">
								<textarea name="content[2]" class="form-control W3cmsCkeditor" id="WebContent" rows="5">{!! $templates2->content !!}</textarea>
							</div>
						</div>
					</div>
					<div class="form-group col-md-12">
						<label>
							<input type="checkbox" name="notification_types[3]" class="EnableNotificationBox" rel="SMSNotificationSec" @checked(Str::contains($notification_template->notification_types, '3'))> {{ __('common.sms_notification') }}
						</label>
						<div class="{{ Str::contains($notification_template->notification_types, '3') ? '' : 'd-none' }} SMSNotificationSec">
							<div class="form-group default-summernote">
								<textarea name="content[3]" class="form-control W3cmsCkeditor" id="SMSContent" rows="5">{!! $templates3->content !!}</textarea>
							</div>
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