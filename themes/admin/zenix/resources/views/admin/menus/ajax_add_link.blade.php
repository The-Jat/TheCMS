<li class="dd-item dd3-item xLi_{{ $menuItem->id }}" data-id="{{ $menuItem->id }}">
	<input type="hidden" name="MenuItem[{{ $menuItem->id }}][parent_id]" value="{{ $menuItem->parent_id }}" class="parent_id" id="MenuItem{{ $menuItem->id }}ParentId">
	<input type="hidden" name="MenuItem[{{ $menuItem->id }}][id]" value="{{ $menuItem->id }}" class="id" id="MenuItem{{ $menuItem->id }}Id">
	<input type="hidden" name="MenuItem[{{ $menuItem->id }}][menu_id]" value="{{ $menuItem->menu_id }}" id="MenuItem{{ $menuItem->id }}Id">
    <input type="hidden" name="MenuItem[{{ $menuItem->id }}][type]" value="{{ $menuItem->type }}">
    <div class="dd-handle dd3-handle"></div>
    <div class="dd3-content">
		<div class="accordion__item">
			<div class="accordion-header collapsed accordion-header-info" data-bs-toggle="collapse" data-bs-target="#rounded-{{ $menuItem->id }}">
				<span class="accordion-header-icon"></span>
				<span class="accordion-header-text d-flex justify-content-between">{{ $menuItem->title }} <span class="text-primary">{{ $menuItem->type }}</span></span>
				<span class="accordion-header-indicator"></span>
			</div>
			<div id="rounded-{{ $menuItem->id }}" class="collapse accordion__body p-3" data-bs-parent="#accordion-menu-structure">
				<div class="row">
					@if($menuItem->type == 'Link')
						<div class="col-md-12 form-group">
							<label for="MenuItem{{ $menuItem->id }}Link">{{ __('common.url') }}</label>
							<input type="text" name="MenuItem[{{ $menuItem->id }}][link]" class="form-control" id="MenuItem{{ $menuItem->id }}Link" value="{{ $menuItem->link }}">
						</div>
					@endif
					<div class="col-md-6 form-group">
						<label for="MenuItem{{ $menuItem->id }}Title">{{ __('common.navigation_label') }}</label>
						<input type="text" name="MenuItem[{{ $menuItem->id }}][title]" class="form-control" id="MenuItem{{ $menuItem->id }}Title" value="{{ $menuItem->title }}" maxlength="255" rel="{{ $menuItem->id }}">
					</div>
					<div class="col-md-6 form-group">
						<label for="MenuItem{{ $menuItem->id }}Attribute">{{ __('common.title_attribute') }}</label>
						<input type="text" name="MenuItem[{{ $menuItem->id }}][attribute]" class="form-control" id="MenuItem{{ $menuItem->id }}Attribute" value="{{ $menuItem->attribute }}" maxlength="200">
					</div>
					<div class="col-md-12 form-group XLinkTarget" {{ $screenOption['LinkTarget']['visibility'] ? '' : 'd-none' }}>
						<div class="form-check">
							<input type="hidden" name="MenuItem[{{ $menuItem->id }}][menu_target]" class="form-check-input" value="0">
							<input type="checkbox" name="MenuItem[{{ $menuItem->id }}][menu_target]" class="form-check-input" id="MenuItem{{ $menuItem->id }}Target" value="1" {{ $menuItem->target ? 'checked="checked"' : '' }}>
							<label class="form-check-label" for="MenuItem{{ $menuItem->id }}Target">{{ __('common.open_link_new_tab') }}</label>
						</div>
					</div>
					<div class="col-md-12 form-group XCssClasses" {{ $screenOption['CssClasses']['visibility'] ? '' : 'd-none' }}>
						<label for="MenuItem[{{ $menuItem->id }}]CssClasses">{{ __('common.css_classes') }}</label>
						<input type="text" name="MenuItem[{{ $menuItem->id }}][css_classes]" class="form-control" id="MenuItem[{{ $menuItem->id }}][CssClasses]" value="{{ $menuItem->css_classes }}">
					</div>
					<div class="col-md-12 form-group XDescription" {{ $screenOption['Description']['visibility'] ? '' : 'd-none' }}>
						<label for="MenuItem[{{ $menuItem->id }}]Description">{{ __('common.description') }}</label>
						<textarea name="MenuItem[{{ $menuItem->id }}][description]" class="form-control" id="MenuItem[{{ $menuItem->id }}][Description]" rows="3">{!! $menuItem->description !!}</textarea>
					</div>
					@if($menuItem->type == 'Page')
						<div class="col-md-12 form-group">
							<input type="hidden" name="MenuItem[{{ $menuItem->id }}][link]" value="{{ $menuItem->link }}">
							<div>
								<label>{{ __('common.original') }}: </label>
								<a href="{{ $menuItem->link }}">{{ ucfirst($menuItem->title) }}</a>
							</div>
						</div>
					@endif
					<div class="col-md-12">
						<a href="javascript:void(0);" class="RemoveItem text-primary" rel="{{ $menuItem->id }}" item-name="{{ ucfirst($menuItem->title) }}">{{ __('common.remove') }}</a>
						<span class="text-black mx-2">|</span>
						<a href="javascript:void(0);" rel="{{ $menuItem->id }}" class="CancelItem text-primary">{{ __('common.cancel') }}</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>
