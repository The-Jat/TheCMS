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
                <li class="breadcrumb-item"><a href="javascript:void(0)">{{ __('common.tools') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.import') }}</a></li>
            </ol>
        </div>
    </div>

	<div class="card">
		<div class="card-header d-block">
			<h4 class="card-title">{{ __('common.import') }}</h4>
		</div>
		<form action="{{ route('tools.admin.import') }}" id="export-filters" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="row mb-4">
					<div class="col-md-6">
						<p>{{ __('common.place_xml_file_here') }} :</p>
						<div class="input-group">
			                <div >
			                    <input type="file" name="xml_file" class="-input form-control ps-2" accept=".xml">
			                </div>
			            </div>
			            @error('xml_file')
							<p class="text-danger">
								{{ $message }}
							</p>
						@enderror
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<p>{{ __('common.reassign_author_text') }} :</p>
	                    <select name="user_id" class="form-control default-select">
							<option value="{{ Auth::user()->id }}">{{ __('common.current_logged_in_user') }}</option>
							@forelse($users as $user)
								<option value="{{ $user->id }}">{{ $user->first_name.' '.$user->last_name }}({{ $user->email }})</option>
							@empty
							@endforelse
						</select>
			            @error('user_id')
							<p class="text-danger">
								{{ $message }}
							</p>
						@enderror
					</div>
				</div>
			</div>	
			<div class="card-footer">
				<button type="submit" class="btn btn-primary">{{ __('common.import_to_databse') }}</button>
			</div>
		</form>
	</div>

</div>

@endsection