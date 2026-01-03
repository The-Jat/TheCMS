<div class="modal-header d-block elements-header">
	<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	<h4 class="modal-title mb-2">{{ $element['name'] }}</h4>
	@if (!empty($elementTabs))
	<div class="default-tab">
		<ul class="nav nav-tabs" role="tablist">
	    	@foreach($elementTabs as $key => $elementTabsVal)
	        	<li class="nav-item">
	        		<a href="#{{ str_replace(' ', '', ucwords($elementTabsVal)) }}" class="ME-Tabs nav-link {{ ($key == 0) ? 'active' : '' }}" data-bs-toggle="tab" >{{ $elementTabsVal }}</a>
	        	</li>
	        @endforeach
	    </ul>
	</div>
	@endif
</div>
<form action="{{ route('update.element.me') }}" class="horizontal-form ElementSettingForm" novalidate="novalidate" id="BlogAdminAddSectionForm" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	@csrf
	<input type="hidden" name="element_id" id="element_id"  value="{{ $element['base'] }}">
	<input type="hidden" name="element_index" value="{{ $element_index }}" class="element_index">
	<div class="modal-body">
		<div class="tab-content">

			@foreach($elementTabs as $key => $elementTabsVal)
			<div class="tab-pane fade {{ ($key == 0) ? 'show active' : '' }}" id="{{ str_replace(' ', '', ucwords($elementTabsVal)) }}"  role="tabpanel" >  
				<div class="row">
					@foreach ($element['params'] as $value)
						@if(!empty($value['group']) && $elementTabsVal == $value['group'])
							@php
								$depend_on = '';
								$datafield = '';

								if(isset($value['depend_on'])) 
								{
									if (is_array($value['depend_on']) && !empty($value['depend_on']))
									{
										foreach($value['depend_on'] as $field_name => $field_array)
										{
											$depend_on .= $field_name.'-depend d-none ';
											if (!is_array($field_array['value'])) {
												$datafield .= "data-".$field_name."-value =".$field_array['value']." ";
											}else{
												$datafield .= "data-".$field_name."-value =".(implode(',', $field_array['value']))." ";
											}
											$datafield .= "data-".$field_name."-operator = ".$field_array['operator']." ";
										}
									}
									else {
										$depend_on = $value['depend_on'].'-depend d-none ';
									}
								}

								$fieldDescription 	= isset($value['desc']) 		? $value['desc'] 	: '';

								if (!empty($value['id']) && isset($elementData[$value['id']])) {
									$value['old_field_value'] = $elementData[$value['id']];
								}


							@endphp
							
							<div class="col-md-12 {{ $depend_on }}" {{ $datafield }}>
								<div class="form-group">
									<label class="d-block">{{ $value['title'] ?? '' }}</label>
									{!! ThemeOption::CreateField($value,'magic-editor') !!}
								@if($fieldDescription)
									<small class="d-block mt-2">{{ DzHelper::admin_lang($fieldDescription) }}</small>
								@endif
								</div>
							</div>
						
						@endif
					@endforeach
				</div>
			</div>
			@endforeach
		</div>  
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ __('Close') }}</button>
		<button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
	</div>
</form>

<script>
jQuery(document).ready(function(){
	'use strict';
	saveElementSettings();	
	elementDependencyAjax();
	meTabs();
	depend_element();
	addMoreSectionClick();
	removeImageSection();
});
$(document).ajaxComplete(function(){
	'use strict';
	depend_element();
});

</script>