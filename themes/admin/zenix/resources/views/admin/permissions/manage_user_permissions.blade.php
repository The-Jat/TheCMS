{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-0">
            <div class="welcome-text">
				<h4>{{ __('common.welcome_back_title') }}</h4>
				<p class="mb-0">{{ __('common.welcome_back_desc') }}</p>
		    </div>
        </div>
        <div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">{{ __('common.permissions') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.manage_user_permissions') }}</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md mb-0">
                            <thead>
                                <tr>
                                    <th><strong>{{ __('common.name') }}</strong></th>
                                    <th><strong>{{ __('common.email') }}</strong></th>
                                    <th><strong>{{ __('common.actions') }}</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> {{ $user->full_name }} </td>
                                    <td> {{ $user->email }} </td>
                                    <td> 
                                        <label class="permission-switch">
                                            <input type="checkbox" class="RemoveUserPermission" id="RemoveUserPermission_{{ $user->id }}" data-user-id="{{ $user->id }}" rdx-link="{{ route('admin.permissions.manage_user_all_permission', $user->id)}}" {{ !$userPermissions->isEmpty() ? 'checked="checked"' : '' }}>
                                            <span class="permission-switch-slider"></span>
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!$rolesArr->isEmpty())

        <div class="row">

            @php 
                $permissions_list = config('permission.acl.action_list'); 
            @endphp

            @foreach($modulePermissions as $moduleKey => $module)

                <div class="col-xl-12">
                    <div class="card accordion accordion-bordered" id="accordion-{{ $moduleKey }}">

                        <div class="card-header d-block accordion-header  rounded-lg collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $moduleKey }}">
                            <h4 class="card-title">{{ ucfirst($moduleKey) }}</h4>
                            <span class="accordion-header-indicator"></span>
                        </div>

                        <div class="card-body accordion-body collapse" id="collapse-{{ $moduleKey }}" data-bs-parent="#accordion-{{ $moduleKey }}">
                            @php
                                $i = 1;
                            @endphp
                            @forelse($module as $controllerKey => $controller)

                                <div id="accordion-{{ $moduleKey }}-{{ $i }}" class="accordion accordion-bordered accordion-primary custom-accordion">
                                    <div class="accordion-item">
                                        <div class="accordion-header collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $moduleKey }}-{{ $i }}">
                                            <span class="accordion-header-text"><strong>{{ __('common.controller') }} : {{ $controllerKey }}</strong></span>
                                            <span class="accordion-header-indicator"></span>
                                        </div>
                                        <div id="collapse-{{ $moduleKey }}-{{ $i }}" class="accordion-body collapse " data-bs-parent="#accordion-{{ $moduleKey }}-{{ $i }}">
                                            <div class="accordion-body-text table-responsive">
                                                <table class="table table-responsive-md">
                                                    <thead>
                                                        <tr>
                                                            <th><strong>{{ __('common.permissions') }}</strong></th>

                                                            @forelse($rolesArr as $role)
                                                                <th> {{ $role->name }} </th>
                                                            @empty
                                                            @endforelse

                                                            <th> {{ __('common.user_permission') }}</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @forelse($controller[0] as $methodKey => $method)

                                                        <tr>

                                                            <td>
                                                                {{ $method->name }} <i class="fa fa-question-circle" data-bs-toggle="tooltip" data-placement="right" title="{{ $method->name }}"></i>
                                                            </td>

                                                            @php
                                                                $permissionId = Acl::get_permission_id($method->id);
                                                                $checked = Acl::checked_user_permission($user->id, $permissionId);
                                                                $deny_class = '';
                                                                $checked_permission = '';
                                                                if($checked == 1) {
                                                                    $checked_permission = 'checked="checked"';
                                                                } else if($checked == 2) {
                                                                    $deny_class = 'deny-permission';
                                                                } 
                                                            @endphp

                                                            @forelse($rolesArr as $role)

                                                                @php
                                                                    $rolechecked = Acl::checked_role_permission($role->id, $permissionId);
                                                                @endphp

                                                                <td>
                                                                    <label class="permission-switch">
                                                                        <input type="checkbox" {{ $rolechecked }} disabled="true">
                                                                        <span class="permission-switch-slider"></span>
                                                                    </label>
                                                                </td>
                                                            @empty
                                                            @endforelse

                                                            <td class="d-flex align-items-center">

                                                                <label class="permission-switch">
                                                                    <input type="checkbox" class="UserCheckbox permissionCheckbox_{{ $user->id }}" id="userCheckbox_{{ $user->id }}_{{ $permissionId }}" data-user-id="{{ $user->id }}" data-permission-id="{{ $permissionId }}" rdx-link="{{ route('admin.permissions.manage-user-permission', ['user_id'=>$user->id, 'permission_id' => $permissionId] )}}" {{ $checked_permission }}>
                                                                    <span class="permission-switch-slider {{ $deny_class }}"></span>
                                                                </label>

                                                                @if($checked == 1 || $checked == 2)
                                                                    <span class="deleteUserPermission btn btn-danger btn-xs ms-3" data-user-id="{{ $user->id }}" data-permission-id="{{ $permissionId }}" rdx-link="{{ route('admin.permissions.delete-user-permission', ['user_id'=>$user->id, 'permission_id' => $permissionId] )}}">
                                                                        <i class="fa fa-trash"></i>
                                                                    </span>
                                                                @endif

                                                                
                                                            </td>

                                                        </tr>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                        @empty
                                                            <tr>
                                                                <td>
                                                                    <p class="text-center">{{ __('common.records_not_found') }}</p>
                                                                </td>
                                                            </tr>
                                                        @endforelse

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @empty

                                <h5 class="text-center">{{ __('common.records_not_found') }}</h5>

                            @endforelse
                        </div>

                    </div>
                </div>
            @endforeach

            
        </div>

    @endif

</div>

@endsection