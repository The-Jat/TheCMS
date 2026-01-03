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
                <li class="breadcrumb-item"><a href="{{ route('admin.notification.index') }}">{{ __('common.notifications') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.notifications_settings') }}</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card">
                <form action="{{ route('admin.notification.settings') }}" method="post">
                    @csrf
                    <div class="card-header d-flex">
                        <h4 class="card-title">{{ __('common.notifications') }}</h4>
                        <button type="submit" class="btn btn-primary">{{ __('common.update') }}</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-sm mb-0">
                                <thead>
                                    <tr>
                                        <th> <strong>  </strong> </th>
                                        <th> <strong> {{ __('common.event_type') }} </strong> </th>
                                        <th class="text-center"> <strong> {{ __('common.email') }} </strong> </th>
                                        <th class="text-center"> <strong> {{ __('common.web') }} </strong> </th>
                                        <th class="text-center"> <strong> {{ __('common.sms') }} </strong> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($notifications as $key => $notification)
                                        <tr>
                                            <td>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="notification_types[{{ $notification->id }}][all]" class="form-check-input All-Notification" @checked($notification->status == 1)>
                                                </label>
                                            </td>
                                            <td>{{ $notification->title }}</td>
                                            <td class="text-center">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="notification_types[{{ $notification->id }}][1]" class="form-check-input Notification" @checked(Str::contains($notification->notification_types, '1')) @disabled($notification->status != 1)>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="notification_types[{{ $notification->id }}][2]" class="form-check-input Notification" @checked(Str::contains($notification->notification_types, '2')) @disabled($notification->status != 1)>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="notification_types[{{ $notification->id }}][3]" class="form-check-input Notification" @checked(Str::contains($notification->notification_types, '3')) @disabled($notification->status != 1)>
                                                </label>
                                            </td>
                                        </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">{{ __('common.no_notifications_setting_found') }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">{{ __('common.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>


@endsection