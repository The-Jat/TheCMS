
@php

	$depend_on = '';
	$datafield = '';
	$ajaxdatafield = '';
	if (isset($fieldArray['depend_on'])) {
		
		if (is_array($fieldArray['depend_on']) && !empty($fieldArray['depend_on'])) {
			
			foreach($fieldArray['depend_on'] as $field_name => $field_array)
			{
				$depend_on .= $field_name.'-depend d-none ';
				
				$datafield .= "data-".$field_name."-value =".$field_array['value']." ";
				$datafield .= "data-".$field_name."-operator = ".$field_array['operator']." ";

			}
		}
		else {
			$depend_on = $fieldArray['depend_on'].'-depend d-none';
		}
	}

	if (isset($fieldArray['ajax_container']) && isset($fieldArray['ajax_url'])) {
		$ajaxdatafield .= "data-ajax_container=".$fieldArray['ajax_container']." ";
		$ajaxdatafield .= "data-ajax_url=".$fieldArray['ajax_url']." ";
	}

	$fieldOptions 	= isset($fieldOptions) 		? $fieldOptions 	: array();
	$fieldValue 	= isset($fieldArray['value']) 		? $fieldArray['value'] 		: '';
	$fieldHeading 	= isset($fieldArray['heading']) 		? $fieldArray['heading'] 	: '';
	$placeholder 	= isset($fieldArray['placeholder']) 	? $fieldArray['placeholder'] : '';
	$classes 		= isset($fieldArray['class']) 		? $fieldArray['class'] 		: '';
	$extra_tag 		= isset($fieldArray['extra_tag']) 	? $fieldArray['extra_tag'] 	: '';
	$description 	= isset($fieldArray['description']) 	? $fieldArray['description'] : '';
	$help 			= isset($fieldArray['help']) 		? $fieldArray['help'] 		: '';
	$imgSizes 		= isset($fieldArray['sizes']) 		? $fieldArray['sizes'] 		: '';
	
@endphp


@if($fieldArray['type'] == 'number')
	@php
		$fieldValue = (!empty($elementData) && isset($elementData[$fieldArray['param_name']])) ? $elementData[$fieldArray['param_name']] : $fieldValue;
	@endphp
	<label for="{{ $fieldArray['param_name'] }}" class="control-label">{{ $fieldHeading }}</label>
	@if ($help != '')
	<div class="bootstrap-popover d-inline-block">
		<a href="javascript: void(0);" class="text-primary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="{{ $help }}" title="{{ $fieldHeading }}"><i class="fas fa-question-circle"></i></a>
	</div>
	@endif
	<input name="{{ $fieldArray['param_name'] }}" class="form-control element-depend {{ $classes }}" value="{{ $fieldValue }}" placeholder="{{ $placeholder }}" type="number" id="{{ $fieldArray['param_name'] }}" {{ $extra_tag }}>	

@elseif($fieldArray['type'] == 'textfield')
	@php
		$fieldValue = (!empty($elementData) && isset($elementData[$fieldArray['param_name']])) ? $elementData[$fieldArray['param_name']] : $fieldValue;
	@endphp
	<label for="{{ $fieldArray['param_name'] }}" class="control-label">{{ $fieldHeading }}</label>
	@if ($help != '')
	<div class="bootstrap-popover d-inline-block">
		<a href="javascript: void(0);" class="text-primary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="{{ $help }}" title="{{ $fieldHeading }}"><i class="fas fa-question-circle"></i></a>
	</div>
	@endif
	<input name="{{ $fieldArray['param_name'] }}" class="form-control element-depend {{ $classes }}" value="{{ $fieldValue }}" placeholder="{{ $placeholder }}" type="text" id="{{ $fieldArray['param_name'] }}" {{ $extra_tag }}>								

@elseif($fieldArray['type'] == 'textarea')
	@php
		$fieldValue = (!empty($elementData) && isset($elementData[$fieldArray['param_name']])) ? $elementData[$fieldArray['param_name']] : $fieldValue;	
	@endphp

	<label for="{{ $fieldArray['param_name'] }}" class="control-label">{{ $fieldHeading }}</label>
	@if ($help != '')
	<div class="bootstrap-popover d-inline-block">
		<a href="javascript: void(0);" class="text-primary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="{{ $help }}" title="{{ $fieldHeading }}"><i class="fas fa-question-circle"></i></a>
	</div>
	@endif
	<textarea name="{{ $fieldArray['param_name'] }}" class="form-control {{ $classes }}" placeholder="{{ $placeholder }}" cols="30" rows="6" id="{{ $fieldArray['param_name'] }}" {{ $extra_tag }}>{{ $fieldValue }}</textarea>

