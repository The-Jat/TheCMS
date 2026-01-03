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
				@if(!empty($screenOption))
					@forelse($screenOption as $key => $value)
						<div class="col-md-2 form-group">
							<label class="checkbox-inline">
								<input type="checkbox" id="Allow{{ $key }}" class="me-1 m-0 form-check-input allowField Allow{{ $key }}" rel="{{ $key }}" {{ $value['visibility'] ? 'checked="checked"' : '' }}>
								{{ $key }}
							</label>
						</div>
					@empty
					@endforelse
				@endif
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
				<li class="breadcrumb-item"><a href="{{ route('blog.admin.index') }}">{{ __('common.blogs') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.edit_blog') }}</a></li>
			</ol>
		</div>
	</div>

	<form action="{{ route('blog.admin.update', $blog->id) }}" method="post" enctype="multipart/form-data">
		@csrf
		@php
			$blog_view = HelpDesk::getPostMeta(optional($blog)->id,'blog_view') ?? 0
		@endphp
		<input type="hidden" name="data[BlogMeta][2][title]" value="blog_view">
		<input type="hidden" name="data[BlogMeta][2][value]" value="{{$blog_view}}">
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">{{ __('common.edit_blog') }}</h4>
							</div>
							<div class="card-body p-4">
								<div class="row">
									<div class="form-group col-md-12">
										<label for="BlogTitle">{{ __('common.title') }}</label>
										<input type="text" name="data[Blog][title]" class="form-control MakeSlug" id="BlogTitle" placeholder="{{ __('common.title') }}" value="{{ old('data.Blog.title', $blog->title) }}" rel="slug">
										@error('data.Blog.title')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>

									<div class="form-group col-md-12">
										<strong>{{ __('common.permalink') }}:</strong>
										<a href="{!! DzHelper::laraBlogLink($blog->id) !!}">
											{{ url('/') }}/<span class='font-green permalinkSlugSpan'>{{ $blog->slug }}</span>
										</a>
										<div class="editPermalinkContainer">
											<input type="text" name="data[Blog][editslug]" id="BlogEditSlug" class="form-control" value="{{ $blog->slug }}">
											<button type="button" class="btn btn-link btn-sm editPermalinkOkButton">{{ __('common.ok') }}</button>
											<a href="javascript:void(0);" class="editPermalinkCancelButton">{{ __('common.cancel') }}</a>
										</div>
										<button type="button" class="btn btn-link btn-sm editPermalink" title="{{ __('common.click_to_edit_url') }}">{{ __('common.edit') }}</button>
									</div>
									<div class="form-group col-md-12">
										<textarea name="data[Blog][content]" class="form-control W3cmsCkeditor h-auto" id="BlogContent" rows="10">{{ old('data.Blog.content', $blog->content) }}</textarea>
										@error('data.Blog.content')
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
						<div class="card accordion accordion-rounded-stylish accordion-bordered XExcerpt {{ $screenOption['Excerpt']['visibility'] ? '' : 'd-none' }}" id="accordion-excerpt">
							<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-excerpt" aria-expanded="true">
								<h4 class="card-title">{{ __('common.excerpt') }}</h4>
								<span class="accordion-header-indicator"></span>
							</div>
							<div class="accordion__body p-4 collapse show" id="with-excerpt" data-bs-parent="#accordion-excerpt">
								<div class="form-group">
									<label for="ContentExcerpt">{{ __('common.excerpt') }}</label>
									<textarea name="data[Blog][excerpt]" class="form-control mb-1" id="ContentExcerpt" rows="5">{{ old('data.Blog.excerpt', $blog->excerpt) }}</textarea>
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
										$count = 2;
										$custom_fields = old('data.BlogMeta') ? old('data.BlogMeta') : $blog->blog_meta;
									@endphp
									@if(!empty($custom_fields))
										<div id="customFieldContainer">
											@foreach($custom_fields as $custom_field)
												@if(in_array($custom_field['title'], ['ximage','xvideo','w3_blog_options','blog_view']))
													@continue
												@endif
												@php
													$count++;
												@endphp
												<div class="row xrow mb-2">
													<div class="form-group col-md-6">
														<label for="BlogMetaName_{{ $count }}">{{ __('common.title') }}</label>
														<input type="text" name="data[BlogMeta][{{ $count }}][title]" class="form-control" id="BlogMetaName_{{ $count }}" value="{{ $custom_field['title'] }}">
													</div>
													<div class="col-md-6 form-group">
														<label for="BlogMetaValue_{{ $count }}">{{ __('common.value') }}</label>
														<textarea name="data[BlogMeta][{{ $count }}][value]" id="BlogMetaValue_{{ $count }}" class="form-control" rows="5">{{ $custom_field['value'] }}</textarea>
													</div>
                                                    <div class="col-md-12 form-group"> <button class="btn btn-danger btn-sm CustomFieldRemoveButton" type="button">Delete</button> </div>
												</div>
											@endforeach
										</div>
									@endif
									<input type="hidden" id="last_cf_num" value="{{ $count }}">
								</div>
								<div class="row">
									<div class="col-md-6 form-group">
										<label for="BlogMetaName">{{ __('common.title') }}</label>
										<input type="text" class="form-control" id="BlogMetaName" placeholder="{{ __('common.title') }}">
									</div>
									<div class="col-md-6 form-group">
										<label for="BlogMetaValue">{{ __('common.value') }}</label>
										<textarea class="form-control" id="BlogMetaValue" rows="5"></textarea>
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
									<input type="hidden" name="data[Blog][comment]" id="ContentComment_" value="0">
									<input type="checkbox" name="data[Blog][comment]" class="form-check-input" id="ContentComment" value="1" {{ old('data.Blog.comment', $blog->comment) == '1' ? 'checked' : '' }}>
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
									<input type="text" name="data[Blog][slug]" class="form-control" id="slug" value="{{ old('data.Blog.slug', $blog->slug) }}" disabled="disabled">
									@error('data.Blog.slug')
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
									<select name="data[Blog][user_id]" class="default-select form-control" id="ContentUserId">
										@forelse($users as $user)
											<option value="{{ $user->id }}" {{ old('data.Blog.user_id', $blog->user_id) == $user->id ? 'selected="selected"' : '' }}>{{ $user->full_name }}</option>
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
										<label for="ContentSeoBlogTitle">{{ __('common.blog_title') }}</label>
										<input type="text" name="data[BlogSeo][page_title]" class="form-control" id="ContentSeoBlogTitle" placeholder="{{ __('common.blog_title') }}" maxlength="255" value="{{ old('data.BlogSeo.page_title', optional($blog->blog_seo)->page_title) }}">
									</div>
									<div class=" form-group col-md-6">
										<label for="ContentSeoMetaKeywords">{{ __('common.keywords') }}</label>
										<input type="text" name="data[BlogSeo][meta_keywords]" class="form-control" id="ContentSeoMetaKeywords" placeholder="{{ __('common.enter_meta_keywords') }}" maxlength="255" value="{{ old('data.BlogSeo.meta_keywords', optional($blog->blog_seo)->meta_keywords) }}">
									</div>
									<div class="form-group col-md-6">
										<label for="ContentSeoMetaDescriptions">{{ __('common.descriptions') }}</label>
										<textarea name="data[BlogSeo][meta_descriptions]" class="form-control" id="ContentSeoMetaDescriptions" rows="5" placeholder="{{ __('common.enter_meta_descriptions') }}">{{ old('data.BlogSeo.meta_descriptions', optional($blog->blog_seo)->meta_descriptions) }}</textarea>
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
										<select name="data[Blog][status]" id="Status" class="default-select form-control">
											<option value="1" {{ old('data.Blog.status', $blog->status) == 1 ? 'selected="selected"' : '' }}>{{ __('common.published') }}</option>
		                    				<option value="2" {{ old('data.Blog.status', $blog->status) == 2 ? 'selected="selected"' : '' }}>{{ __('common.draft') }}</option>

		                    				@if($blog->status == 3)
		                    					<option value="3" {{ old('data.Blog.status', $blog->status) == 3 ? 'selected="selected"' : '' }}>{{ __('common.trash') }}</option>
		                    				@endif
		                    				<option value="4" {{ old('data.Blog.status', $blog->status) == 4 ? 'selected="selected"' : '' }}>{{ __('common.private') }}</option>
		                    				<option value="5" {{ old('data.Blog.status', $blog->status) == 5 ? 'selected="selected"' : '' }}>{{ __('common.pending') }}</option>
										</select>
									</div>
									<div class="col-md-12 form-group">
										<label for="ContentVisibility"><i class="fa fa-eye"></i> {{ __('common.visibility') }}:</label>
										<select name="data[Blog][visibility]" id="ContentVisibility" class="default-select form-control">
											<option value="Pu" {{ old('data.Blog.visibility', $blog->visibility) == 'Pu' ? 'selected="selected"' : '' }}>{{ __('common.public') }}</option>
		                    				<option value="PP" {{ old('data.Blog.visibility', $blog->visibility) == 'PP' ? 'selected="selected"' : '' }}>{{ __('common.password_protected') }}</option>
		                    				<option value="Pr" {{ old('data.Blog.visibility', $blog->visibility) == 'Pr' ? 'selected="selected"' : '' }}>{{ __('common.private') }}</option>
										</select>
									</div>
									<div class="col-md-12 form-group {{ old('visibility', $blog->visibility) == 'PP' ? '' : 'd-none' }}" id="PublicPasswordTextbox">
										<label for="ContentPassword">{{ __('common.password') }}</label>
										<input type="password" name="data[Blog][password]" class="form-control" id="ContentPassword" placeholder="{{ __('common.enter_password') }}" value="{{ old('data.Blog.password', $blog->password)}}" autocomplete="New-Password">
									</div>
									<div class="col-md-12 form-group" id="PublicPasswordTextbox">
										<label for="PublishDateTimeTextbox"><i class="fa fa-calendar"></i> {{ __('common.published_on') }}:</label>
										<input type="text" name="data[Blog][publish_on]" class="datetimepicker form-control" id="PublishDateTimeTextbox" value="{{ $blog->publish_on ? old('data.Blog.publish_on', $blog->publish_on) : date('Y-m-d') }}">
									</div>
									<div class="col-md-12">
										<button type="submit" class="btn btn-primary">{{ __('common.update') }}</button>
										@if($blog->status != 3)
			                    			<a href="{{ route('blog.admin.admin_trash_status', $blog->id) }}" class="btn btn-danger">{{ __('common.move_to_trash') }}</a>
			                    		@endif
									</div>
								</div>
							</div>
						</div>
					</div>
		            {!! CptHelper::cpt_categories_box('blog', $screenOption, old('data.TaxoCategory', $blog->blog_taxo_categories->pluck('id')->toArray())) !!}
					<div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered XCategories {{ $screenOption['Categories']['visibility'] ? '' : 'd-none' }}" id="accordion-categories">
							<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-categories" aria-expanded="true">
								<h4 class="card-title">{{ __('common.categories') }}</h4>
								<span class="accordion-header-indicator"></span>
							</div>
							<div class="accordion__body p-4 collapse show appendCategory" id="with-categories" data-bs-parent="#accordion-categories">
								{!! $categoryArr !!}
								<a href="javascript:void(0)" title="{{ __('common.click_add_new_category') }}" class="addNewBlogCategorylink text-primary d-block my-2"><i class="fa fa-plus"></i>{{ __('common.add_new_category') }}</a>
								<div class="col-md-12 form-group newCategoryDiv">
									<div class="form-group">
										<label for="BlogCategoryBlogCategory">{{ __('common.new_category_name') }}</label>
                          				<input type="text" class="form-control newCategoryField mb-2" id="BlogCategoryBlogCategory">
									</div>
									<div class="form-group">
										<label for="ParentBlogCategory">{{ __('common.parent_category') }}</label>
										<select id="ParentBlogCategory" class="default-select form-control CategoryParentId">
											<option value="">-{{ __('common.parent_category') }}-</option>
											@forelse($parentCategoryArr as $value)
												<option value="{{ $value['id'] }}">{{ $value['title'] }}</option>
											@empty
											@endforelse
										</select>
									</div>
                          			<input type="hidden" class="form-control rdx-link" value="{{ route("blog_category.admin.admin_ajax_add_category") }}">
                         			<button type="button" class="btn btn-primary addNewBlogCategoryBtn">{{ __('common.add_new') }}</button>
                         		</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered XTags {{ $screenOption['Tags']['visibility'] ? '' : 'd-none' }}" id="accordion-tags">
							<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-tags" aria-expanded="true">
								<h4 class="card-title">{{ __('common.tags') }}</h4>
								<span class="accordion-header-indicator"></span>
							</div>
							<div class="accordion__body p-4 collapse show" id="with-tags" data-bs-parent="#accordion-tags">
								<div class="form-group">
									<input type="text" name="data[BlogTag]" data-role="tagsinput" class="form-control bootstrap-tagsinput" placeholder="{{ __('common.type_tags_here') }}" id="BlogBlogTag" value="{{ $blog_tags }}">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						@php
							$ximageMeta = @$blog->feature_img;
						@endphp
						<div class="card accordion accordion-rounded-stylish accordion-bordered XFeaturedImage {{ $screenOption['FeaturedImage']['visibility'] ? '' : 'd-none' }}" id="accordion-feature-image">
							<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-feature-image" aria-expanded="true">
								<h4 class="card-title">{{ __('common.featured_image') }}</h4>
								<span class="accordion-header-indicator"></span>
							</div>
							<div class="accordion__body p-4 collapse show" id="with-feature-image" data-bs-parent="#accordion-feature-image">
								<div class="featured-img-preview img-parent-box">
									<div id="RemoveItemImg_{{ $blog->id }}">
										<img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$ximageMeta->value) }}" class="avatar img-for-onchange"  alt="{{ __('common.image') }}" title="{{ __('common.image') }}">
									</div>
									<div class="d-flex align-items-center">
										@if(!empty($ximageMeta->value))
										<a href="javascript:void(0);" rdx-link="{{ route('blog.admin.remove_feature_image', $blog->id) }}" class="rdxUpdateAjax btn btn-primary btn-xs rounded-0 me-2" rdx-delete-box="RemoveItemImg_{{ $blog->id }}">{{ __('common.remove') }}</a>
										@endif
										<div >
											<input type="file" class="ps-2 form-control img-input-onchange" name="data[BlogMeta][0][value]" accept=".png, .jpg, .jpeg"  id="BlogMeta0Value" >
										</div>
									</div>
									<input type="hidden" name="data[BlogMeta][0][title]" value="ximage" id="ContentMeta0Title">
									<input type="hidden" name="data[BlogMeta][0][meta_id]" value="{{ isset($ximageMeta->id) ? $ximageMeta->id : 0 }}">
									<input type="hidden" name="data[BlogMeta][0][old_value]" value="{{ isset($ximageMeta->value) ? $ximageMeta->value : '' }}">
							   	</div>
								@error('data.BlogMeta.0.value')
								  <p class="text-danger">
								      {{ $message }}
								  </p>
								@enderror
							</div>
						</div>
					</div>
					<div class="col-md-12">
						@php
							$xvideoMeta = $blog->video;
                    		$xvideo_url = !empty($xvideoMeta->value) ? $xvideoMeta->value : '';
						@endphp
						<div class="card accordion accordion-rounded-stylish accordion-bordered XVideo {{ $screenOption['Video']['visibility'] ? '' : 'd-none' }}" id="accordion-video">
							<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-video" aria-expanded="true">
								<h4 class="card-title">{{ __('common.video') }}</h4>
								<span class="accordion-header-indicator"></span>
							</div>
							<div class="accordion__body p-4 collapse show" id="with-video" data-bs-parent="#accordion-video">
								<input type="hidden" name="data[BlogMeta][1][title]" value="xvideo" id="BlogMeta1Title">
								<input type="text" name="data[BlogMeta][1][value]" class="form-control bootstrap-tagsinput" placeholder="{{ __('common.youtube_video_link') }}" id="BlogMeta1Value" value="{{ $xvideo_url }}">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		{!! CustomFieldHelper::custom_fields('blogs', $blog->id) !!}
		{!! ThemeOption::AttachBlogOptions($blog->id) !!}
	</form>
</div>

@push('inline-scripts')
	<script>
		'use strict';
		var screenOptionArray = '<?php echo json_encode($screenOption) ?>';
	</script>
@endpush

@endsection

