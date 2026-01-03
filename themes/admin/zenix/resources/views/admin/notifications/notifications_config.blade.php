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
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.all_notifications_config') }}</a></li>
			</ol>
		</div>
	</div>

	@php
        $collapsed = 'collapsed';
        $show = '';
    @endphp

    @if(!empty(request()->title))
        @php
            $collapsed = '';
            $show = 'show';
        @endphp
    @endif

	<!-- row -->
	<!-- Row starts -->
	<div class="row">
		<!-- Column starts -->
		<div class="col-xl-12">
			<div class="card accordion accordion-rounded-stylish accordion-bordered" id="search-sec-outer">
				<div class="accordion-header rounded-lg {{ $collapsed }}" data-bs-toggle="collapse" data-bs-target="#rounded-search-sec">
					<span class="accordion-header-icon"></span>
                    <h4 class="accordion-header-text m-0">{{ __('Search Notification Config') }}</h4>
                    <span class="accordion-header-indicator"></span>
				</div>
				<div class="card-body collapse accordion__body {{ $show }}" id="rounded-search-sec" data-bs-parent="#search-sec-outer">
					<form action="{{ route('admin.notification.notifications_config') }}" method="get">
					@csrf
						<input type="hidden" name="todo" value="Filter">
						<div class="row">
							<div class="mb-3 col-md-3">
								<input type="text" name="title" class="form-control" placeholder="{{ __('common.event_title') }}">
							</div>
							<div class="mb-3 col-md-3">
								<input type="text" name="code" class="form-control" placeholder="{{ __('common.code') }}">
							</div>
							<div class="mb-3 col-md-6">
								<input type="submit" name="search" value="{{ __('common.search') }}" class="btn btn-primary me-2"> 
								<a href="{{ route('admin.notification.notifications_config') }}" class="btn btn-danger">{{ __('common.reset') }}</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<!-- Column starts -->
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">{{ __('common.all_notifications_config') }}</h4>
					<a href="{{ route('admin.notification.create') }}" class="btn btn-primary">{{ __('common.add_notification_config') }}</a>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-md mb-0">
							<thead>
								<tr>
									<th><strong>{{ __('common.s_no') }}</strong></th>
									<th><strong>{{ __('common.event_title') }}</strong></th>
									<th><strong>{{ __('common.code') }}</strong></th>
									<th><strong>{{ __('common.email') }}</strong></th>
									<th><strong>{{ __('common.web') }}</strong></th>
									<th><strong>{{ __('common.sms') }}</strong></th>
									<th><strong>{{ __('common.actions') }}</strong></th>
								</tr>
							</thead>
							<tbody>
								@php
									$i = $notifications_config->firstItem();
								@endphp
								@forelse($notifications_config as $notification_config)
									<tr>
										<td>
											{{ $i++ }}
										</td>
										<td>{{ $notification_config->title }}</td>
										<td>
											{{ $notification_config->code }}
										</td>
										<td>
											@if(Str::contains($notification_config->notification_types, '1'))
												<span class="badge badge-success">
													<i class="fa fa-check"></i>
												</span>
											@else
												<span class="badge badge-danger">
													<i class="fa fa-times"></i>
												</span>
											@endif
											<a href="{!! route('admin.notification.edit_email_template', $notification_config->id) !!}" class="btn btn-primary shadow btn-xs sharp mr-1 Email-Template" data-toggle="tooltip" data-title="{{ __('common.edit_email_template') }}" data-config-id="{{ $notification_config->id }}"><i class="fas fa-pencil-alt"></i></a>
										</td>
										<td>
											@if(Str::contains($notification_config->notification_types, '2'))
												<span class="badge badge-success">
													<i class="fa fa-check"></i>
												</span>
											@else
												<span class="badge badge-danger">
													<i class="fa fa-times"></i>
												</span>
											@endif
											<a href="{!! route('admin.notification.edit_web_template', $notification_config->id) !!}" class="btn btn-primary shadow btn-xs sharp mr-1 Web-Template" data-toggle="tooltip" data-title="{{ __('common.edit_web_template') }}" data-config-id="{{ $notification_config->id }}"><i class="fas fa-pencil-alt"></i></a>
										</td>
										<td>
											@if(Str::contains($notification_config->notification_types, '3'))
												<span class="badge badge-success">
													<i class="fa fa-check"></i>
												</span>
											@else
												<span class="badge badge-danger">
													<i class="fa fa-times"></i>
												</span>
											@endif
											<a href="{!! route('admin.notification.edit_sms_template', $notification_config->id) !!}" class="btn btn-primary shadow btn-xs sharp mr-1 SMS-Template" data-toggle="tooltip" data-title="{{ __('common.edit_sms_template') }}" data-config-id="{{ $notification_config->id }}"><i class="fas fa-pencil-alt"></i></a>
										</td>
										<td>
											<a href="{!! route('admin.notification.edit_template', $notification_config->id) !!}" class="btn btn-primary shadow btn-xs sharp mr-1 All-Template" data-toggle="tooltip" data-title="{{ __('common.email_template') }}" data-config-id="{{ $notification_config->id }}"><i class="fas fa-pencil-alt"></i></a>
											<a href="{{ route('admin.notification.edit', $notification_config->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fas fa-pencil-alt"></i></a>
											<a href="{{ route('admin.notification.destroy', $notification_config->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
										</td>
									</tr>
								@empty
								<tr>
									<td colspan="7" class="text-center">{{ __('common.no_notification_templates_found') }}</td>
								</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer">
					{{ $notifications_config->onEachSide(2)->appends(Request::input())->links() }}
				</div>
			</div>
		</div>
	</div>

</div>


@endsection