@elseif($fieldArray['type'] == 'link')
	@php
		$fieldValue = (!empty($elementData) && isset($elementData[$fieldArray['param_name']])) ? $elementData[$fieldArray['param_name']] : $fieldValue;
	@endphp
	
	<label for="{{ $fieldArray['param_name'] }}" class="control-label">{{ $fieldHeading }}</label>
	@if ($help != '')
	<div class="bootstrap-popover d-inline-block">
		<a href="javascript: void(0);" class="text-primary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="{{ $help }}" title="{{ $fieldHeading }}"><i class="fas fa-question-circle"></i></a>
	</div>
	@endif
	<input name="{{ $fieldArray['param_name'] }}" class="form-control  {{ $classes }}" value="{{ $fieldValue }}" placeholder="{{ $placeholder }}" type="url" id="{{ $fieldArray['param_name'] }}" {{ $extra_tag }}>

@elseif($fieldArray['type'] == 'attach_image')
	@php
		$fieldValue = (!empty($elementData) && isset($elementData[$fieldArray['param_name']])) ? $elementData[$fieldArray['param_name']] : $fieldValue;
	@endphp
	
	@if(!empty($fieldValue) && file_exists(storage_path('app/public/page-images/magic-editor/'.$fieldValue)))
		<div class="RemoveElementImage custom-image-delete">
			<img src="{{ asset('storage/page-images/magic-editor/'.$fieldValue) }}" class="rounded object-fit-cover" height="80">
			<a href="{{ \URL::to('/') }}/admin/magic_editors/remove_image" class="RemoveElementImage delete-btn text-danger" rel="{{ $fieldArray['param_name'].'-hidden' }}" val="{{ $fieldValue }}"><i class="fa fa-times"></i></a>
		</div>
	
	@else
		<img class="mb-2" height="80" src="{{ asset('images/noimage.jpg') }}"  alt="">
	@endif
	<label for="{{ $fieldArray['param_name'] }}" class="control-label">{{ $fieldHeading }}</label>
	@if ($help != '')
	<div class="bootstrap-popover d-inline-block">
		<a href="javascript: void(0);" class="text-primary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="{{ $help }}" title="{{ $fieldHeading }}"><i class="fas fa-question-circle"></i></a>
	</div>
	@endif
	<div >
		<input type="file" name="{{ $fieldArray['param_name'] }}" class="ps-2 form-control {{ $classes }}" placeholder="{{ $placeholder }}" id="{{ $fieldArray['param_name'] }}" {{ $extra_tag }}>
	</div>
	<input type="hidden" name="{{ $fieldArray['param_name'] }}" id="{{ $fieldArray['param_name'] }}-hidden" value="{{ $fieldValue }}">

@elseif($fieldArray['type'] == 'attach_multiple_images')

	@php
		$fieldValue = (!empty($elementData) && isset($elementData[$fieldArray['param_name']])) ? $elementData[$fieldArray['param_name']] : $fieldValue;
	@endphp
	
	@if(!empty($fieldValue))
		@php
			$images = explode(',', $fieldValue);
		@endphp
		<div class="row m-0">
		@foreach ($images as $imgValue)
			@if(file_exists(storage_path('app/public/page-images/magic-editor/'.$imgValue)))
				<div class="px-1 mb-2 col-md-4 col-sm-6 RemoveAttachmentSection custom-image-delete ">
					<img src="{{ asset('storage/page-images/magic-editor/'.$imgValue) }}" class="w-100 rounded object-fit-cover">
					<a href="{{ \URL::to('/') }}/admin/magic_editors/remove_image" class="RemoveElementImage  delete-btn text-danger" rel="{{ $fieldArray['param_name'] }}-hidden" val="{{ $imgValue }}"><i class="fa fa-times"></i></a>
				</div>
			@endif
		@endforeach
		</div>
	
	@else
		<img class="mb-2" src="{{ asset('images/noimage.jpg') }}"  height="80">
	@endif

	<label for="{{ $fieldArray['param_name'] }}" class="control-label d-block">{{ $fieldHeading }}</label>
	<div >
		<input type="file" name="{{ $fieldArray['param_name'] }}[]" class="ps-2 form-control {{ $classes }}" placeholder="{{ $placeholder }}" id="{{ $fieldArray['param_name'] }}" multiple="multiple" {{ $extra_tag }}>
	</div>
	<input type="hidden" name="{{ $fieldArray['param_name'] }}" id="{{ $fieldArray['param_name'] }}-hidden" value="{{ $fieldValue }}">

