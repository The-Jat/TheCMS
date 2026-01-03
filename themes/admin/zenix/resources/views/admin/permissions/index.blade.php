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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.all_permissions') }}</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->
    <div class="row">
        @php 
            $permissions_list = config('permission.acl.action_list'); 
            $i = 1;
        @endphp

        @foreach($modulePermissions as $modulePermissionKey => $modulePermissionValue)

            <div class="col-xl-12">
                <div class="card accordion accordion-bordered" id="accordion-{{ $modulePermissionKey }}">

                    <div class="card-header d-block accordion-header  rounded-lg collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $modulePermissionKey }}">
                        <h4 class="card-title">{{ ucfirst($modulePermissionKey) }}</h4>
                        <span class="accordion-header-indicator"></span>
                    </div>

                    <div class="card-body accordion__body collapse" id="collapse-{{ $modulePermissionKey }}" data-bs-parent="#accordion-{{ $modulePermissionKey }}">
                        
                        @forelse($modulePermissionValue as $controllerKey => $controller)

                            <div id="accordion-{{ $modulePermissionKey }}-{{ $i }}" class="accordion accordion-bordered accordion-primary custom-accordion">
                                <div class="accordion-item">
                                    <div class="accordion-header collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $modulePermissionKey }}-{{ $i }}">
                                        <span class="accordion-header-text"><strong>{{ __('common.controller') }}: {{ $controllerKey }}</strong></span>
                                        <span class="accordion-header-indicator"></span>
                                    </div>
                                    <div id="collapse-{{ $modulePermissionKey }}-{{ $i }}" class="accordion__body collapse" data-bs-parent="#accordion-{{ $modulePermissionKey }}-{{ $i }}">
                                        <div class="accordion-body-text table-responsive">
                                            <table class="table table-responsive-lg">
                                                <thead>
                                                    <tr>
                                                        <th><strong>{{ __('common.permissions') }}</strong></th>
                                                        <th><strong>{{ __('common.actions') }}</strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @forelse($controller[0] as $methodKey => $method)
                                                        @php
                                                            $permissionId = Acl::get_permission_id($method->id);
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <span class="label">
                                                                    {{ $method->name }} <i class="fa fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $method->name }}"></i>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('admin.permissions.permission_by_action') }}" class="AssignRevokePermissions btn btn-xs btn-info
                                                                  me-2" data-permission-id="{{ $permissionId }}" data-type="role">{{ __('common.role_based') }}</a>

                                                                <a href="{{ route('admin.permissions.permission_by_action') }}" class="AssignRevokePermissions btn btn-xs btn-primary " data-permission-id="{{ $permissionId }}" data-type="user">{{ __('common.user_based') }}</a>
                                                            </td>
                                                        </tr>
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
                            @php
                                $i++;
                            @endphp
                        @empty

                            <h5 class="text-center">{{ __('common.records_not_found') }}</h5>

                        @endforelse
                    </div>

                </div>
            </div>

        @endforeach

        
    </div>
    <!-- Row ends -->
</div>

@endsection