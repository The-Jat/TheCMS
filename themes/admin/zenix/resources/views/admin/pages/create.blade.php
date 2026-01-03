{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="card accordion accordion-rounded-stylish accordion-bordered" id="accordion-slug">
	    <div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-slug" aria-expanded="true">
	        <h4 class="card-title">{{ __('common.screen_options') }}</h4>
	        <span class="accordion-header-indicator"></span>
	    </div>
	    <div class="accordion__body p-4 collapse show" id="with-slug" data-bs-parent="#accordion-slug">
	        <div class="row">
	        	@forelse($screenOption as $key => $value)
					<div class="col-md-3 form-group">
						<label class="checkbox-inline">
							<input type="checkbox" id="Allow{{ $key }}" class="me-1 m-0 form-check-input allowField Allow{{ $key }}" rel="{{ $key }}" {{ $value['visibility'] ? 'checked="checked"' : '' }}>
							{{ $key }}
						</label>
					</div>
				@empty
				@endforelse
            </div>
	    </div>
	</div>

	<div class="row page-titles mx-0 ">
        <div class="col-sm-6 p-0">
            <div class="welcome-text">
				<h4>{{ __('common.welcome_back_title') }}</h4>
				<p class="mb-0">{{ __('common.welcome_back_desc') }}</p>
		    </div>
        </div>
        <div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('page.admin.index') }}">{{ __('common.pages') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.add_page') }}</a></li>
            </ol>
        </div>
    </div>

	<form action="{{ route('page.admin.store') }}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header d-flex justify-content-between">
								<h4 class="card-title">{{ __('common.add_page') }}</h4>
								<button type="button" class="shadow-none light btn-dark btn btn-primary btn-sm" id="UseMagicEditor" use_editor="true"><i class="fa fa-list"></i> {{ __('Use System Editor') }}</button>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="form-group col-md-12">
										<label for="ContentTitle">{{ __('common.title') }}</label>
										<input type="text" name="data[Page][title]" class="form-control MakeSlug" id="ContentTitle" placeholder="{{ __('common.title') }}" value="{{ old('data.Page.title') }}" rel="slug">
										@error('data.Page.title')
						                    <p class="text-danger">
						                        {{ $message }}
						                    </p>
						                @enderror
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group col-md-12 ">
							<div class="in-box ClassicEditorBox d-none">
								<textarea name="data[Page][content]" class="form-control W3cmsCkeditor h-auto" id="PageContent" rows="10">{!! old('data.Page.content') !!}</textarea>
							</div>

							<div class="in-box MagicEditorBox ">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">{{ __('common.magic_editor') }}</h4>
											 
										<a href="{{ route('admin.use.me') }}" data-bs-toggle="modal" data-bs-target="#AddElement" class=" btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
									</div>
									<div class="card-body table-responsive">
										<div class="form-group" id="MagicEditorElementContainer">
											<a href="{{ route('admin.use.me') }}" data-bs-toggle="modal" data-bs-target="#AddElement" class="btn btn-primary btn-sm me-add-element-btn"> {{ __('common.add_element') }}</a>					
										</div>
									</div>
								</div>
							</div>

							@error('data.Page.content')
			                    <p class="text-danger">
			                        {{ $message }}
			                    </p>
			                @enderror

						</div>
					</div>

					<div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered XExcerpt {{ $screenOption['Excerpt']['visibility'] ? '' : 'd-none' }}" id="accordion-excerpt">
		                    <div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-excerpt" aria-expanded="true">
		                        <h4 class="card-title">{{ __('common.excerpt') }}</h4>
		                        <span class="accordion-header-indicator"></span>
		                    </div>
		                    <div class="accordion__body p-4 collapse show" id="with-excerpt" data-bs-parent="#accordion-excerpt">
		                        <div class="form-group">
			                        <label for="ContentExcerpt">{{ __('common.excerpt') }}</label>
			                        <textarea name="data[Page][excerpt]" class="form-control" id="ContentExcerpt" rows="5">{{ old('data.Page.excerpt') }}</textarea>
			                        <small>{{ __('common.add_excerpt_text') }}</small>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered XCustomFields {{ $screenOption['CustomFields']['visibility'] ? '' : 'd-none' }}" id="accordion-custom-fields">
		                    <div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-custom-fields" aria-expanded="true">
		                        <h4 class="card-title">{{ __('common.custom_fields') }}</h4>
		                        <span class="accordion-header-indicator"></span>
		                    </div>
		                    <div class="accordion__body p-4 collapse show" id="with-custom-fields" data-bs-parent="#accordion-custom-fields">
		                    	<div id="AppendContainer">
		                    		@php
		                    			$count = 0;
		                    			$custom_fields = old('data.PageMeta');
		                    		@endphp
		                    		@if(!empty($custom_fields))
				                    	<div id="customFieldContainer">
			                    			@foreach($custom_fields as $custom_field)
			                    				@if($custom_field['title'] == 'ximage' || $custom_field['title'] == 'w3_page_options')
			                    					@continue
			                    				@endif
					                    		@php
					                    			$count++;
					                    		@endphp
				                    			<div class="row xrow">
				                    				<div class="col-md-6 form-group">
				                    					<label for="PageMetaName_{{ $count }}">{{ __('common.title') }}</label> 
				                    					<input type="text" name="data[PageMeta][{{ $count }}][title]" class="form-control" id="PageMetaName_{{ $count }}" value="{{ $custom_field['title'] }}"> 
				                    				</div> 
				                    				<div class="col-md-6 form-group"> 
				                    					<label for="PageMetaValue_{{ $count }}">{{ __('common.value') }}</label> 
				                    					<textarea name="data[PageMeta][{{ $count }}][value]" id="PageMetaValue_{{ $count }}" class="form-control" rows="5">{{ $custom_field['value'] }}</textarea> 
				                    				</div> 
				                    				<div class="col-md-12 form-group"> 
				                    					<button class="btn btn-danger CustomFieldRemoveButton" type="button">{{ __('common.delete') }}</button>
				                    				</div>
				                    			</div>
			                    			@endforeach
				                    	</div>
		                    		@endif
		                    		<input type="hidden" id="last_cf_num" value="{{ $count }}">
		                    	</div>
		                        <div class="row">
		                        	<div class="col-md-6 form-group">
		                        		<label for="PageMetaName">{{ __('common.title') }}</label>
		                        		<input type="text" class="form-control" id="PageMetaName" placeholder="{{ __('common.title') }}">
		                        	</div>
		                        	<div class="col-md-6 form-group">
		                        		<label for="PageMetaValue">{{ __('common.value') }}</label>
		                        		<textarea class="form-control" id="PageMetaValue" rows="5"></textarea>
		                        	</div>
		                        </div>
			                    <button type="button" class="btn btn-sm btn-primary" id="AddCustomField">{{ __('common.add_custom_field') }}</button>
			                    <small class="d-block mt-2">{{ __('common.custom_field_description') }}</small>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered XDiscussion {{ $screenOption['Discussion']['visibility'] ? '' : 'd-none' }}" id="accordion-discussion">
		                    <div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-discussion" aria-expanded="true">
		                        <h4 class="card-title">{{ __('common.discussion') }}</h4>
		                        <span class="accordion-header-indicator"></span>
		                    </div>
		                    <div class="accordion__body p-4 collapse show" id="with-discussion" data-bs-parent="#accordion-discussion">
		                        <div class="form-check mb-2">
		                        	<input type="hidden" name="data[Page][comment]" id="ContentComment_" value="0">
		                            <input type="checkbox" name="data[Page][comment]" class="form-check-input" id="ContentComment" value="1" {{ old('data.Page.comment') == 1 ? 'checked="checked"' : '' }}>
		                            <label class="form-check-label" for="ContentComment">{{ __('common.allow_comments') }}</label>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered XSlug {{ $screenOption['Slug']['visibility'] ? '' : 'd-none' }}" id="accordion-slug">
		                    <div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-slug" aria-expanded="true">
		                        <h4 class="card-title">{{ __('common.slug') }}</h4>
		                        <span class="accordion-header-indicator"></span>
		                    </div>
		                    <div class="accordion__body p-4 collapse show" id="with-slug" data-bs-parent="#accordion-slug">
		                        <div class="form-group">
			                        <label for="slug">{{ __('common.slug') }}</label>
			                        <input type="text" name="data[Page][slug]" class="form-control" id="slug" value="{{ old('data.Page.slug') }}" readonly>
			                        @error('data.Page.slug')
										<p class="text-danger">
											{{ $message }}
										</p>
									@enderror
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered XAuthor {{ $screenOption['Author']['visibility'] ? '' : 'd-none' }}" id="accordion-author">
		                    <div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-author" aria-expanded="true">
		                        <h4 class="card-title">{{ __('common.author') }}</h4>
		                        <span class="accordion-header-indicator"></span>
		                    </div>
		                    <div class="accordion__body p-4 collapse show" id="with-author" data-bs-parent="#accordion-author">
		                        <div class="form-group">
			                        <label for="ContentUserId">{{ __('common.user') }}</label>
			                        <select name="data[Page][user_id]" class="form-control default-select" id="ContentUserId">
			                        	@forelse($users as $user)
				                        	<option value="{{ $user->id }}" {{ old('data.Page.user_id') == $user->id ? 'selected="selected"' : '' }}>{{ $user->full_name }}</option>
			                        	@empty
			                        	@endforelse
			                        </select>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered XSeo {{ $screenOption['Seo']['visibility'] ? '' : 'd-none' }}" id="accordion-seo">
		                    <div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-seo" aria-expanded="true">
		                        <h4 class="card-title">{{ __('common.seo') }}</h4>
		                        <span class="accordion-header-indicator"></span>
		                    </div>
		                    <div class="accordion__body p-4 collapse show" id="with-seo" data-bs-parent="#accordion-seo">
		                    	<div class="row">
		                        	<div class="col-md-12 form-group">
		                        		<label for="ContentSeoPageTitle">{{ __('common.page_title') }}</label>
		                        		<input type="text" name="data[PageSeo][page_title]" class="form-control" id="ContentSeoPageTitle" placeholder="{{ __('common.page_title') }}" maxlength="255" value="{{ old('data.PageSeo.page_title') }}">
		                        	</div>
		                        	<div class="col-md-6 form-group">
		                        		<label for="ContentSeoMetaKeywords">{{ __('common.keywords') }}</label>
		                        		<input type="text" name="data[PageSeo][meta_keywords]" class="form-control" id="ContentSeoMetaKeywords" placeholder="{{ __('common.enter_meta_keywords') }}" maxlength="255" value="{{ old('data.PageSeo.meta_keywords') }}">
		                        	</div>
		                        	<div class="col-md-6 form-group">
		                        		<label for="ContentSeoMetaDescriptions">{{ __('common.descriptions') }}</label>
		                        		<textarea name="data[PageSeo][meta_descriptions]" class="form-control" id="ContentSeoMetaDescriptions" rows="5" placeholder="{{ __('common.enter_meta_descriptions') }}">{{ old('data.PageSeo.meta_descriptions') }}</textarea>
		                        	</div>
		                        </div>
		                    </div>
		                </div>
					</div>

				</div>
			</div>	
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered" id="accordion-publish">
		                    <div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-publish" aria-expanded="true">
		                        <h4 class="card-title">{{ __('common.publish') }}</h4>
		                        <span class="accordion-header-indicator"></span>
		                    </div>
		                    <div class="accordion__body p-4 collapse show" id="with-publish" data-bs-parent="#accordion-publish">
		                    	<div class="row">
		                    		<div class="col-md-12 form-group">
		                    			<label for="Status"><i class="fa fa-key"></i> {{ __('common.status') }}:</label>
		                    			<select name="data[Page][status]" id="Status" class="default-select form-control">
		                    				<option value="1" {{ old('data.Page.status') == 1 ? 'selected="selected"' : '' }}>{{ __('common.published') }}</option>
		                    				<option value="2" {{ old('data.Page.status') == 2 ? 'selected="selected"' : '' }}>{{ __('common.draft') }}</option>
		                    				<option value="4" {{ old('data.Page.status') == 4 ? 'selected="selected"' : '' }}>{{ __('common.private') }}</option>
		                    				<option value="5" {{ old('data.Page.status') == 5 ? 'selected="selected"' : '' }}>{{ __('common.pending') }}</option>
		                    			</select>
		                    		</div>
		                    		<div class="col-md-12 form-group">
		                    			<label for="ContentVisibility"><i class="fa fa-eye"></i> {{ __('common.visibility') }}:</label>
		                    			<select name="data[Page][visibility]" id="ContentVisibility" class="default-select form-control">
		                    				<option value="Pu" {{ old('data.Page.visibility') == 'Pu' ? 'selected="selected"' : '' }}>{{ __('common.public') }}</option>
		                    				<option value="PP" {{ old('data.Page.visibility') == 'PP' ? 'selected="selected"' : '' }}>{{ __('common.password_protected') }}</option>
		                    				<option value="Pr" {{ old('data.Page.visibility') == 'Pr' ? 'selected="selected"' : '' }}>{{ __('common.private') }}</option>
		                    			</select>
		                    		</div>
		                    		<div class="col-md-12 form-group {{ old('data.Page.visibility') == 'PP' ? '' : 'd-none' }}" id="PublicPasswordTextbox" >
		                    			<label for="ContentPassword">{{ __('common.password') }}</label>
		                    			<input type="password" name="data[Page][password]" class="form-control" id="ContentPassword" placeholder="{{ __('common.enter_password') }}" value="{{ old('data.Page.password') }}">
		                    		</div>
		                    		<div class="col-md-12 form-group" id="PublicPasswordTextbox">
		                    			<label for="PublishDateTimeTextbox"><i class="fa fa-calendar"></i> {{ __('common.published_on') }}:</label>
		                    			<input type="text" name="data[Page][publish_on]" class="datetimepicker form-control" id="PublishDateTimeTextbox"  value="{{ old('data.Page.publish_on', date('Y-m-d')) }}">
		                    		</div>
		                    		<div class="col-md-12">
		                    			<button type="submit" class="btn btn-primary">{{ __('common.publish') }}</button>
		                    		</div>
		                    	</div>
		                    </div>
		                </div>
		            </div>

		            {!! CptHelper::cpt_categories_box('page', $screenOption, old('data.BlogCategory')) !!}

		            <div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered XPageAttributes {{ $screenOption['PageAttributes']['visibility'] ? '' : 'd-none' }}" id="accordion-page-attributes">
		                    <div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-page-attributes" aria-expanded="true">
		                        <h4 class="card-title">{{ __('common.page_attributes') }}</h4>
		                        <span class="accordion-header-indicator"></span>
		                    </div>
		                    <div class="accordion__body p-4 collapse show" id="with-page-attributes" data-bs-parent="#accordion-page-attributes">
		                    	<div class="form-group">
			                        <label for="ContentParentId">{{ __('common.parent') }}</label>
			                        <select name="data[Page][parent_id]" class="default-select form-control" id="ContentParentId">
			                        	<option value="">({{ __('common.no_parent') }})</option>
			                        	@forelse($pages as $page)
			                        		<option value="{{ $page->id }}" {{ old('data.Page.parent_id') == $page->id ? 'selected="selected"' : '' }}>{{ $page->title }}</option>
			                        	@empty
			                        	@endforelse
			                        </select>
		                    	</div>
		                    </div>
		                </div>
					</div>
		            <div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered XPageType {{ $screenOption['PageType']['visibility'] ? '' : 'd-none' }}" id="accordion-page-type">
		                    <div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-page-type" aria-expanded="true">
		                        <h4 class="card-title">{{ __('common.page_type') }}</h4>
		                        <span class="accordion-header-indicator"></span>
		                    </div>
		                    <div class="accordion__body p-4 collapse show" id="with-page-type" data-bs-parent="#accordion-page-type">
		                    	<div class="form-group">
			                        <label for="ContentContentType">{{ __('common.content_type') }}</label>
			                        <select name="data[Page][content_type]" class="default-select form-control" id="ContentContentType">
			                        	<option value="Page" {{ old('data.Page.content_type') == 'Page' ? 'selected="selected"' : '' }}>{{ __('common.page') }}</option>
			                        	<option value="Widget" {{ old('data.Page.content_type') == 'Widget' ? 'selected="selected"' : '' }}>{{ __('common.widget') }}</option>
			                        </select>
		                    	</div>
		                    </div>
		                </div>
					</div>
		            <div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered XFeaturedImage {{ $screenOption['FeaturedImage']['visibility'] ? '' : 'd-none' }}" id="accordion-author">
		                    <div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-author" aria-expanded="true">
		                        <h4 class="card-title">{{ __('common.featured_image') }}</h4>
		                        <span class="accordion-header-indicator"></span>
		                    </div>
		                    <div class="accordion__body p-4 collapse show" id="with-author" data-bs-parent="#accordion-author">
		                        <div class="featured-img-preview img-parent-box"> 

									<img src="{{ asset('images/noimage.jpg') }}" class="avatar mb-1 img-for-onchange" alt="{{ __('common.image') }}" width="100px" height="100px" title="{{ __('common.image') }}"> 

									<input type="hidden" name="data[PageMeta][0][title]" value="ximage" id="ContentMeta0Title">
									<div >
										<input type="file" name="data[PageMeta][0][value]" class="ps-2 form-control img-input-onchange" accept=".png, .jpg, .jpeg"  id="PageMeta0Value" >
									</div>
                               </div>
                                @error('data.PageMeta.0.value')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
		                    </div>
		                </div>
					</div>
				</div>
			</div>
		</div>
		{!! CustomFieldHelper::custom_fields('pages') !!}
		{!! ThemeOption::AttachPageOptions() !!}
	</form>
</div>

@endsection

@push('inline-modals')
	<div class="modal fade" id="AddElement">
	    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
	        <div class="modal-content">
				<span>&nbsp;&nbsp;Loading... </span>
	        </div>	
	    </div>	
	</div>
@endpush

@push('inline-scripts')
<script>
	'use strict';
	var screenOptionArray = '<?php echo json_encode($screenOption) ?>';
</script>
@endpush


