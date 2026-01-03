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
					<span class="accordion-header-text d-flex justify-content-between showLabel_{{ $value->id }}">{{ $value->title }}<span class="text-primary">{{ $value->type }}</span></span>
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
								<input type="checkbox" name="MenuItem[{{ $value->id }}][menu_target]" class="form-check-input" id="MenuItem{{ $value->id }}Target" value="1">
								<label class="form-check-label" for="MenuItem{{ $value->id }}Target">{{ __('common.open_link_new_tab') }}</label>
							</div>
						</div>
						<div class="col-md-12 form-group XCssClasses {{ $screenOption['CssClasses']['visibility'] ? '' : 'd-none' }}">
							<label for="MenuItem[{{ $value->id }}]CssClasses">{{ __('common.css_classes') }}</label>
							<input type="text" name="MenuItem[{{ $value->id }}][css_classes]" class="form-control" id="MenuItem[{{ $value->id }}][CssClasses]">
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