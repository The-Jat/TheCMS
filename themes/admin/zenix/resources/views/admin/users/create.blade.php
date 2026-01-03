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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.add_user') }}</a></li>
            </ol>
        </div>
    </div>

	<div class="card">
		<div class="card-header">
			<h4 class="card-title">{{ __('common.add_user') }}</h4>
		</div>
		<form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">
						<div class="col-sm-6 text-center">
							<div class="custom-img-upload img-parent-box">
								<img src="{{ asset('images/noimage.jpg') }}" class="avatar mb-1 img-for-onchange" id="UserImg" alt="{{ __('common.image') }}" width="100px" height="100px" title="{{ __('common.image') }}">
								<div class="upload-btn">
	                            	<input type="file" class="form-control ps-2 img-input-onchange" name="user_img" id="user_img" accept=".png, .jpg, .jpeg" hidden>
	                            	<label class="upload-label btn btn-xs btn-primary m-0" for="user_img">{{ __('common.upload') }}</label>
	                            </div>
							</div>
                            @error('user_img')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
						</div>
						<div class="col-sm-6">
							<div class="row">
								<div class="form-group col-md-6">
									<label>{{ __('common.first_name') }}</label>
									<input type="text" name="first_name" id="first_name" class="form-control" autocomplete="first_name" value="{{ old('first_name') }}">
									@error('first_name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-6">
									<label>{{ __('common.last_name') }}</label>
									<input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}">
									@error('last_name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-12">
									<label>{{ __('common.email') }}</label>
									<input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
									@error('email')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-12">
									<label>{{ __('common.role') }}</label>
									<select name="roles[]" id="roles" class="default-select form-control" multiple="multiple">
										@forelse($roles as $role)
											<option value="{{ $role->id }}" @selected(!empty(old('roles')) && in_array($role->id, old('roles'))) >{{ $role->name }}</option>
										@empty
										@endforelse
									</select>
									@error('roles')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label for="dz-password">{{ __('common.password') }}</label>
							<div class="input-group">
								<input type="password" name="password" id="dz-password" class="form-control" autocomplete="new-password" value="{{ old('password') }}">
								<span class="input-group-text show-pass"> 
                                    <i class="fa fa-eye-slash"></i>
                                    <i class="fa fa-eye"></i>
                                </span>
							</div>
							@error('password')
	                            <p class="text-danger">
	                                {{ $message }}
	                            </p>
	                        @enderror
						</div>
						<div class="form-group col-sm-6">
							<label for="dz-con-password">{{ __('common.confirm_password') }}</label>
							<div class="input-group">
								<input type="password" name="password_confirmation" id="dz-con-password" class="form-control" autocomplete="new-password" value="{{ old('password_confirmation') }}">
								<span class="input-group-text show-con-pass"> 
                                    <i class="fa fa-eye-slash"></i>
                                    <i class="fa fa-eye"></i>
                                </span>
							</div>
							@error('password_confirmation')
	                            <p class="text-danger">
	                                {{ $message }}
	                            </p>
	                        @enderror
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>
				<a href="{{ route('admin.users.index') }}" class="btn btn-danger">{{ __('common.back') }}</a>
			</div>
		</form>
	</div>
	
	{!! CustomFieldHelper::custom_fields('users') !!}

</div>

@endsection