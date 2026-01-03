{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

	<div class="row page-titles mx-0 mb-3">
		<div class="col-sm-6 p-0">
			<div class="welcome-text">
				<h4>{{ __('common.blog_tag') }}</h4>
				<span>{{ __('common.add_blog_tag') }}</span>
			</div>
		</div>
		<div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('blog_tag.admin.index') }}">{{ __('common.blog_tag') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.add_blog_tag') }}</a></li>
			</ol>
		</div>
	</div>

	<form action="{{ route('blog_tag.admin.store') }}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">{{ __('common.add_blog_tag') }}</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="form-group col-md-6">
								<label for="BlogTitle">{{ __('common.title') }}</label>
								<input type="text" name="data[BlogTag][title]" class="form-control" id="BlogTitle" placeholder="{{ __('common.title') }}">
								@error('data.BlogTag.title')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
							<div class="form-group col-md-6">
								<label for="BlogSlug">{{ __('common.slug') }}</label>
								<input type="text" name="data[BlogTag][slug]" class="slug form-control" id="BlogSlug" placeholder="{{ __('common.slug') }}" readonly="readonly" maxlength="255" required="required">
								@error('data.BlogTag.slug')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
						</div>
					</div>
					<div class="card-footer">
						<button type="submit" class="btn btn-primary" title="{{ __('common.click_to_save_blog_tag') }}">{{ __('common.save') }}</button>
						<a href="{{ route('blog_tag.admin.index') }}" class="btn btn-danger">{{ __('common.back') }}</a>
					</div>
				</div>
			</div>	
		</div>
	</form>
</div>
@endsection

