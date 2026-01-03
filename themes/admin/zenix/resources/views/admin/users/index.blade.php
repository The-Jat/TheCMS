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
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('common.users') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.all_users') }}</a></li>
            </ol>
        </div>
    </div>

    @php
        $collapsed = 'collapsed';
        $show = '';
    @endphp

    @if(!empty(request()->name) || !empty(request()->email) || !empty(request()->role))
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
                    
                    {{ html()->form('get')->route('admin.users.index')->open() }}
                        <input type="hidden" name="todo" value="Filter">
                        <div class="row">
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ html()->text('name',request()->name)->class('form-control')->placeholder(__('common.name')) }}
                            </div>
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ html()->email('email',request()->email)->class('form-control')->placeholder(__('common.email')) }}

                            </div>
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ html()->select('role',$roleArr,request()->role)->class('default-select form-control') }}

                            </div>
                            <div class=" col-sm-6 col-md-3 col-lg-4 col-xl-3 text-sm-end">
                                <input type="submit" name="search" value="{{ __('common.search') }}" class="btn btn-primary me-2"> <a href="{{ route('admin.users.index') }}" class="btn btn-danger">{{ __('common.reset') }}</a>
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
                    <h4 class="card-title">{{ __('common.users') }}</h4>
                    @can('Controllers > UsersController > create')
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">{{ __('common.add_user') }}</a>
                    @endcan
                </div>
                <div class="pe-4 ps-4 pt-2 pb-2">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg mb-0">
                            <thead>
                                <tr>
                                    <th> <strong> {{ __('common.s_no') }} </strong> </th>
                                    <th> <strong> {{ __('common.profile') }} </strong> </th>
                                    <th> <strong> {!! DzHelper::dzSortable('name', __('common.name')) !!} </strong> </th>
                                    <th> <strong> {!! DzHelper::dzSortable('email', __('common.email')) !!} </strong> </th>
                                    <th> <strong> {{ __('common.role') }} </strong> </th>
                                    <th> <strong> {!! DzHelper::dzSortable('created_at', __('common.created')) !!} </strong> </th>
                                    @canany(['Controllers > UsersController > edit', 'Controllers > UsersController > destroy'])
                                        <th class="text-center"> <strong> {{ __('common.actions') }} </strong> </th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = $users->firstItem();
                                @endphp
                                @forelse ($users as $user)
                                <tr>
                                    <td> {{ $i++ }} </td>
                                    <td>
                                        <img class="rounded" src="{{ HelpDesk::user_img($user->profile) }}" alt="{{ $user->profile }}" width="50px" height="50px">
                                    </td>
                                    <td> {{ $user->name }} </td>
                                    <td> {{ $user->email }} </td>
                                    <td>
                                        @forelse ($user->roles as $role)
                                        <span class="badge bg-primary mb-1">{{ $role->name }}</span>
                                        @empty
                                        {{ __('common.not_assign') }}
                                        @endforelse
                                    </td>
                                    <td> {{ $user->created_at }} </td>
                                    <td class="text-center ">
                                        @can('Controllers > UsersController > edit')
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                        @endcan
                                        @can('Controllers > UsersController > destroy')
                                            <a href="{{ route('admin.users.delete', $user->id) }}" data-user-name="{{ $user->name }}" class="btn btn-danger shadow btn-xs sharp DeleteUser me-1"><i class="fa fa-trash"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('common.no_users') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $users->appends(Request::input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('inline-modals')
    <div class="modal fade" id="DeleteUserModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="" method="post" id="DeleteUserForm">
                @csrf
                    <div class="modal-header">
                        <div>
                            <h5 class="modal-title">{{ __('common.delete_user') }}</h5>
                            <p class="m-0">{{ __('common.selected_user_removal_text') }} : <strong id="UserName"></strong></p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p>{{ __('common.what_action_needs_for_content_text') }}?</p>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="delete_option" value="delete" id="deleteContent">
                                    <label class="form-check-label" for="deleteContent">{{ __('common.delete_content_of_user') }}</label>
                                </div>
                                <div class="form-check ">
                                    <input class="form-check-input" type="radio" name="delete_option" value="reassign" id="reassign">
                                    <label class="form-check-label" for="reassign">{{ __('common.reassign_user') }} </label>
                                </div>
                                <div class="form-group col-lg-6 mt-2 delete-filters" id="reassign-selectbox">
                                    <p class="m-0">{{ __('common.select_reassign_user_text') }} :</p>
                                    <select name="reassign_user" class=" form-control">
                                        @forelse($usersArr as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">{{ __('common.close') }}</button>
                        <button type="submit" id="Submit" class="btn btn-primary " disabled>{{ __('common.save_changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush