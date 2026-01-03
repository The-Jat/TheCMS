@php
$appUrl =  str_replace('public', '', url('/'));
@endphp

@extends('installation::layouts.master')

@section('template_title')
	{{ trans('installation::installer_messages.environment.wizard.templateTitle') }}
@endsection

@section('container')
	
	<form method="post" action="{{ route('LaravelInstaller::environmentSaveWizard') }}" class="tabs-wrap setup-form">
		@csrf
		<div id="step-3" class="tab-item staps EnvStepContent Step3 active">
			<div class="wizard-card">
				<div class="wizard-body">
					@include('installation::elements.errors')
					<h3>{!! trans('installation::installer_messages.environment.wizard.step3_title') !!}</h3>
					<span class="w-75">{!! trans('installation::installer_messages.environment.wizard.step3_description') !!}</span>
                    <div class="row mb-3">
                    	<div class="col-md-6">
							<label for="app_name" class="col-form-label">{{ trans('installation::installer_messages.environment.wizard.form.app_name_label') }}</label>
							<input type="text" name="app_name" id="app_name" class="form-control" value="{{ old('app_name', config('app.name')) }}" placeholder="{{ trans('installation::installer_messages.environment.wizard.form.app_name_placeholder') }}" />
							@if ($errors->has('app_name'))
								<span class="error-block">
									<i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
									{{ $errors->first('app_name') }}
								</span>
							@endif
							<span  class="form-text">
								{{ trans('installation::installer_messages.environment.wizard.form.input_labels.app_name') }}
							</span>
						</div>
						<div class="col-md-6">
							<label for="app_url" class="col-form-label">{{ trans('installation::installer_messages.environment.wizard.form.app_url_label') }}</label>
							<input type="url" name="app_url" id="app_url" class="form-control" value="{{ old('app_url', $appUrl) }}" placeholder="{{ trans('installation::installer_messages.environment.wizard.form.app_url_placeholder') }}" />
							@if(!Str::contains(request()->getHttpHost(), ':'))
								<input type="hidden" name="asset_url" id="asset_url" class="form-control" value="{{ old('asset_url', url('public/')) }}" placeholder="{{ trans('installation::installer_messages.environment.wizard.form.app_url_placeholder') }}" />
							@endif
							@if ($errors->has('app_url'))
								<span class="error-block">
									<i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
									{{ $errors->first('app_url') }}
								</span>
							@endif
							<span  class="form-text">
								{{ trans('installation::installer_messages.environment.wizard.form.input_labels.app_url') }}
							</span>
						</div>
					</div>

					<span class="w-75 fw-normal">{!! trans('installation::installer_messages.environment.wizard.step4_description') !!}</span>

                    <div class="row">
	                    <div class="col-md-6">
							<label for="database_connection" class="col-form-label">{{ trans('installation::installer_messages.environment.wizard.form.db_connection_label') }}</label>
							<select name="database_connection" id="database_connection" class="form-control">
								<option value="mysql" {{ old('database_connection') == 'mysql' ? 'selected' : '' }}>{{ trans('installation::installer_messages.environment.wizard.form.db_connection_label_mysql') }}</option>
							</select>
							@if ($errors->has('database_connection'))
								<span class="error-block">
									<i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
									{{ $errors->first('database_connection') }}
								</span>
							@endif
							<span  class="form-text">
								{{ trans('installation::installer_messages.environment.wizard.form.input_labels.db_connection') }}
							</span>
						</div>
						<div class="col-md-6">
							<label for="database_hostname" class="col-form-label">
								{{ trans('installation::installer_messages.environment.wizard.form.db_host_label') }}
							</label>
							<input type="text" name="database_hostname" id="database_hostname" class="form-control" value="{{ old('database_hostname', '127.0.0.1') }}" placeholder="{{ trans('installation::installer_messages.environment.wizard.form.db_host_placeholder') }}" />
							@if ($errors->has('database_hostname'))
								<span class="error-block">
									<i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
									{{ $errors->first('database_hostname') }}
								</span>
							@endif
							<span  class="form-text">
								{{ trans('installation::installer_messages.environment.wizard.form.input_labels.db_host') }}
							</span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label for="database_name" class="col-form-label">
								{{ trans('installation::installer_messages.environment.wizard.form.db_name_label') }}
							</label>
							<input type="text" name="database_name" id="database_name" class="form-control" value="{{ old('database_name', env('DB_DATABASE')) }}" placeholder="{{ trans('installation::installer_messages.environment.wizard.form.db_name_placeholder') }}" />
							@if ($errors->has('database_name'))
								<span class="error-block">
									<i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
									{{ $errors->first('database_name') }}
								</span>
							@endif
							<span  class="form-text">
								{{ trans('installation::installer_messages.environment.wizard.form.input_labels.db_name') }}
							</span>
						</div>
						<div class="col-md-6">
							<label for="database_port" class="col-form-label">
								{{ trans('installation::installer_messages.environment.wizard.form.db_port_label') }}
							</label>
							<input type="number" name="database_port" id="database_port" class="form-control" value="{{ old('database_port', '3306') }}" placeholder="{{ trans('installation::installer_messages.environment.wizard.form.db_port_placeholder') }}" />
							@if ($errors->has('database_port'))
								<span class="error-block">
									<i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
									{{ $errors->first('database_port') }}
								</span>
							@endif
							<span  class="form-text">
								{{ trans('installation::installer_messages.environment.wizard.form.input_labels.db_port') }}
							</span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label for="database_username" class="col-form-label">
								{{ trans('installation::installer_messages.environment.wizard.form.db_username_label') }}
							</label>
							<input type="text" name="database_username" id="database_username" class="form-control" value="{{ old('database_username', env('DB_USERNAME')) }}" placeholder="{{ trans('installation::installer_messages.environment.wizard.form.db_username_placeholder') }}" />
							@if ($errors->has('database_username'))
								<span class="error-block">
									<i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
									{{ $errors->first('database_username') }}
								</span>
							@endif
							<span  class="form-text">
								{{ trans('installation::installer_messages.environment.wizard.form.input_labels.db_user_name') }}
							</span>
						</div>
						<div class="col-md-6">
							<label for="database_password" class="col-form-label">
								{{ trans('installation::installer_messages.environment.wizard.form.db_password_label') }}
							</label>
							<input type="password" name="database_password" id="database_password" class="form-control" value="{{ old('database_password', env('DB_PASSWORD')) }}" placeholder="{{ trans('installation::installer_messages.environment.wizard.form.db_password_placeholder') }}" />
							@if ($errors->has('database_password'))
								<span class="error-block">
									<i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
									{{ $errors->first('database_password') }}
								</span>
							@endif
							<span  class="form-text">
								{{ trans('installation::installer_messages.environment.wizard.form.input_labels.db_password') }}
							</span>
						</div>
					</div>

					<a href="{{ route('LaravelInstaller::requirements') }}" class="btn btn-secondary mt-3">{!! trans('installation::installer_messages.requirements.prev') !!}</a>
					<button type="submit" class="btn btn-primary mt-3">{{ trans('installation::installer_messages.requirements.next') }}</button>

		        </div>
		    </div>
		</div>
	</form>

	</div>
@endsection