@elseif($fieldArray['type'] == 'dropdown')
	@php
		$newfieldValue = (!empty($elementData) && isset($elementData[$fieldArray['param_name']])) ? $elementData[$fieldArray['param_name']] : '';
	@endphp
		
	<label for="{{ $fieldArray['param_name'] }}" class="control-label">{{ $fieldHeading }}</label>
	<select name="{{ $fieldArray['param_name'] }}" id="{{ $fieldArray['param_name'] }}" class=" form-control element-depend {{ $classes }}" {{ $ajaxdatafield }} {{ $extra_tag }}>
		<option value="">{{ $fieldHeading }}</option>
		@if(!empty($fieldOptions))
			@foreach($fieldOptions as $dropdownKey => $dropdownVal)
				<option value="{{ $dropdownKey }}" {{ ($newfieldValue == $dropdownKey) ? 'selected="selected"' : '' }}>{{ $dropdownVal }}</option>
			@endforeach
		@endif
	</select>
							
@elseif($fieldArray['type'] == 'dropdown_multi')
	@php
		$newfieldValue = array();
		if(!empty($elementData) && isset($elementData[$fieldArray['param_name']]) && !is_array($elementData[$fieldArray['param_name']])) 
		{
			$newfieldValue =  explode(',', $elementData[$fieldArray['param_name']]);
		}
		else if(!empty($elementData) && isset($elementData[$fieldArray['param_name']]) && is_array($elementData[$fieldArray['param_name']])) {
			$newfieldValue = $elementData[$fieldArray['param_name']];
		}
	@endphp
	<label for="{{ $fieldArray['param_name'] }}" class="control-label">{{ $fieldHeading }}</label>
	<select name="{{ $fieldArray['param_name'] }}[]" id="{{ $fieldArray['param_name'] }}" class="element-depend form-control {{ $classes }}" multiple="multiple" {{ $extra_tag }} {{ $ajaxdatafield }} style="height: 110px;" >
		<option value="">{{ $fieldHeading }}</option>
		@if(!empty($fieldOptions))
			@foreach($fieldOptions as $dropdownKey => $dropdownVal)
				<option value="{{ $dropdownKey }}" {{ (in_array($dropdownKey, $newfieldValue)) ? 'selected="selected"' : '' }}>{{ $dropdownVal }}</option>
			@endforeach
		@endif
	</select>

@elseif($fieldArray['type'] == 'checkbox')
	@php
		$checked = (isset($elementData[$fieldArray['param_name']]) && $elementData[$fieldArray['param_name']] == $fieldValue) ? 'checked="checked"' : '';	
	@endphp
	<div class="form-check checkbox">
		<input name="{{ $fieldArray['param_name'] }}" class="form-check-input element-depend {{ $classes }}" value="{{ $fieldValue }}" type="checkbox" id="{{ $fieldArray['param_name'] }}" {{ $checked }} {{ $extra_tag }}>
		<label for="{{ $fieldArray['param_name'] }}" class="control-label form-check-label">{{ $fieldHeading }}</label>
	</div>

@elseif($fieldArray['type'] == 'checkbox_multi')

	<label class="control-label">{{ $fieldHeading }}</label>
	@php
		$checkboxFields = is_array($fieldOptions) ? $fieldOptions : array();
		$checkboxFieldsVal = (isset($elementData[$fieldArray['param_name']]) && !empty($elementData[$fieldArray['param_name']])) ? explode(',', $elementData[$fieldArray['param_name']]) : array();
	@endphp
	@foreach ($checkboxFields as $checkboxKey => $checkboxValue) 
		@php
			$checked = (in_array($checkboxKey, $checkboxFieldsVal)) ? 'checked="checked"' : '';
		@endphp
		<div class="form-check checkbox">
			<input name="{{ $fieldArray['param_name'] }}[]" class="form-check-input element-depend {{ $classes }}" value="{{ $checkboxKey }}" type="checkbox" id="{{ $checkboxKey }}" {{ $checked }} {{ $extra_tag }}>
			<label class="control-label form-check-label" for="{{ $checkboxKey }}">{{ $checkboxValue }}</label>
		</div>
	@endforeach

