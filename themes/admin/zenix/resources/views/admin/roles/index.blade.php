{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

    <div class="row page-titles mx-0 mb-3">
        <div class="col-sm-6 p-0">
            <div class="welcome-text">
				<h4>{{ __('common.welcome_back_title') }}</h4>
				<p class="mb-0">{{ __('common.welcome_back_desc') }}</p>
		    </div>
        </div>
        <div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">{{ __('common.roles') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.all_roles') }}</a></li>
            </ol>
        </div>
    </div>

    @php
        $collapsed = 'collapsed';
        $show = '';
    @endphp

    @if(!empty(request()->name))
        @php
            $collapsed = '';
            $show = 'show';
        @endphp
    @endif

    <div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card accordion accordion-rounded-stylish accordion-bordered" id="search-sec-outer">
                <div class="accordion-header rounded-lg {{ $collapsed }}" data-bs-toggle="collapse" data-bs-target="#rounded-search-sec">
                    <span class="accordion-header-icon"></span>
                    <h4 class="accordion-header-text m-0">{{ __('common.filter') }}</h4>
                    <span class="accordion-header-indicator"></span>
                </div>
                <div class="card-body collapse accordion__body {{ $show }}" id="rounded-search-sec" data-bs-parent="#search-sec-outer">
                    {{ html()->form('get')->route('admin.roles.index')->open() }}
                        <input type="hidden" name="todo" value="Filter">
                        <div class="row">
                            <div class="form-group col-md-4">
                                {{ html()->text('name',request()->name)->class('form-control')->placeholder(__('common.role_name')) }}
                            </div>
                            <div class="col-md-8 text-end">
                                <input type="submit" name="search" value="{{ __('common.search') }}" class="btn btn-primary me-2"> <a href="{{ route('admin.roles.index') }}" class="btn btn-danger">{{ __('common.reset') }}</a>
                            </div>
                        </div>
                    {{ html()->form()->close() }}
                </div>
            </div>
        </div>
    </div>

    <!-- row -->

    <div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('common.roles') }}</h4>
                    @can('Controllers > RolesController > create')
                        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">{{ __('common.add_role') }}</a>
                    @endcan
                </div>
                <div class="pe-4 ps-4 pt-2 pb-2">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg mb-0">
                            <thead>
                                <tr>
                                    <th><strong>{{ __('common.s_no') }}</strong></th>
                                    <th><strong>{!! DzHelper::dzSortable('name', __('common.role_name')) !!}</strong></th>
                                    <th><strong>{{ __('common.permissions_count') }}</strong></th>
                                    @canany(['Controllers > RolesController > edit', 'Controllers > RolesController > destroy'])
                                        <th><strong>{{ __('common.actions') }}</strong></th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = $roles->firstItem();
                                @endphp
                                @forelse($roles as $role)

                                    @php
                                        $rolePermissionCount = Acl::get_role_permissions_count($role->id);
                                    @endphp

                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td> {{ $role->name }} </td>
                                        <td> <span class="badge bg-primary">{{ $rolePermissionCount }}</span> </td>
                                        <td>
                                            @can('Controllers > RolesController > edit')
                                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                            @endcan
                                            @can('Controllers > RolesController > destroy')
                                                <a href="{{ route('admin.roles.delete', $role->id) }}" class="btn btn-danger shadow btn-xs sharp me-1"><i class="fa fa-trash"></i></a>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">
                                            <p class="text-center">{{ __('common.records_not_found') }}</p>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>

</div>

@endsection