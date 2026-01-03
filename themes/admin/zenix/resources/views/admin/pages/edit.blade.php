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
					<div class="col-md-2 form-group">
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

	<div class="row page-titles mx-0">
        <div class="col-sm-6 p-0">
            <div class="welcome-text">
				<h4>{{ __('common.welcome_back_title') }}</h4>
				<p class="mb-0">{{ __('common.welcome_back_desc') }}</p>
		    </div>
        </div>
        <div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('page.admin.index') }}">{{ __('common.pages') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.edit_page') }}</a></li>
            </ol>
        </div>
    </div>

	<form action="{{ route('page.admin.update', $page->id) }}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">{{ __('common.edit_page') }}</h4>
								<button type="button" class="shadow-none btn btn-sm btn-dark" id="UseMagicEditor" use_editor="{{ (Str::contains($page->content , ['%ME%', '%ME-EL%'])) ? 'true' : 'false' }}"><i class="fa fa-list"></i> {{ __('Use System Editor') }}</button>
							</div>
							<div class="card-body p-4">
								<div class="row">
									<div class="form-group col-md-12">
										<label for="ContentTitle">{{ __('common.title') }}</label>
										<input type="text" name="data[Page][title]" class="form-control MakeSlug" id="ContentTitle" placeholder="{{ __('common.title') }}" value="{{ old('data.Page.title', $page->title) }}" rel="slug">
										@error('data.Page.title')
						                    <p class="text-danger">
						                        {{ $message }}
						                    </p>
						                @enderror
									</div>
									<div class="form-group col-md-12">
										<strong>{{ __('common.permalink') }}:</strong>
										<a href="{!! DzHelper::laraPageLink($page->id) !!}">
											{{ url('/') }}/<span class='font-green permalinkSlugSpan'>{{ $page->slug }}</span>
										</a>
										<div class="editPermalinkContainer">
											<input type="text" name="data[Page][editslug]" id="PageEditSlug" class="form-control" value="{{ $page->slug }}">
											<button type="button" class="btn btn-link btn-sm  editPermalinkOkButton">{{ __('common.ok') }}</button>
											<a href="javascript:void(0);" class="editPermalinkCancelButton">{{ __('common.cancel') }}</a>
										</div>
										<button type="button" class="btn btn-link btn-sm editPermalink" title="{{ __('common.click_to_edit_url') }}">{{ __('common.edit') }} </button>
									</div>
									@error('data.Page.editslug')
										<p class="text-danger">
											{{ $message }}
										</p>
									@enderror
								</div>
							</div>
						</div>
					</div><div class="col-md-12">
						<div class="form-group col-md-12 ">
							<div class="in-box ClassicEditorBox {{ (Str::contains($page->content , ['%ME%', '%ME-EL%'])) ? 'd-none' : '' }}">
								<textarea name="data[Page][content]" class="form-control W3cmsCkeditor h-auto" id="PageContent" rows="10">{!! old('data.Page.content', $page->content) !!}</textarea>
							</div>

							<div class="in-box MagicEditorBox {{ (Str::contains($page->content , ['%ME%', '%ME-EL%'])) ? '' : 'd-none' }}">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">{{ __('common.magic_editor') }}</h4>
											 
										<a href="{{ route('admin.use.me') }}" data-bs-toggle="modal" data-bs-target="#AddElement" class=" btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
									</div>
									<div class="card-body table-responsive">
										<div class="form-group" id="MagicEditorElementContainer">
											@if(!empty($page->content) && HelpDesk::shortcodeToHtml($page->content))
												{!! HelpDesk::shortcodeToHtml($page->content) !!}
											@else
												<a href="{{ route('admin.use.me') }}" data-bs-toggle="modal" data-bs-target="#AddElement" class="btn btn-primary btn-sm me-add-element-btn"> {{ __('common.add_element') }}</a>
											@endif
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
			                        <textarea name="data[Page][excerpt]" class="form-control" id="ContentExcerpt" rows="5">{!! old('data.Page.excerpt', $page->excerpt) !!}</textarea>
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
		                    			$custom_fields = old('data.PageMeta') ? old('data.PageMeta') : $page->page_metas;
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
				                    					<label for="PageMetaValue_{{ $count }}">Value</label> 
				                    					<textarea name="data[PageMeta][{{ $count }}][value]" id="PageMetaValue_{{ $count }}" class="form-control" rows="5">{{ $custom_field['value'] }}</textarea> 
				                    				</div> 
				                    				<div class="col-md-12 form-group"> 
				                    					<input type="hidden" name="data[PageMeta][{{ $count }}][meta_id]" value="{{ isset($custom_field['id']) ? $custom_field['id'] : 0 }}">
				                    					<button  class="btn btn-danger CustomFieldRemoveButton" type="button">{{ __('common.delete') }}</button>
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
			                    <button type="button" class="btn btn-primary btn-sm" id="AddCustomField">{{ __('common.add_custom_field') }}</button>
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
		                            <input type="checkbox" name="data[Page][comment]" class="form-check-input" id="ContentComment" value="1" {{ old('data.Page.comment', $page->comment) == '1' ? 'checked' : '' }}>
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
			                        <input type="text" name="data[Page][slug]" class="form-control" id="slug" value="{{ old('data.Page.slug', $page->slug) }}" disabled="disabled">
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
			                        <select name="data[Page][user_id]" class="default-select form-control" id="ContentUserId">
			                        	@forelse($users as $user)
				                        	<option value="{{ $user->id }}" {{ old('data.Page.user_id', $page->user_id) == $user->id ? 'selected="selected"' : '' }}>{{ $user->full_name }}</option>
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
		                        		<input type="text" name="data[PageSeo][page_title]" class="form-control" id="ContentSeoPageTitle" placeholder="{{ __('common.page_title') }}" maxlength="255" value="{{ old('data.PageSeo.page_title', optional($page->page_seo)->page_title) }}">
		                        	</div>
		                        	<div class="col-md-6 form-group">
		                        		<label for="ContentSeoMetaKeywords">{{ __('common.keywords') }}</label>
		                        		<input type="text" name="data[PageSeo][meta_keywords]" class="form-control" id="ContentSeoMetaKeywords" placeholder="{{ __('common.enter_meta_keywords') }}" maxlength="255" value="{{ old('data.PageSeo.meta_keywords', optional($page->page_seo)->meta_keywords) }}">
		                        	</div>
		                        	<div class="col-md-6 form-group">
		                        		<label for="ContentSeoMetaDescriptions">{{ __('common.descriptions') }}</label>
		                        		<textarea name="data[PageSeo][meta_descriptions]" class="form-control" id="ContentSeoMetaDescriptions" rows="5" placeholder="{{ __('common.enter_meta_descriptions') }}">{!! old('data.PageSeo.meta_descriptions', optional($page->page_seo)->meta_descriptions) !!}</textarea>
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
		                    			<label for="Status"><i class="fa fa-key"></i> {{ __('common.status') }}</label>
		                    			<select name="data[Page][status]" id="Status" class="default-select form-control">
		                    				<option value="1" {{ old('data.Page.status', $page->status) == 1 ? 'selected="selected"' : '' }}>{{ __('common.published') }}</option>
		                    				<option value="2" {{ old('data.Page.status', $page->status) == 2 ? 'selected="selected"' : '' }}>{{ __('common.draft') }}</option>

		                    				@if($page->status == 3)
		                    					<option value="3" {{ old('data.Page.status', $page->status) == 3 ? 'selected="selected"' : '' }}>{{ __('common.trash') }}</option>
		                    				@endif
		                    				<option value="4" {{ old('data.Page.status', $page->status) == 4 ? 'selected="selected"' : '' }}>{{ __('common.private') }}</option>
		                    				<option value="5" {{ old('data.Page.status', $page->status) == 5 ? 'selected="selected"' : '' }}>{{ __('common.pending') }}</option>
		                    			</select>
		                    		</div>
		                    		<div class="col-md-12 form-group">
		                    			<label for="ContentVisibility"><i class="fa fa-eye"></i> {{ __('common.visibility') }}:</label>
		                    			<select name="data[Page][visibility]" id="ContentVisibility" class="default-select form-control">
		                    				<option value="Pu" {{ old('data.Page.visibility', $page->visibility) == 'Pu' ? 'selected="selected"' : '' }}>{{ __('common.public') }}</option>
		                    				<option value="PP" {{ old('data.Page.visibility', $page->visibility) == 'PP' ? 'selected="selected"' : '' }}>{{ __('common.password_protected') }}</option>
		                    				<option value="Pr" {{ old('data.Page.visibility', $page->visibility) == 'Pr' ? 'selected="selected"' : '' }}>{{ __('common.private') }}</option>
		                    			</select>
		                    		</div>
		                    		<div class="col-md-12 form-group {{ old('data.Page.visibility', $page->visibility) == 'PP' ? '' : 'd-none' }}" id="PublicPasswordTextbox">
		                    			<label for="ContentPassword">{{ __('common.password') }}</label>
		                    			<input type="password" name="data[Page][password]" class="form-control" id="ContentPassword" placeholder="{{ __('common.enter_password') }}" value="{{ old('data.Page.password', $page->password)}}">
		                    		</div>
		                    		<div class="col-md-12 form-group">
		                    			<label for="PublishDateTimeTextbox"><i class="fa fa-calendar"></i> {{ __('common.published_on') }}:</label>
		                    			<input type="text" name="data[Page][publish_on]" class="datetimepicker form-control" id="PublishDateTimeTextbox" value="{{ $page->publish_on ? old('data.Page.publish_on', $page->publish_on) : date('Y-m-d') }}">
		                    		</div>
		                    		<div class="col-md-12">
		                    			<button type="submit" class="btn btn-primary">{{ __('common.update') }}</button>
		                    			@if($page->status != 3)
			                    			<a href="{{ route('page.admin.admin_trash_status', $page->id) }}" class="btn btn-danger">{{ __('common.move_to_trash') }}</a>
			                    		@endif
		                    		</div>
		                    	</div>
		                    </div>
		                </div>
		            </div>

		            {!! CptHelper::cpt_categories_box('page', $screenOption, old('data.BlogCategory', $page->page_categories->pluck('id')->toArray())) !!}

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
			                        	@forelse($parentPages as $page_val)
			                        		<option value="{{ $page_val->id }}" {{ old('data.Page.parent_id', $page->parent_id) == $page_val->id ? 'selected="selected"' : '' }}>{{ $page_val->title }}</option>
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
			                        <select name="data[Page][page_type]" class="default-select form-control" id="ContentContentType">
			                        	<option value="Page" {{ old('data.Page.page_type', $page->page_type) == 'Page' ? 'selected="selected"' : '' }}>{{ __('common.page') }}</option>
			                        	<option value="Widget" {{ old('data.Page.page_type', $page->page_type) == 'Widget' ? 'selected="selected"' : '' }}>{{ __('common.widget') }}</option>
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
		                        	@php
		                        		$ximageMetaId = optional($page->feature_img)->id;
		                        		$ximageMetaValue = optional($page->feature_img)->value;
		                        	@endphp
		                        	<div id="RemoveItemImg_{{ $page->id }}">
										<img src="{{ DzHelper::getStorageImage('storage/page-images/'.@$ximageMetaValue) }}" class="avatar img-for-onchange" alt="{{ __('common.image') }}" title="{{ __('common.image') }}"> 
									</div>
									<div class="d-flex align-items-center">
										@if($ximageMetaValue)
										<a href="javascript:void(0);" rdx-link="{{ route('page.admin.remove_feature_image', $page->id) }}" class="rdxUpdateAjax btn btn-primary btn-xs rounded-0 me-2" rdx-delete-box="RemoveItemImg_{{ $page->id }}">{{ __('common.remove') }}</a>
										@endif
										<div >
											<input type="file" class="ps-2 form-control img-input-onchange" name="data[PageMeta][0][value]"  accept=".png, .jpg, .jpeg"  id="PageMeta0Value">
										</div>
									</div>
									<input type="hidden" name="data[PageMeta][0][title]" value="ximage" id="ContentMeta0Title">
									<input type="hidden" name="data[PageMeta][0][meta_id]" value="{{ isset($ximageMetaId) ? $ximageMetaId : 0 }}">
									<input type="hidden" name="data[PageMeta][0][old_value]" value="{{ isset($ximageMetaValue) ? $ximageMetaValue : '' }}">
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
		{!! CustomFieldHelper::custom_fields('pages', $page->id) !!}
		{!! ThemeOption::AttachPageOptions($page->id) !!}
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