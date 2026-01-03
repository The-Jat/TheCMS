{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
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
		</div>
	</div>

	<div class="row page-titles mx-0 mb-3">
		<div class="col-sm-6 p-0">
			<div class="welcome-text">
				<h4>{{ __('common.welcome_back_title') }}</h4>
				<p class="mb-0">{{ __('common.welcome_back_desc') }}</p>
		    </div>
		</div>
		<div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('menu.admin.admin_index') }}">{{ __('common.menus') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.all_menus_list') }}</a></li>
			</ol>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-xl-12">
			<form action="{{ route('menu.admin.admin_select_menu') }}" id="MenuSelectMenuForm" method="post">
				@csrf
				<div class="card">
					<div class="card-header d-block">
						<h4 class="card-title">{{ __('common.menu') }}</h4>
					</div>
					<div class="card-body">
						<div class="form-group row">
							<label class="col-md-3 col-form-label">{{ __('common.select_menu_edit') }}:<span class="text-danger">* </span></label>
							<div class="col-md-5">
								<select name="Menu[menu_id]" id="MenuSelect" class="default-select form-control">
									<option value="">{{ __('common.select_menu') }}</option>
									@forelse($menus as $value)
										<option value="{{ $value->id }}" {{ ($menu->id == $value->id) ? 'selected' : '' }}>{{ $value->title }}</option>
									@empty
									@endforelse
								</select>
							</div>
							<div class="col-md-4">
								<button type="submit" class="btn btn-primary">{{ __('common.select') }}</button>
								{{ __('common.or') }}
								<a href="javascript:void(0);" class="text-primary" id="CreateMenu">{{ __('common.create_menu') }}</a>
								<a href="{{ route('menu.admin.admin_index') }}" class="CancelCreateMenu">Cancel</a>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="row">
		<!-- Column starts -->
		<div class="col-xl-5">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-menu-pages accordion accordion-rounded-stylish accordion-bordered" id="accordion-menus">
						<div class="card-header d-block bg-primary accordion-header accordion-header--primary" data-bs-toggle="collapse" data-bs-target="#rounded-menus" aria-expanded="true">
							<span class="accordion-header-icon"></span>
							<span class="accordion-header-text">{{ __('common.menus') }}</span>
							<span class="accordion-header-indicator"></span>
						</div>
						<div id="rounded-menus" class="p-3 accordion__body show" data-bs-parent="#accordion-menus">
							<div id="accordion-menu-child" class="accordion accordion-rounded-stylish accordion-bordered">
								<div class="accordion__item mb-2 XPages {{ $screenOption['Pages']['visibility'] ? '' : 'd-none' }}">
									<form action="{{ route('menu.admin.ajax_add_page') }}" id="MenuAjaxAddPageForm" method="post">
										@csrf
										<input type="hidden" name="Menu[id]" class="PageMenu" id="PageMenuId" value="{{ optional($menu)->id }}">
										<div class="accordion-header accordion-header--primary" data-bs-toggle="collapse" data-bs-target="#rounded-pages" aria-expanded="true">
											<span class="accordion-header-icon"></span>
											<span class="accordion-header-text">{{ __('common.pages') }}</span>
											<span class="accordion-header-indicator"></span>
										</div>
										<div id="rounded-pages" class="accordion__body ItemsCheckboxSec default-tab show p-3" data-bs-parent="#accordion-menu-child">
											<ul class="nav nav-tabs" role="tablist">
												<li class="nav-item">
													<a class="nav-link active checkboxUtility" data-bs-toggle="tab" href="#view-all-pages">{{ __('common.view_all') }}</a>
												</li>
												<li class="nav-item">
													<a class="nav-link checkboxUtility" data-bs-toggle="tab" href="#page-search">{{ __('common.search') }}</a>
												</li>
											</ul>
											<div class="tab-content border-end border-start border-bottom">
												<div class="tab-pane fade active show" id="view-all-pages" role="tabpanel">
													<div class="p-2">
														{!! $pages !!}
													</div>
												</div>
												<div class="tab-pane fade" id="page-search">
													<div class="p-2 form-group">
														<label for="">{{ __('common.search') }}</label>
														<input type="search" class="form-control SearchForMenu" placeholder="{{ __('common.enter_page_name') }}">
														<input type="hidden" class="search_type" value="page">
													</div>
													<div class="searchContentDiv"></div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 pt-3 pb-2">
													<a href="javascript:void(0);" class="text-primary SelectAllItems">{{ __('common.select_all') }}</a>
													<span class="text-black mx-1">|</span>
													<a href="javascript:void(0);" class="text-primary DeSelectAllItems">{{ __('common.deselect_all') }}</a>
												</div>
												<div class="col-md-6 text-end pt-2">
													<button type="button" class="btn btn-primary btn-xs AddToMenu" menu-type="page" menu-id="{{ optional($menu)->id }}">{{ __('common.add_to_menu') }}</button>
												</div>
											</div>
										</div>
									</form>
								</div>
								<div class="accordion__item mb-2 XBlogs {{ $screenOption['Blogs']['visibility'] ? '' : 'd-none' }}">
									<form action="{{ route('menu.admin.ajax_add_page') }}" id="MenuAjaxAddBlogForm" method="post">
										@csrf
										<input type="hidden" name="Menu[id]" class="BlogMenu" id="BlogMenuId" value="{{ optional($menu)->id }}">
										<div class="accordion-header accordion-header--primary collapsed" data-bs-toggle="collapse" data-bs-target="#rounded-blogs">
											<span class="accordion-header-icon"></span>
											<span class="accordion-header-text">{{ __('common.blogs') }}</span>
											<span class="accordion-header-indicator"></span>
										</div>
										<div id="rounded-blogs" class="accordion__body ItemsCheckboxSec default-tab collapse p-3" data-bs-parent="#accordion-menu-child">
											<ul class="nav nav-tabs" role="tablist">
												<li class="nav-item">
													<a class="nav-link active checkboxUtility" data-bs-toggle="tab" href="#view-all-blogs">{{ __('common.view_all') }}</a>
												</li>
												<li class="nav-item">
													<a class="nav-link checkboxUtility" data-bs-toggle="tab" href="#blog-search">{{ __('common.search') }}</a>
												</li>
											</ul>
											<div class="tab-content border-end border-start border-bottom">
												<div class="tab-pane fade active show" id="view-all-blogs" role="tabpanel">
													<div class="p-2">
														{!! $blogs !!}
													</div>
												</div>
												<div class="tab-pane fade" id="blog-search">
													<div class="p-2 form-group">
														<label for="">{{ __('common.search') }}</label>
														<input type="search" class="form-control SearchForMenu" placeholder="{{ __('common.enter_blog_name') }}">
														<input type="hidden" class="search_type" value="blog">
													</div>
													<div class="searchContentDiv"></div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 pt-3 pb-2">
													<a href="javascript:void(0);" class="text-primary SelectAllItems">{{ __('common.select_all') }}</a>
													<span class="text-black mx-1">|</span>
													<a href="javascript:void(0);" class="text-primary DeSelectAllItems">{{ __('common.deselect_all') }}</a>
												</div>
												<div class="col-md-6 text-end pt-2">
													<button type="button" class="btn btn-primary AddToMenu btn-xs" menu-type="blog" menu-id="{{ optional($menu)->id }}">{{ __('common.add_to_menu') }}</button>
												</div>
											</div>
										</div>
									</form>
								</div>
								@include('admin.menus.ctp_menu_options', compact('allCpts'))
								<div class="accordion__item mb-2 XCustomLinks {{ $screenOption['CustomLinks']['visibility'] ? '' : 'd-none' }}">
									<form action="{{ route('menu.admin.ajax_add_link') }}" id="MenuAjaxAddLinkForm" method="post" accept-charset="utf-8">
										@csrf
										<input type="hidden" name="Menu[id]" class="LinkMenu" id="LinkMenuId" value="{{ optional($menu)->id }}">
										<div class="accordion-header collapsed accordion-header-info" data-bs-toggle="collapse" data-bs-target="#rounded-links">
											<span class="accordion-header-icon"></span>
											<span class="accordion-header-text">{{ __('common.links') }}</span>
											<span class="accordion-header-indicator"></span>
										</div>
										<div id="rounded-links" class="collapse accordion__body p-3" data-bs-parent="#accordion-menu-child">
											<div class="form-group row">
												<label class="col-sm-12 col-form-label">{{ __('common.url') }}</label>
												<div class="col-sm-12">
													<input type="url" name="Menu[link]" class="form-control LinkMenu" id="MenuLink">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-12 col-form-label">{{ __('common.link_text') }}</label>
												<div class="col-sm-12">
													<input type="text" name="Menu[linktitle]" class="form-control MenuLinkTitle" id="MenuLinktitle" placeholder="{{ __('common.menu_item') }}">
												</div>
											</div>
											<div class="form-group row">
												<div class="col-md-12 text-end">
													<button type="button" class="btn btn-primary LinksAddToMenu btn-xs" menu-type="custom-link" menu-id="{{ optional($menu)->id }}">{{ __('common.add_to_menu') }}</button>
												</div>
											</div>
										</div>
									</form>
								</div>
								<div class="accordion__item mb-2 XCategories {{ $screenOption['Categories']['visibility'] ? '' : 'd-none' }}">
									<form action="{{ route('menu.admin.ajax_add_page') }}" id="MenuAjaxAddCategoryForm" method="post">
										@csrf
										<input type="hidden" name="Menu[id]" class="CategoryMenu" id="CategoryMenuId" value="{{ optional($menu)->id }}">
										<div class="accordion-header accordion-header--primary collapsed" data-bs-toggle="collapse" data-bs-target="#rounded-categories">
											<span class="accordion-header-icon"></span>
											<span class="accordion-header-text">{{ __('common.categories') }}</span>
											<span class="accordion-header-indicator"></span>
										</div>
										<div id="rounded-categories" class="accordion__body ItemsCheckboxSec default-tab p-3 collapse" data-bs-parent="#accordion-menu-child">
											<ul class="nav nav-tabs" role="tablist">
												<li class="nav-item">
													<a class="nav-link active checkboxUtility" data-bs-toggle="tab" href="#view-all-categories">{{ __('common.view_all') }}</a>
												</li>
												<li class="nav-item">
													<a class="nav-link checkboxUtility" data-bs-toggle="tab" href="#category-search">{{ __('common.search') }}</a>
												</li>
											</ul>
											<div class="tab-content border-end border-start border-bottom">
												<div class="tab-pane fade active show" id="view-all-categories" role="tabpanel">
													<div class="p-2">
														{!! $categories !!}
													</div>
												</div>
												<div class="tab-pane fade" id="category-search">
													<div class="p-2 form-group">
														<label for="">{{ __('common.search') }}</label>
														<input type="search" class="form-control SearchForMenu" placeholder="{{ __('common.enter_category_name') }}">
														<input type="hidden" class="search_type" value="category">
													</div>
													<div class="searchContentDiv"></div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 pt-3 pb-2">
													<a href="javascript:void(0);" class="text-primary SelectAllItems">{{ __('common.select_all') }}</a>
													<span class="text-black mx-1">|</span>
													<a href="javascript:void(0);" class="text-primary DeSelectAllItems">{{ __('common.deselect_all') }}</a>
												</div>
												<div class="col-md-6 text-end pt-2">
													<button type="button" class="btn btn-primary btn-xs AddToMenu" menu-type="category" menu-id="{{ optional($menu)->id }}">{{ __('common.add_to_menu') }}</button>
												</div>
											</div>
										</div>
									</form>
								</div>
								<div class="accordion__item mb-2 XTags {{ $screenOption['Tags']['visibility'] ? '' : 'd-none' }}">
									<form action="{{ route('menu.admin.ajax_add_page') }}" id="MenuAjaxAddTagForm" method="post">
										@csrf
										<input type="hidden" name="Menu[id]" class="TagMenu" id="TagMenuId" value="{{ optional($menu)->id }}">
										<div class="accordion-header accordion-header--primary collapsed" data-bs-toggle="collapse" data-bs-target="#rounded-tags">
											<span class="accordion-header-icon"></span>
											<span class="accordion-header-text">{{ __('common.tags') }}</span>
											<span class="accordion-header-indicator"></span>
										</div>
										<div id="rounded-tags" class="accordion__body ItemsCheckboxSec default-tab p-3 collapse" data-bs-parent="#accordion-menu-child">
											<ul class="nav nav-tabs" role="tablist">
												<li class="nav-item">
													<a class="nav-link active checkboxUtility" data-bs-toggle="tab" href="#view-all-tags">{{ __('common.view_all') }}</a>
												</li>
												<li class="nav-item">
													<a class="nav-link checkboxUtility" data-bs-toggle="tab" href="#tag-search">{{ __('common.search') }}</a>
												</li>
											</ul>
											<div class="tab-content border-end border-start border-bottom">
												<div class="tab-pane fade active show" id="view-all-tags" role="tabpanel">
													<div class="p-2">
														{!! $tags !!}
													</div>
												</div>
												<div class="tab-pane fade" id="tag-search">
													<div class="p-2 form-group">
														<label for="">{{ __('common.search') }}</label>
														<input type="search" class="form-control SearchForMenu" placeholder="{{ __('common.enter_tag_name') }}">
														<input type="hidden" class="search_type" value="tag">
													</div>
													<div class="searchContentDiv"></div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 pt-3 pb-2">
													<a href="javascript:void(0);" class="text-primary SelectAllItems">{{ __('common.select_all') }}</a>
													<span class="text-black mx-1">|</span>
													<a href="javascript:void(0);" class="text-primary DeSelectAllItems">{{ __('common.deselect_all') }}</a>
												</div>
												<div class="col-md-6 text-end pt-2">
													<button type="button" class="btn btn-primary btn-xs AddToMenu" menu-type="tag" menu-id="{{ optional($menu)->id }}">{{ __('common.add_to_menu') }}</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div id="MenuAttributeContainerDisable" class="{{ optional($menu)->id ? '' : 'disable_menu' }}"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-7">
			<div class="row">
				<div class="col-md-12">
					<form action="{{ route('menu.admin.admin_index', optional($menu)->id) }}" class="horizontal-form" id="MenuAdminIndexForm" method="post" accept-charset="utf-8">
						@csrf
						<input type="hidden" name="Menu[id]" id="NewMenuId" value="{{ optional($menu)->id }}">
						<div class="card card-menu-items">
							<div class="card-header bg-primary">
								<h4 class="card-title">{{ __('common.menu_name') }}</h4> 
								<input type="text" name="Menu[title]" class="form-control border" id="MenuTitle" maxlength="255" value="{{ optional($menu)->title }}" required="required">
								<input type="hidden" name="Menu[slug]" id="MenuSlug" value="{{ optional($menu)->slug }}">
								<button type="submit" class="btn btn-success" title="{{ __('common.click_to_save_menu') }}">{{ __('common.save_menu') }}</button>
								@error('Menu.title')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
							<div class="card-body" id="MenuItemContainer">
								<h4>{{ __('common.menu_structure') }}</h4>
								<p>{{ __('common.add_menu_items_from_left_column') }}</p>

						        <div id="accordion-menu-structure" class="accordion accordion-rounded-stylish accordion-bordered">
									<div class="dd menuss" id="NestableMenu">
							            <ol class="dd-list setMenu">

							            	@forelse($menuItems as $value)

								                <li class="dd-item dd3-item xLi_{{ $value->id }}" data-id="{{ $value->id }}">
								                	<input type="hidden" name="MenuItem[{{ $value->id }}][parent_id]" value="{{ $value->parent_id }}" class="parent_id" id="MenuItem{{ $value->id }}ParentId">
								                	<input type="hidden" name="MenuItem[{{ $value->id }}][id]" value="{{ $value->id }}" class="id" id="MenuItem{{ $value->id }}Id">
								                	<input type="hidden" name="MenuItem[{{ $value->id }}][menu_id]" value="{{ $value->menu_id }}" id="MenuItem{{ $value->id }}Id">
								                	<input type="hidden" name="MenuItem[{{ $value->id }}][type]" value="{{ $value->type }}">
								                    <div class="dd-handle dd3-handle rounded-0"></div>
								                    <div class="dd3-content">
														<div class="accordion__item">
															<div class="accordion-header collapsed accordion-header-info" data-bs-toggle="collapse" data-bs-target="#rounded-{{ $value->id }}">
																<span class="accordion-header-icon"></span>
																<span class="accordion-header-text d-flex justify-content-between showLabel_{{ $value->id }}">{{ $value->title }}<span class="text-primary">{{ Str::headline($value->type) }}</span></span>
																<span class="accordion-header-indicator"></span>
															</div>
															<div id="rounded-{{ $value->id }}" class="collapse accordion__body p-3" data-bs-parent="#accordion-menu-structure">
																<div class="row">
																	@if($value->type == 'Link')
																		<div class="col-md-12 form-group">
																			<label for="MenuItem{{ $value->id }}Link">{{ __('common.url') }}</label>
																			<input type="text" name="MenuItem[{{ $value->id }}][link]" class="form-control" id="MenuItem{{ $value->id }}Link" value="{{ $value->link }}">
																		</div>
																	@else
																		<input type="hidden" name="MenuItem[{{ $value->id }}][link]" value="{{ $value->link }}">
																	@endif
																	<div class="col-md-6 form-group">
																		<label for="MenuItem{{ $value->id }}Title">{{ __('common.navigation_label') }}</label>
																		<input type="text" name="MenuItem[{{ $value->id }}][title]" class="form-control itemLabel" id="MenuItem{{ $value->id }}Title" value="{{ $value->title }}" maxlength="255" rel="{{ $value->id }}">
																	</div>
																	<div class="col-md-6 form-group XTitleAttribute {{ $screenOption['TitleAttribute']['visibility'] ? '' : 'd-none' }}">
																		<label for="MenuItem{{ $value->id }}Attribute">{{ __('common.title_attribute') }}</label>
																		<input type="text" name="MenuItem[{{ $value->id }}][attribute]" class="form-control" id="MenuItem{{ $value->id }}Attribute" value="{{ $value->attribute }}" maxlength="200">
																	</div>
																	<div class="col-md-12 form-group XLinkTarget {{ $screenOption['LinkTarget']['visibility'] ? '' : 'd-none' }}">
																		<div class="form-check">
																			<input type="hidden" name="MenuItem[{{ $value->id }}][menu_target]" class="form-check-input" value="0">
																			<input type="checkbox" name="MenuItem[{{ $value->id }}][menu_target]" class="form-check-input" id="MenuItem{{ $value->id }}Target" value="1" {{ $value->target ? 'checked="checked"' : '' }}>
																			<label class="form-check-label" for="MenuItem{{ $value->id }}Target">{{ __('common.open_link_new_tab') }}</label>
																		</div>
																	</div>
																	<div class="col-md-12 form-group XCssClasses {{ $screenOption['CssClasses']['visibility'] ? '' : 'd-none' }}">
																		<label for="MenuItem[{{ $value->id }}]CssClasses">{{ __('common.css_classes') }}</label>
																		<input type="text" name="MenuItem[{{ $value->id }}][css_classes]" class="form-control" id="MenuItem[{{ $value->id }}][CssClasses]" value="{{ $value->css_classes }}">
																	</div>
																	<div class="col-md-12 form-group XDescription {{ $screenOption['Description']['visibility'] ? '' : 'd-none' }}">
																		<label for="MenuItem[{{ $value->id }}]Description">{{ __('common.description') }}</label>
																		<textarea name="MenuItem[{{ $value->id }}][description]" class="form-control" id="MenuItem[{{ $value->id }}][Description]" rows="3">{!! $value->description !!}</textarea>
																	</div>
																	<div class="col-md-12">
																		<a href="javascript:void(0);" class="RemoveItem text-primary" rel="{{ $value->id }}" item-name="{{ $value->title }}">{{ __('common.remove') }}</a>
																		<span class="text-black mx-2">|</span>
																		<a href="javascript:void(0);" rel="{{ $value->id }}" class="CancelItem text-primary"> {{ __('common.cancel') }}</a>
																	</div>
																</div>
															</div>
														</div>
													</div>
									                @if(count($value->child_menu_items))
								            			<ol class="dd-list setMenu">
								            				@include('admin.menus.child_menu_items', ['menuItems' => $value->child_menu_items])
								            			</ol>
								            		@endif
								                </li>
							            	@empty
							            	@endforelse
							            </ol>

							            <hr>
							            
							            <div class="menu-settings">
							            	<h3>{{ __('common.menu_settings') }}</h3>
							            	<div class="row">
							            		<div class="col-md-4">
						            				<label>{{ __('common.display_location') }}</label>
							            		</div>
							            		<div class="col-md-8">
													<div class="form-group">
														@forelse($menusLocations as $key => $value)
															@php
									            				$menu_name = DzHelper::getMenuTitle($menusLocations[$key]['menu']); 
									            			@endphp
															<div class="form-check  text-nowrap mb-2">
																<input type="checkbox" name="MenuLocation[{{ $key }}][menu]" class="form-check-input" id="{{ $key }}" value="{{ optional($menu)->id }}" {{ !empty($menusLocations[$key]['menu']) && ($menusLocations[$key]['menu'] == optional($menu)->id) ? 'checked' : '' }} >
																<label class="form-check-label" for="{{ $key }}">{{ $value['title'] }}{{ !empty($menu_name) && !empty($menusLocations[$key]['menu']) && ($menusLocations[$key]['menu'] != optional($menu)->id) ? '(used in '.$menu_name.')' : '' }}</label>
															</div>
														@empty
														@endforelse
													</div>
							            		</div>
							            	</div>
							            </div>
							        </div>
							    </div>
								<div id="MenuItemContainerDisable" ></div>
							</div>
							<div class="card-footer bg-primary d-flex align-items-center justify-content-between">
								<div class="delete-menu-btn">
									<a href="javascript:void(0)" class="DeleteMenu btn btn-danger btn-sm me-2" rel="{{ optional($menu)->id }}" menu-name="{{ optional($menu)->title }}" title="{{ __('common.click_to_delete_menu') }}">{{ __('common.delete_menu') }}</a>
								</div>
								<button type="submit" class="btn btn-success btn-sm" title="{{ __('common.click_to_save_menu') }}">{{ __('common.save_menu') }}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@push('inline-scripts')
	<script>
		'use strict';
		var admin_menu_index 		= '{{ route('menu.admin.admin_index') }}';
		var search_menus_url 		= '{{ route('menu.admin.search_menus') }}';
		var create_menu_url 		= '{{ route('menu.admin.admin_create') }}';
		var ajax_menu_item_delete 	= '{{ route('menu.admin.ajax_menu_item_delete') }}';
		var admin_menu_destroy 		= '{{ route('menu.admin.admin_destroy') }}';
		var screenOptionArray 		= '{!! json_encode($screenOption) !!}';
	</script>
@endpush

@endsection