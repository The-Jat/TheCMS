{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="card accordion accordion-rounded-stylish accordion-bordered" id="accordion-slug">
		<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-slug" aria-expanded="true">
			<h4 class="card-title">{{ __('w3cpt::common.screen_options') }}</h4>
			<span class="accordion-header-indicator"></span>
		</div>
		<div class="accordion__body p-4 collapse show" id="with-slug" data-bs-parent="#accordion-slug">
			<div class="row">
				@if(!empty($screenOption))
					@forelse($screenOption as $key => $value)
						@if(!empty($value['default']))
							@continue
						@endif
						<div class="col-md-2 mb-2">
							<label class="checkbox-inline">
								<input type="checkbox" id="Allow{{ $key }}" class="me-1 m-0 form-check-input allowField Allow{{ $key }}" rel="{{ $key }}" {{ $value['visibility'] ? 'checked="checked"' : '' }}>
								{{ isset($value['lang']) ? $value['display_title'] : __('w3cpt::common.'.$value['display_title']) }}
							</label>
						</div>
					@empty
					@endforelse
				@endif
			</div>
		</div>
	</div>

	<div class="row page-titles mx-0 ">
		<div class="col-sm-6 p-0">
			<div class="welcome-text">
				<h4>{{ $post_type['cpt_labels']['name'] }}</h4>
				<span>{{ $post_type['cpt_labels']['add_new_item'] }}</span>
			</div>
		</div>
		<div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('cpt.blog.admin.index', ['post_type' => $post_type]) }}">{{ $post_type['cpt_labels']['name'] }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $post_type['cpt_labels']['add_new_item'] }}</a></li>
			</ol>
		</div>
	</div>

	<form action="{{ route('cpt.blog.admin.store', ['post_type' => $post_type['cpt_name']]) }}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">{{ $post_type['cpt_labels']['add_new_item'] }}</h4>
								<button type="button" class="shadow-none btn btn-sm btn-dark" id="UseMagicEditor" use_editor="{{ (Str::contains(old('data.Blog.content') , ['%ME%', '%ME-EL%'])) ? 'true' : 'false' }}"><i class="fa fa-list"></i> {{ __('Use Magic Editor') }}</button>
							</div>
							<div class="card-body p-4">
								<div class="row">
									@if(array_key_exists('Title', $screenOption))
										<div class="form-group col-md-12 XTitle {{ !empty($screenOption['Title']['visibility']) ? '' : 'd-none' }}">
											<label for="BlogTitle">{{ __('w3cpt::common.title') }}</label>
											<input type="text" name="data[Blog][title]" class="form-control MakeSlug" id="BlogTitle" placeholder="{{ __('w3cpt::common.title') }}" value="{{ old('data.Blog.title') }}" rel="slug">
											@error('data.Blog.title')
												<p class="text-danger">
													{{ $message }}
												</p>
											@enderror
										</div>
									@endif
								</div>
							</div>
						</div>
					</div>

					@if(array_key_exists('Editor', $screenOption))
					<div class="col-md-12">
						<div class="form-group col-md-12 ">
							<div class="in-box ClassicEditorBox">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">{{ __('System Editor') }}</h4>
									</div>
									<div class="card-body table-responsive">
										<textarea name="data[Page][content]" class="form-control W3cmsCkeditor h-auto" id="PageContent" rows="10">{!! old('data.Page.content') !!}</textarea>
									</div>
								</div>
							</div>

							<div class="in-box MagicEditorBox  d-none">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">{{ __('common.magic_editor') }}</h4>
											 
										<a href="{{ route('admin.use.me') }}" data-bs-toggle="modal" data-bs-target="#AddElement" class=" btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
									</div>
									<div class="card-body table-responsive">
										<div class="form-group" id="MagicEditorElementContainer">

											@if(!empty(old('data.Page.content')) && HelpDesk::shortcodeToHtml(old('data.Page.content')))
												{!! HelpDesk::shortcodeToHtml(old('data.Page.content')) !!}
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
	                @endif
					@if(array_key_exists('Excerpt', $screenOption))
						<div class="col-md-12">
							<div class="card accordion accordion-rounded-stylish accordion-bordered XExcerpt {{ !empty($screenOption['Excerpt']['visibility']) ? '' : 'd-none' }}" id="accordion-excerpt">
								<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-excerpt" aria-expanded="true">
									<h4 class="card-title">{{ __('w3cpt::common.excerpt') }}</h4>
									<span class="accordion-header-indicator"></span>
								</div>
								<div class="accordion__body p-4 collapse show" id="with-excerpt" data-bs-parent="#accordion-excerpt">
									<div class="form-group">
										<label for="ContentExcerpt">{{ __('w3cpt::common.excerpt') }}</label>
										<textarea name="data[Blog][excerpt]" class="form-control" id="ContentExcerpt" rows="5">{{ old('data.Blog.excerpt') }}</textarea>
										<small>{{ __('w3cpt::common.add_excerpt_text') }}</small>
									</div>
								</div>
							</div>
						</div>
					@endif
					@if(array_key_exists('CustomFields', $screenOption))
						<div class="col-md-12">
							<div class="card accordion accordion-rounded-stylish accordion-bordered XCustomFields {{ !empty($screenOption['CustomFields']['visibility']) ? '' : 'd-none' }}" id="accordion-custom-fields">
								<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-custom-fields" aria-expanded="true">
									<h4 class="card-title">{{ __('w3cpt::common.custom_fields') }}</h4>
									<span class="accordion-header-indicator"></span>
								</div>
								<div class="accordion__body p-4 collapse show" id="with-custom-fields" data-bs-parent="#accordion-custom-fields">
									<div id="AppendContainer">
										@php
											$count = 1;
											$custom_fields = old('data.BlogMeta');
										@endphp
										@if(!empty($custom_fields))
											<div id="customFieldContainer">
												@foreach($custom_fields as $custom_field)
													@if($custom_field['title'] == 'ximage' || $custom_field['title'] == 'xvideo' || $custom_field['title'] == 'w3_blog_options')
														@continue
													@endif
													@php
														$count++;
													@endphp
													<div class="row xrow">
														<div class="col-md-6 form-group">
															<label for="BlogMetaName_{{ $count }}">{{ __('w3cpt::common.title') }}</label> 
															<input type="text" name="data[BlogMeta][{{ $count }}][title]" class="form-control" id="BlogMetaName_{{ $count }}" value="{{ $custom_field['title'] }}"> 
														</div> 
														<div class="col-md-6 form-group"> 
															<label for="BlogMetaValue_{{ $count }}">{{ __('w3cpt::common.value') }}</label> 
															<textarea name="data[BlogMeta][{{ $count }}][value]" id="BlogMetaValue_{{ $count }}" class="form-control" rows="5">{{ isset($custom_field['value']) ? $custom_field['value'] : '' }}</textarea> 
														</div> 
														<div class="col-md-12 form-group"> 
															<button class="btn btn-danger CustomFieldRemoveButton" type="button">{{ __('w3cpt::common.delete') }}</button>
														</div>
													</div>
												@endforeach
											</div>
										@endif
										<input type="hidden" id="last_cf_num" value="{{ $count }}">
									</div>
									<div class="row">
										<div class="form-group col-md-6">
											<label for="BlogMetaName">{{ __('w3cpt::common.title') }}</label>
											<input type="text" class="form-control" id="BlogMetaName" placeholder="{{ __('w3cpt::common.title') }}">
										</div>
										<div class="form-group col-md-6">
											<label for="BlogMetaValue">{{ __('w3cpt::common.value') }}</label>
											<textarea class="form-control" id="BlogMetaValue" rows="5"></textarea>
										</div>
									</div>
									<button type="button" class="btn btn-primary btn-sm" id="AddCustomField">{{ __('w3cpt::common.add_custom_field') }}</button>
									<small class="d-block mt-2">{{ __('w3cpt::common.custom_field_description') }}</small>
								</div>
							</div>
						</div>
					@endif
					@if(array_key_exists('Comments', $screenOption))
						<div class="col-md-12">
							<div class="card accordion accordion-rounded-stylish accordion-bordered XComments {{ !empty($screenOption['Comments']['visibility']) ? '' : 'd-none' }}" id="accordion-comments">
								<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-comments" aria-expanded="true">
									<h4 class="card-title">{{ __('w3cpt::common.Comments') }}</h4>
									<span class="accordion-header-indicator"></span>
								</div>
								<div class="accordion__body p-4 collapse show" id="with-comments" data-bs-parent="#accordion-comments">
									<div class="form-check mb-2">
										<input type="hidden" name="data[Blog][comment]" id="ContentComment_" value="0">
										<input type="checkbox" name="data[Blog][comment]" class="form-check-input" id="ContentComment" value="1" {{ old('data.Blog.comment') == 1 ? 'checked="checked"' : '' }}>
										<label class="form-check-label" for="ContentComment">{{ __('w3cpt::common.allow_comments') }}</label>
									</div>
								</div>
							</div>
						</div>
					@endif
					@if(array_key_exists('Slug', $screenOption))
						<div class="col-md-12">
							<div class="card accordion accordion-rounded-stylish accordion-bordered XSlug {{ !empty($screenOption['Slug']['visibility']) ? '' : 'd-none' }}" id="accordion-slug">
								<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-slug" aria-expanded="true">
									<h4 class="card-title">{{ __('w3cpt::common.slug') }}</h4>
									<span class="accordion-header-indicator"></span>
								</div>
								<div class="accordion__body p-4 collapse show" id="with-slug" data-bs-parent="#accordion-slug">
									<div class="form-group col-md-12">
										<label for="slug">{{ __('w3cpt::common.slug') }}</label>
										<input type="text" name="data[Blog][slug]" class="form-control" id="slug" value="{{ old('data.Blog.slug') }}">
									</div>			
									@error('data.Blog.slug')
										<p class="text-danger">
											{{ $message }}
										</p>
									@enderror
								</div>
							</div>
						</div>
					@endif
					@if(array_key_exists('Author', $screenOption))
						<div class="col-md-12">
							<div class="card accordion accordion-rounded-stylish accordion-bordered XAuthor {{ !empty($screenOption['Author']['visibility']) ? '' : 'd-none' }}" id="accordion-author">
								<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-author" aria-expanded="true">
									<h4 class="card-title">{{ __('w3cpt::common.author') }}</h4>
									<span class="accordion-header-indicator"></span>
								</div>
								<div class="accordion__body p-4 collapse show" id="with-author" data-bs-parent="#accordion-author">
									<div class="form-group">
										<label for="ContentUserId">{{ __('w3cpt::common.user') }}</label>
										<select name="data[Blog][user_id]" class="default-select form-control" id="ContentUserId">
											@forelse($users as $user)
												<option value="{{ $user->id }}" {{ old('data.Blog.user_id') == $user->id ? 'selected="selected"' : '' }}>{{ $user->full_name }}</option>
											@empty
											@endforelse
										</select>
									</div>
								</div>
							</div>
						</div>
					@endif
					@if(array_key_exists('Seo', $screenOption))
						<div class="col-md-12">
							<div class="card accordion accordion-rounded-stylish accordion-bordered XSeo {{ !empty($screenOption['Seo']['visibility']) ? '' : 'd-none' }}" id="accordion-seo">
								<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-seo" aria-expanded="true">
									<h4 class="card-title">{{ __('w3cpt::common.seo') }}</h4>
									<span class="accordion-header-indicator"></span>
								</div>
								<div class="accordion__body p-4 collapse show" id="with-seo" data-bs-parent="#accordion-seo">
									<div class="row">
										<div class="col-md-12 form-group">
											<label for="ContentSeoBlogTitle">{{ __('w3cpt::common.blog_title') }}</label>
											<input type="text" name="data[BlogSeo][page_title]" class="form-control" id="ContentSeoBlogTitle" placeholder="{{ __('w3cpt::common.blog_title') }}" maxlength="255" value="{{ old('data.BlogSeo.page_title') }}">
										</div>
										<div class="form-group col-md-6">
											<label for="ContentSeoMetaKeywords">{{ __('w3cpt::common.keywords') }}</label>
											<input type="text" name="data[BlogSeo][meta_keywords]" class="form-control" id="ContentSeoMetaKeywords" placeholder="{{ __('w3cpt::common.enter_meta_keywords') }}" maxlength="255" value="{{ old('data.BlogSeo.meta_keywords') }}">
										</div>
										<div class="form-group col-md-6">
											<label for="ContentSeoMetaDescriptions">{{ __('w3cpt::common.descriptions') }}</label>
											<textarea name="data[BlogSeo][meta_descriptions]" class="form-control" id="ContentSeoMetaDescriptions" rows="5" placeholder="{{ __('w3cpt::common.enter_meta_descriptions') }}">{{ old('data.BlogSeo.meta_descriptions') }}</textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					@endif
				</div>
			</div>	
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered" id="accordion-publish">
							<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-publish" aria-expanded="true">
								<h4 class="card-title">{{ __('w3cpt::common.publish') }}</h4>
								<span class="accordion-header-indicator"></span>
							</div>
							<div class="accordion__body p-4 collapse show" id="with-publish" data-bs-parent="#accordion-publish">
								<div class="row">
									<div class="col-md-12 form-group">
										<label for="Status"><i class="fa fa-key"></i> {{ __('w3cpt::common.status') }}:</label>
										<select name="data[Blog][status]" id="Status" class="default-select form-control">
											<option value="1" {{ old('data.Blog.status') == 1 ? 'selected="selected"' : '' }}>{{ __('w3cpt::common.published') }}</option>
											<option value="2" {{ old('data.Blog.status') == 2 ? 'selected="selected"' : '' }}>{{ __('w3cpt::common.draft') }}</option>
											<option value="4" {{ old('data.Blog.status') == 4 ? 'selected="selected"' : '' }}>{{ __('w3cpt::common.private') }}</option>
											<option value="5" {{ old('data.Blog.status') == 5 ? 'selected="selected"' : '' }}>{{ __('w3cpt::common.pending') }}</option>
										</select>
									</div>
									<div class="col-md-12 form-group">
										<label for="ContentVisibility"><i class="fa fa-eye"></i> {{ __('w3cpt::common.visibility') }}:</label>
										<select name="data[Blog][visibility]" id="ContentVisibility" class="default-select form-control">
											<option value="Pu" {{ old('data.Blog.visibility') == 'Pu' ? 'selected="selected"' : '' }}>{{ __('w3cpt::common.public') }}</option>
											<option value="PP" {{ old('data.Blog.visibility') == 'PP' ? 'selected="selected"' : '' }}>{{ __('w3cpt::common.password_protected') }}</option>
											<option value="Pr" {{ old('data.Blog.visibility') == 'Pr' ? 'selected="selected"' : '' }}>{{ __('w3cpt::common.private') }}</option>
										</select>
									</div>
									<div class="col-md-12 form-group {{ old('data.Blog.visibility') == 'PP' ? '' : 'd-none' }}" id="PublicPasswordTextbox">
										<label for="ContentPassword">{{ __('w3cpt::common.password') }}</label>
										<input type="password" name="data[Blog][password]" class="form-control" id="ContentPassword" placeholder="{{ __('w3cpt::common.enter_password') }}" value="{{ old('data.Blog.password') }}" autocomplete="New-Password">
									</div>
									<div class="col-md-12 form-group" id="PublicPasswordTextbox">
										<label for="PublishDateTimeTextbox"><i class="fa fa-calendar"></i> {{ __('w3cpt::common.published_on') }}:</label>
										<input type="text" name="data[Blog][publish_on]" class="datetimepicker form-control" id="PublishDateTimeTextbox" value="{{ old('data.Blog.publish_on', date('Y-m-d')) }}">
									</div>
									<div class="col-md-12">
										<button type="submit" class="btn btn-primary">{{ __('w3cpt::common.publish') }}</button>
									</div>
								</div>
							</div>
						</div>
					</div>
						{!! CptHelper::cpt_categories_box($post_type['cpt_name'], $screenOption, $blogCatArr) !!}
					
					@if(array_key_exists('Tags', $screenOption))
						<div class="col-md-12">
							<div class="card accordion accordion-rounded-stylish accordion-bordered XTags {{ !empty($screenOption['Tags']['visibility']) ? '' : 'd-none' }}" id="accordion-tags">
								<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-tags" aria-expanded="true">
									<h4 class="card-title">{{ __('w3cpt::common.tags') }}</h4>
									<span class="accordion-header-indicator"></span>
								</div>
								<div class="accordion__body p-4 collapse show" id="with-tags" data-bs-parent="#accordion-tags">
									<input type="text" name="data[BlogTag]" data-role="tagsinput" class="form-control bootstrap-tagsinput" placeholder="{{ __('w3cpt::common.type_tags_here') }}" id="BlogBlogTag" value="{{ old('data.BlogTag') }}">
								</div>
							</div>
						</div>
					@endif
					@if(array_key_exists('FeaturedImage', $screenOption))
						<div class="col-md-12">
							<div class="card accordion accordion-rounded-stylish accordion-bordered XFeaturedImage {{ !empty($screenOption['FeaturedImage']['visibility']) ? '' : 'd-none' }}" id="accordion-feature-image">
								<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-feature-image" aria-expanded="true">
									<h4 class="card-title">{{ __('w3cpt::common.featured_image') }}</h4>
									<span class="accordion-header-indicator"></span>
								</div>
								<div class="accordion__body p-4 collapse show" id="with-feature-image" data-bs-parent="#accordion-feature-image">
									<div class="featured-img-preview img-parent-box"> 

										<img src="{{ asset('images/noimage.jpg') }}" class="avatar img-for-onchange"  alt="{{ __('w3cpt::common.image') }}" width="100px" height="100px" title="{{ __('w3cpt::common.image') }}"> 

										<input type="hidden" name="data[BlogMeta][0][title]" value="ximage" id="ContentMeta0Title">
										<div>
											<input type="file" class="ps-2 form-control img-input-onchange" name="data[BlogMeta][0][value]" accept=".png, .jpg, .jpeg"  id="BlogMeta0Value">
										</div>
								   </div>
	                                @error('data.BlogMeta.0.value')
	                                    <p class="text-danger">
	                                        {{ $message }}
	                                    </p>
	                                @enderror
								</div>
							</div>
						</div>
					@endif
					@if(array_key_exists('Video', $screenOption))
						<div class="col-md-12">
							<div class="card accordion accordion-rounded-stylish accordion-bordered XVideo {{ !empty($screenOption['Video']['visibility']) ? '' : 'd-none' }}" id="accordion-video">
								<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-video" aria-expanded="true">
									<h4 class="card-title">{{ __('w3cpt::common.video') }}</h4>
									<span class="accordion-header-indicator"></span>
								</div>
								<div class="accordion__body p-4 collapse show" id="with-video" data-bs-parent="#accordion-video">
									<input type="hidden" name="data[BlogMeta][1][title]" value="xvideo" id="BlogMeta1Title">
									<input type="text" name="data[BlogMeta][1][value]" class="form-control bootstrap-tagsinput" placeholder="{{ __('w3cpt::common.youtube_video_link') }}" id="BlogMeta1Value" value="{{ old('data.BlogMeta.1.value') }}">
								</div>
							</div>
						</div>
					@endif
				</div>
			</div>
		</div>

		{!! CustomFieldHelper::custom_fields('cpt_'.$post_type['cpt_name']) !!}
		
		{!! ThemeOption::AttachCPTOptions($post_type['cpt_name']) !!}

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

<div class="modal fade" id="AjaxModalBoxMd" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content " id="AjaxResultContainerMd" >
			<img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" class="loading">
			<span>&nbsp;&nbsp;Loading... </span>
		</div>
	</div>
</div>

<div class="modal fade" id="AjaxModalBoxLg" role="basic" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content " id="AjaxResultContainerLg">
			<img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" class="loading">
			<span>&nbsp;&nbsp;Loading... </span>
		</div>
	</div>
</div>

<div class="modal fade" id="AjaxModalBoxSm" role="basic" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content " id="AjaxResultContainerSm">
			<img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" class="loading">
			<span>&nbsp;&nbsp;Loading... </span>
		</div>
	</div>
</div>
@endpush

@push('inline-scripts')
	<script>
		'use strict';
		var screenOptionArray = '<?php echo json_encode($screenOption) ?>';
		removeImageSection();
	</script>
@endpush