@if(!empty($allCpts))
	@foreach($allCpts as $key => $cpt)
		@php
			$blogs = $menuObj->generateCptTreeListCheckbox(0, $key);
		@endphp
		<div class="accordion__item mb-2 X{{ \Str::studly($key) }}">
			<form action="{{ route('menu.admin.ajax_add_page') }}" id="MenuAjaxAddBlogForm" method="post">
				@csrf
				<input type="hidden" name="Menu[id]" class="BlogMenu" id="BlogMenuId" value="{{ optional($menu)->id }}">
				<div class="accordion-header accordion-header--primary collapsed" data-bs-toggle="collapse" data-bs-target="#rounded-{{ $key }}">
					<span class="accordion-header-icon"></span>
					<span class="accordion-header-text">{{ $cpt }}</span>
					<span class="accordion-header-indicator"></span>
				</div>
				<div id="rounded-{{ $key }}" class="accordion__body ItemsCheckboxSec default-tab collapse p-3" data-bs-parent="#accordion-menu-child">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active checkboxUtility" data-bs-toggle="tab" href="#view-all-{{ $key }}">{{ __('View All') }}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link checkboxUtility" data-bs-toggle="tab" href="#blog-search">{{ __('Search') }}</a>
						</li>
					</ul>
					<div class="tab-content border-end border-start border-bottom">
						<div class="tab-pane fade active show" id="view-all-{{ $key }}" role="tabpanel">
							<div class="p-2">
								{!! $blogs !!}
							</div>
						</div>
						<div class="tab-pane fade" id="{{ $key }}-search">
							<div class="p-2 form-group">
								<label for="">{{ __('Search') }}</label>
								<input type="search" class="form-control SearchForMenu" placeholder="{{ __('Enter Blog Name') }}">
								<input type="hidden" class="search_type" value="{{ $key }}">
							</div>
							<div class="searchContentDiv"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 pt-3 pb-2">
							<a href="javascript:void(0);" class="text-primary SelectAllItems">{{ __('Select All') }}</a>
							<span class="text-black mx-1">|</span>
							<a href="javascript:void(0);" class="text-primary DeSelectAllItems">{{ __('Deselect All') }}</a>
						</div>
						<div class="col-md-6 text-end pt-2">
							<button type="button" class="btn btn-primary AddToMenu btn-xs" menu-type="{{ $key }}" menu-id="{{ optional($menu)->id }}">{{ __('Add to Menu') }}</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	@endforeach
@endif