@extends('installation::layouts.master')

@section('template_title')
	{{ trans('installation::installer_messages.environment.wizard.templateTitle') }}
@endsection

@section('container')


	<div id="step-6" class="tab-item staps active">
		<div class="wizard-card">
			<div class="wizard-body">
                @include('installation::elements.errors')
								
				<h3>{!! trans('installation::installer_messages.environment.wizard.step6_title') !!}</h3>
				<span class="w-75">{!! trans('installation::installer_messages.environment.wizard.step6_description') !!}</span>

				<form method="post" action="{{ route('LaravelInstaller::saveAdmin') }}" class="tabs-wrap mt-3">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="row align-items-center mb-3 {{ $errors->has('name') ? ' has-error ' : '' }}">
						<label for="name">
							{{ trans('installation::installer_messages.admin.name') }}
						</label>
						<div class="col-5">
							<input type="text" name="name" class="form-control" id="name" value="{{ old("name") }}" placeholder="{{ trans('installation::installer_messages.admin.name') }}" />
							@if ($errors->has('name'))
								<span class="error-block">
									<i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
									{{ $errors->first('name') }}
								</span>
							@endif
						</div>
						<div class="col-6 pt-0">
							<span class="form-text">
								{{ trans('installation::installer_messages.admin.name_description') }}
							</span>
						</div>
					</div>

					<div class="row align-items-center mb-3 {{ $errors->has('email') ? ' has-error ' : '' }}">
						<label for="email">
							{{ trans('installation::installer_messages.admin.email') }}
						</label>
						<div class="col-5">
							<input type="text" name="email" class="form-control" id="email" value="{{ old("email") }}" placeholder="{{ trans('installation::installer_messages.admin.email') }}" />
							@if ($errors->has('email'))
								<span class="error-block">
									<i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
									{{ $errors->first('email') }}
								</span>
							@endif
						</div>
						<div class="col-6 pt-0">
							<span class="form-text">
								{{ trans('installation::installer_messages.admin.email_description') }}
							</span>
						</div>
					</div>

					<div class="row align-items-center mb-3 {{ $errors->has('password') ? ' has-error ' : '' }}">
						<label for="password">
							{{ trans('installation::installer_messages.admin.password') }}
						</label>
						<div class="col-5">
							<input type="password" name="password" class="form-control" id="password" value="{{ old("password") }}" placeholder="{{ trans('installation::installer_messages.admin.password') }}" />
							@if ($errors->has('password'))
								<span class="error-block">
									<i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
									{{ $errors->first('password') }}
								</span>
							@endif
						</div>
						<div class="col-6 pt-0">
							<span class="form-text">
								{{ trans('installation::installer_messages.admin.password_description') }}
							</span>
						</div>
					</div>

					<div class="row align-items-center mb-3 {{ $errors->has('confirm_password') ? ' has-error ' : '' }}">
						<label for="confirm_password">
							{{ trans('installation::installer_messages.admin.confirm_password') }}
						</label>
						<div class="col-5">
							<input type="password" name="confirm_password" class="form-control" id="confirm_password" value="{{ old("confirm_password") }}" placeholder="{{ trans('installation::installer_messages.admin.confirm_password') }}" />
							@if ($errors->has('confirm_password'))
								<span class="error-block">
									<i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
									{{ $errors->first('confirm_password') }}
								</span>
							@endif
						</div>
						<div class="col-6 pt-0">
							<span class="form-text">
								{{ trans('installation::installer_messages.admin.confirm_password_description') }}
							</span>
						</div>
					</div>
					<a href="{{ route('LaravelInstaller::database') }}" class="btn btn-secondary mt-3">{!! trans('installation::installer_messages.requirements.prev') !!}</a>
					<button type="submit" class="btn btn-primary mt-3">
						{{ trans('installation::installer_messages.admin.save') }}
						<i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
					</button>
				</form>
			</div>
		</div>
	</div>
@endsection
