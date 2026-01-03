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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.all_notifications') }}</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('common.all_notifications') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg mb-0">
                            <thead>
                                <tr>
                                    <th> <strong> {{ __('S.No.') }} </strong></th>
                                    <th> <strong> {{ __('common.sender_name') }} </strong></th>
                                    <th> <strong> {{ __('common.message') }} </strong></th>
                                    <th> <strong> {{ __('common.read_status') }} </strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = $notifications->firstItem();
                                @endphp
                                @forelse($notifications as $notification)
                                    <tr>
                                        <td>
                                            {{ $i++ }}
                                        </td>
                                        <td>
                                            {{ optional($notification->sender)->full_name }}
                                        </td>
                                        <td>
                                            {!! $notificationObj->get_message(optional($notification->notification_config)->table_model, $notification->notification_config_id, $notification->sender_id, $notification->receiver_id, $notification->object_id) !!}
                                        </td>
                                        <td>
                                            @if($notification->read)
                                                {{ __('common.read') }}
                                            @else
                                                {{ __('common.unread') }}
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">{{ __('common.no_notifications_found') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {!! $notifications->links() !!}
                </div>
            </div>
        </div>
    </div>

</div>


@endsection