@elseif($fieldArray['type'] == 'radio')

	<label class="control-label">{{ $fieldHeading }}</label>
	@php
		$radioFields = is_array($fieldOptions) ? $fieldOptions : array();
		$radioFieldsVal = (isset($elementData[$fieldArray['param_name']]) && !empty($elementData[$fieldArray['param_name']])) ? explode(',', $elementData[$fieldArray['param_name']]) : array();
	@endphp
	@foreach ($radioFields as $radioKey => $radioValue) 
		@php
			$checked = (in_array($radioKey, $radioFieldsVal)) ? 'checked="checked"' : '';
		@endphp
		<div class="radio ">
			<input name="{{ $fieldArray['param_name'] }}" class="form-check-input element-depend {{ $classes }}" value="{{ $radioKey }}" type="radio" id="{{ $fieldArray['param_name'].'_'.$radioKey }}" {{ $checked }} {{ $extra_tag }}>
			<label class="control-label form-check-label" for="{{ $fieldArray['param_name'].'_'.$radioKey }}">{{ $radioValue }}</label>
		</div>
	@endforeach

@elseif($fieldArray['type'] == 'radio_with_img')

	<label class="control-label">{{ $fieldHeading }}</label>
	@php
		$radioFields = is_array($fieldOptions) ? $fieldOptions : array();
		$radioFieldsVal = (isset($elementData[$fieldArray['param_name']]) && !empty($elementData[$fieldArray['param_name']])) ? explode(',', $elementData[$fieldArray['param_name']]) : array();
	@endphp
	@foreach ($radioFields as $radioKey => $radioValue)
		@php
			$checked = (in_array($radioKey, $radioFieldsVal)) ? 'checked="checked"' : '';
		@endphp
		<div class="radio mb-2 {{ $classes }}">
			<input name="{{ $fieldArray['param_name'] }}" value="{{ $radioKey }}" type="radio" id="{{ $fieldArray['param_name'].'_'.$radioKey }}" {{ $checked }} {{ $extra_tag }}>
			<label class="control-label" for="{{ $fieldArray['param_name'].'_'.$radioKey }}">
				<img src="{{ $radioValue }}" class="object-fit-cover" width="auto" height="80">
			</label>
		</div>
	@endforeach

@elseif($fieldArray['type'] == 'autocomplete')

	@php
		$fieldValue = (!empty($elementData) && isset($elementData[$fieldArray['param_name']])) ? $elementData[$fieldArray['param_name']] : $fieldValue;
	@endphp
	<label for="{{ $fieldArray['param_name'] }}" class="control-label">{{ $fieldHeading }}</label>
	<input name="{{ $fieldArray['param_name'] }}" class="form-control {{ $classes }}" value="{{ $fieldValue }}" placeholder="{{ $placeholder }}" type="text" id="{{ $fieldArray['param_name'] }}" {{ $extra_tag }}>

@elseif($fieldArray['type'] == 'textarea_safe')

	@php
		$fieldValue = (!empty($elementData) && isset($elementData[$fieldArray['param_name']])) ? $elementData[$fieldArray['param_name']] : $fieldValue;
	@endphp
	<label for="{{ $fieldArray['param_name'] }}" class="control-label">{{ $fieldHeading }}</label>
	<input name="{{ $fieldArray['param_name'] }}" class="form-control {{ $classes }}" value="{{ $fieldValue }}" placeholder="{{ $placeholder }}" type="text" id="{{ $fieldArray['param_name'] }}" {{ $extra_tag }}>

@elseif($fieldArray['type'] == 'button')

	@php
		$fieldValue = (!empty($elementData) && isset($elementData[$fieldArray['param_name']])) ? $elementData[$fieldArray['param_name']] : $fieldValue;
	@endphp
	<button type="button" class="form-control {{ $classes }}" id="{{ $fieldArray['param_name'] }}">{{ $fieldHeading }}</button>

@elseif($fieldArray['type'] == 'param_group')

	@php
		$fieldValue = (!empty($elementData) && isset($elementData[$fieldArray['param_name']])) ? $elementData[$fieldArray['param_name']] : $fieldValue;
	@endphp
	<button type="button" class="form-control addMoreElementSection mb-2" id="{{ $fieldArray['param_name'] }}">{{ $fieldHeading }}</button>
	
	@include('admin.magic_editor.Elements.admin_param_group_section' , ['params' => $fieldArray['params']])
@endif

@if($description)
	<small>{{ $description }}</small>
@endif