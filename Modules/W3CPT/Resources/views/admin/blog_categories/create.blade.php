{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

	<div class="row page-titles mx-0 mb-3">
		<div class="col-sm-6 p-0">
			<div class="welcome-text">
				<h4>{{ $taxonomy['cpt_tax_labels']['name'] }}</h4>
				<span>{{ $taxonomy['cpt_tax_labels']['add_new_item'] }}</span>
			</div>
		</div>
		<div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('cpt.blog_category.admin.index', ['post_type' => $post_type['cpt_name'], 'taxonomy' => $taxonomy['cpt_tax_name']]) }}">{{ $taxonomy['cpt_tax_labels']['name'] }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $taxonomy['cpt_tax_labels']['add_new_item'] }}</a></li>
			</ol>
		</div>
	</div>

	<form action="{{ route('cpt.blog_category.admin.store', ['post_type' => $post_type['cpt_name'], 'taxonomy' => $taxonomy['cpt_tax_name']]) }}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">{{ $taxonomy['cpt_tax_labels']['add_new_item'] }}</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="form-group col-md-6">
								<label for="BlogTitle">{{ __('common.title') }}</label>
								<input type="text" name="data[BlogCategory][title]" class="form-control MakeSlug" id="BlogTitle" placeholder="{{ __('common.title') }}" rel="slug" required>
								@error('data.BlogCategory.title')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
							<div class="form-group col-md-6">
								<label for="BlogSlug">{{ __('common.slug') }}</label>
								<input type="text" name="data[BlogCategory][slug]" class="form-control" id="slug" placeholder="{{ __('common.slug') }}" readonly="readonly" maxlength="255" required="required">
								@error('data.BlogCategory.slug')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
							<div class="form-group col-md-6">
								<label for="BlogCategoryParentId">{{ __('common.parent') }}</label>
								<select name="data[BlogCategory][parent_id]" class="default-select form-control" id="BlogCategoryParentId">
									<option value="">({{ __('common.no_parent') }})</option>
									@forelse($blog_categories as $blog_category)
										<option value="{{ $blog_category['id'] }}">{{ $blog_category['title'] }}</option>
									@empty
									@endforelse
								</select>
								@error('data.BlogCategory.content')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
							<div class="form-group col-md-6">
								<label for="BlogCategoryDescription">{{ __('common.description') }}</label>
								<textarea name="data[BlogCategory][description]" class="form-control h-100" id="BlogCategoryDescription" rows="5"></textarea>
								@error('data.BlogCategory.description')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
						</div>
					</div>
					<div class="card-footer">
						<button type="submit" class="btn btn-primary" title="{{ __('common.click_to_save_blog_cat') }}">{{ __('common.save') }}</button>
						<a href="{{ route('cpt.blog_category.admin.index', ['post_type' => $post_type['cpt_name'], 'taxonomy' => $taxonomy['cpt_tax_name']]) }}" class="btn btn-danger">{{ __('common.back') }}</a>
					</div>
				</div>
			</div>	
		</div>
	</form>
</div>
@endsection

