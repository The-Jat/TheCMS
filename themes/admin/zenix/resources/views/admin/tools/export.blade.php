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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.export') }}</a></li>
            </ol>
        </div>
    </div>

	<div class="card">
		<div class="card-header d-block">
			<h4 class="card-title">{{ __('common.export') }}</h4>
		</div>
		<form action="{{ route('tools.admin.export') }}" id="export-filters" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">
						<div class="col-12">
							<p class="m-0">{{ __('common.export_data_description_1') }}</p>
							<p class="m-0">{{ __('common.export_data_description_2') }}</p>
							<p class="m-">{{ __('common.export_data_description_3') }}</p>
							<h6>{{ __('common.choose_what_to_export') }}</h6>
						</div>
						<div class="form-group col-sm-12">
							<div class="form-check col-sm-6">
								<label class="form-check-label" for="all_content">{{ __('common.all_content') }}</label>
								<input class="form-check-input" type="radio" id="all_content" name="content" value="all_content" checked>
							</div>
							<hr>
							<div class="form-check col-sm-6">
								<label class="form-check-label" for="posts">{{ __('common.posts') }}</label>
								<input class="form-check-input" type="radio" id="posts" name="content" value="posts">
							</div>
							<div id="post-filters" class="row export-filters mb-3">
								<hr>
								<div class="col-md-4">
									<label for="category_id">{{ __('common.categories') }}:</label>
									<select name='category_id' id="category_id" class="form-control default-select">
										<option value='0' >{{ __('common.all') }}</option>
										@forelse($categories as $category)
											<option value="{{ $category->id }}">{{ $category->title }}</option>
										@empty
										@endforelse
									</select>
								</div>
								<div class="col-md-4">
									<label for="post_user_id">{{ __('common.author') }}:</label>
									<select name="post_user_id" class="form-control default-select">
										<option value="0">{{ __('common.all') }}</option>
										@forelse($blogUsers as $user)
											<option value="{{ $user->id }}">{{ $user->first_name.' '.$user->last_name }}({{ $user->email }})</option>
										@empty
										@endforelse
									</select>
								</div>
								<div class="col-md-4">
									<label for="post_status">{{ __('common.status') }}</label>
									<select name="post_status" id="post_status" class="form-control default-select">
										<option value="0">{{ __('common.all') }}</option>
										@forelse($blogStatus as $key => $value)
											<option value="{{ $key }}">{{ $value }}</option>
										@empty
										@endforelse
									</select>
								</div>
								<div class="col-md-4">
									<label for="post_start_date">{{ __('common.start_date') }}:</label>
									<input type="date" name="post_start_date" class="form-control" id="post_start_date">
								</div>
								<div class="col-md-4">
									<label for="post_end_date">{{ __('common.end_date') }}:</label>
									<input type="date" name="post_end_date" class="form-control" id="post_end_date">
								</div>
							</div>
							<div class="form-check col-sm-6">
								<label class="form-check-label" for="pages">{{ __('common.pages') }}</label>
								<input class="form-check-input" type="radio" id="pages" name="content" value="pages">
							</div>
							<div id="page-filters" class="row export-filters mb-3">
								<hr>
								<div class="col-md-3">
									<label for="page_user_id">{{ __('common.author') }}:</label>
									<select name="page_user_id" class="form-control default-select">
										<option value="0">{{ __('common.all') }}</option>
										@forelse($pageUsers as $user)
											<option value="{{ $user->id }}">{{ $user->first_name.' '.$user->last_name }}({{ $user->email }})</option>
										@empty
										@endforelse
									</select>
								</div>
								<div class="col-md-3">
									<label for="page_status">{{ __('common.status') }}:</label>
									<select name="page_status" id="page_status" class="form-control default-select">
										<option value="0">{{ __('common.all') }}</option>
										@forelse($pageStatus as $key => $value)
											<option value="{{ $key }}">{{ $value }}</option>
										@empty
										@endforelse
									</select>
								</div>
								<div class="col-md-3">
									<label for="page_start_date">{{ __('common.start_date') }}:</label>
									<input type="date" name="page_start_date" class="form-control" id="page_start_date">
								</div>
								<div class="col-md-3">
									<label for="page_end_date">{{ __('common.end_date') }}:</label>
									<input type="date" name="page_end_date" class="form-control" id="page_end_date">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary">{{ __('common.download_file') }}</button>
			</div>
		</form>
	</div>

</div>

@endsection