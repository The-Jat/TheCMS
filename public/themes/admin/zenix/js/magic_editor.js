var serializedelementData = "";

function removeEditorElement(){
		
	jQuery('.ME-DeleteElement').unbind().on('click',function(){
		var elementId = jQuery(this).attr('elementid');
		var elementItem = jQuery(this).parents('.me-element-item');
		var elementItemIndex = jQuery(this).index('.ME-DeleteElement');

		updateShortCode(elementItemIndex);
		elementItem.remove();
		addRemoveAddElementBtn();
	});
}


function addRemoveAddElementBtn(){
	/* Calculate if any element is added then remove add element button or add it */
	setTimeout(function(){
		if(jQuery('.me-element-item').length > 0){
			jQuery('.me-add-element-btn').hide();
		}else{
			jQuery('.me-add-element-btn').show();
		}	
	}, 500);
}


function objectifyForm(formArray) {
    //serialize data function
    var returnArray = {};
    var res = '[';
    for (var i = 0; i < formArray.length; i++){
    	var comma = (formArray.length == i+1) ? ' ' : ', ';
    	if(formArray[i]['name'] == 'element_id')
    	{
    		res += formArray[i]['value']+' ';
    	}
    	else
    	{
	        res += formArray[i]['name'] +'='+ formArray[i]['value']+comma;
    	}
    }
    res += ']';
    return res;
}

const escapeHtml = unsafe => {
  return unsafe
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#039;");
};

function getSubShortCode(elementData) {
	var res = i = '';
	$.each(elementData, function(k, v) {
		var elementDataCount = Object.keys(elementData).length - 1;
	    var comma = (elementDataCount == i) ? '"' : '",';
	    if(v)
	    {
		    res += '"'+k+'":"'+ encodeURIComponent(v)+comma;
		    i++;
	    	
	    }
	});

	res = res.replace(/^,|,$/g,'');

	return '{'+res+'}';
}

function getShortCode(elementData){
	var codeSeprator1 = '<%ME-EL%>';
	var res = '';
	var i = 0;
	$.each(elementData, function(k, v) {
		var elementDataCount = Object.keys(elementData).length - 1;
	    var comma = (elementDataCount == i) ? '"' : '"'+codeSeprator1;
    	if(k == 'element_id')
    	{
    		res += v+codeSeprator1;
    	}
    	// else if(k == 'grouped')
    	else if(Array.isArray(v) && typeof v[0] === 'object')
    	{
    		var y = 0;
    		$.each(v, function(key, val) {
    			var groupedDataCount = Object.keys(v).length - 1;
	    		var groupedComma = (groupedDataCount == y) ? comma : '"'+codeSeprator1;
	        	res += k +'="'+ getSubShortCode(val)+groupedComma;
	        	y++;
	        });
    	}
    	else
    	{
    		if(v != '')
    		{
		        res += k +'="'+ encodeURIComponent(v)+comma;
    		}
    	}
    	i++;
	});

    return '['+res+']';

}


function saveElementSettings(){
	
	jQuery('#BlogAdminAddSectionForm').unbind().on('submit',function(e){
		e.preventDefault();
		var elementData = new FormData(this);
		var element_index = elementData.get('element_index');
		
		$.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			data: elementData,
			dataType: 'json',
			contentType: false,
		    cache: false,
		    processData:false,
			success:function(data)
			{
				jQuery('.Me-EditElement:eq('+element_index+')').attr('element-form-data', data.data);
				var data = JSON.parse(data.data);
				/* remove csrf token */
				delete data._token;
				
				data = getShortCode(data);

				updateShortCode(element_index, data);
				jQuery('#AjaxModalBoxMd').modal('hide');
			}
		});

	});
}

function getEditorValue(key) {
	var decodedContent = $('<textarea/>').html(CKEDITOR.instances[key].getData()).val();
	return decodedContent;
}

function setEditorValue(key, value='') {
	return CKEDITOR.instances[key].setData(value);
}

function updateShortCode(elementIndex, newElementData = '') {

	var codeSeprator = '<%ME%>';
	var editorId = 'PageContent';

	var elementData = getEditorValue(editorId).split(codeSeprator);
	elementData = elementData.filter(function (el, index) {
	    return el != null && el != "";
	}).map(function (el, index) {
	    return el;
	});
	
	if(newElementData != '' && newElementData != null)
	{
		elementData.splice(elementIndex, 1, newElementData);
	}
	else
	{
		elementData.splice(elementIndex, 1);
	}
	
	elementData = elementData.join(codeSeprator);
	setEditorValue(editorId, elementData);
}

function elementDependencyAjax() {
	jQuery('.ME-UpdateAjax').unbind().on("change", function(){
		event.preventDefault();

		var fieldVal = jQuery(this).val();
		var actionURL = jQuery(this).attr('me-link');
		var UpdateContainer = null;
		
		if(jQuery(this).is('[me-result-box]')) {
			UpdateContainer = jQuery(this).attr('me-result-box');
		}
		
		jQuery.ajax({
			type: 'POST',
			url: actionURL,
			data: {'data': fieldVal},
			success : function(data)
			{
				if(UpdateContainer != null)
				{
					jQuery('#'+UpdateContainer).html(data);
					elementDependencyAjax();
				}
				
			},
			error : function(data)
			{
				alert('Sorry! There is some problem. please check function calling.')
			}
		});
	});
}

function meTabs() {
	jQuery('.ME-Tabs').on('click', function () {
		var rel = jQuery(this).attr('rel');
		jQuery('.ME-TabsContent').hide();
		jQuery('#'+rel).show();
	});
}

function depend_element() {

	jQuery('.element-depend').off('keyup change').on('keyup change', function() {
		
		var element_id = jQuery('#element_id').val();
		var el_name = jQuery(this).attr('name');
		var el_value =  jQuery(this).val();
		var el_type =  jQuery(this).attr('type');

		/* Fetch AjaxField */
		if (jQuery(this).data('ajax_container') != undefined && jQuery(this).data('ajax_url') != undefined) {
			var ajax_container = jQuery(this).data('ajax_container');
			var ajax_url = jQuery(this).data('ajax_url');	
			var param_name = ajax_container.replace('Container', '');
			
			jQuery.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: 'Post',
				url: ajax_url,
				data: {	
						'element_id' : element_id,	
						'content': el_value, 
						'param_name': param_name,
						'elementData' : serializedelementData
						},
				success : function(data)
				{
					
					if(jQuery('#'+ajax_container).length > 0)
					{
						jQuery('#'+ajax_container).html(data);	
					}
				}
			});
		}	
		/* End Fetch AjaxField */

		if (el_type == 'checkbox') {
			el_value = $('input[name="'+el_name+'"]:checked').map(function(){
						    return $(this).val();
						}).get();
		}
		if (el_name.indexOf('[]') !== -1) {
			el_name = el_name.replace('[]', '');
		}
		var depend_el_common_class = el_name+'-depend';

		/* Hide */
		jQuery('.'+depend_el_common_class).hide();
		/* Hide end*/
		if(el_value == ""){
			return false;
		}
		
		if(jQuery('.'+depend_el_common_class).data(el_name+'-value') == undefined )
		{
			jQuery('.'+depend_el_common_class).hide();
			jQuery('.'+depend_el_common_class).removeClass("d-none").show();
		}
		else
		{
			
			
			var firstOperent = typeof(el_value) == 'string' ? '"'+el_value+'"' : el_value;	
			
			jQuery('.'+depend_el_common_class).each(function(e){
				
				secondOperator 	=	jQuery(this).data(el_name+'-operator');
				secondOperent 	=	jQuery(this).data(el_name+'-value');
				secondOperent 	= 	'"'+secondOperent+'"';
					
				if (typeof el_value === 'object' ) {

					depend_el_common_class = jQuery(this);

					$.each(el_value, function(index, value){
						firstOperent = '"'+value+'"';
						if( eval(firstOperent + secondOperator + secondOperent) )
						{
							jQuery(depend_el_common_class).removeClass("d-none").show();
						}
					});

				}
				else {
					if( eval(firstOperent + secondOperator + secondOperent) )
					{
						jQuery(this).removeClass("d-none").show();
					}
				}
			});
		}
		return true;
	});
}


function addMoreSection(key=0) {
	
	var form = jQuery('.CustomizeSection:first').clone().appendTo('#CustomizeSectionWapper').show();
		
	form.find("input").val("");
	form.find("textarea").val("");
	jQuery('.CustomizeSection:first').hide();
	form = jQuery('.CustomizeSection:first').html();
	form = form.replace(/%KEY%/g, key);
	form = form.replace(/data-bsx/g,'data-bs');
	jQuery('.CustomizeSection:last').html(form);
}

function addMoreSectionClick()
{
	jQuery('.addMoreElementSection').on('click', function() {
		var sectionLength = jQuery('.CustomizeSection').length - 1;
		addMoreSection(sectionLength);
		removeParamGroupSection();
	});
}

function removeParamGroupSection() {
	jQuery('.ParamGroupSection i.fa-close').on('click', function() {
		jQuery(this).closest('.ParamGroupSection').remove();
	});
}

function removeImageSection() {
	jQuery('a.RemoveElementImage').on('click', function() {

		event.preventDefault();
		var thisObj 		= jQuery(this);
		var rel 			= thisObj.attr('rel');
		var imageName 		= thisObj.attr('val');
		var allImagesName 	= jQuery("#"+rel).val();

		jQuery.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: 'POST',
			url: jQuery(this).attr('href'),
			data: {'imageName': imageName, 'allImagesName': allImagesName},
			dataType: 'json',
			success : function(data)
			{
				if(data.status)
				{
					jQuery("#"+rel).val(data.result);
					thisObj.parent().remove();
				}
				else
				{
					alert('Sorry! There is some problem. please check function calling.');
				}
				
			},
			error : function(data)
			{
				alert('Sorry! There is some problem. please check function calling.')
			}
		});

		jQuery(this).parent().remove();
	});
}

(function($) { 
    "use strict";
	var codeSeprator = '<%ME%>';
	var codeSeprator1 = '<%ME-EL%>';
	var editorId = 'PageContent';

	removeEditorElement();
	/* Magic Editor Work */
	jQuery('#UseMagicEditor').on('click', function () {
		var useEditor = jQuery(this).attr('use_editor');
		if(useEditor == 'true'){
			jQuery(".MagicEditorBox").addClass('d-none');
			jQuery(".ClassicEditorBox").removeClass('d-none');
			jQuery(this).html('<i class="fa fa-list"></i> Use Magic Editor').addClass('btn-primary').removeClass('light btn-dark');
			jQuery(this).attr('use_editor', false);
		}else{
			jQuery(".ClassicEditorBox").addClass('d-none');
			jQuery(".MagicEditorBox").removeClass('d-none');
			jQuery(this).html('<i class="fa fa-list"></i> Use System Editor').addClass('light btn-dark').removeClass('light btn-primary');
			jQuery(this).attr('use_editor', true);
		}
	});
	
	let clicked = false;
	jQuery(document).on('click','.ME-AddElement',function(){

		var $this = jQuery(this);
    if (clicked || $this.hasClass('disabled')) return;
    clicked = true;
    $this.addClass('disabled');

		var elementId 		= jQuery(this).data('element');
		var elementType 	= jQuery(this).data('element-type');
		var elementImage 	= jQuery(this).data('element-image');
		var elementName 	= jQuery(this).data('element-name');
		var oldElementId 	= getEditorValue(editorId);
		 
			
		/* Get Element Data by ajax by the use of elementId */
		var elementDefaultData	= (oldElementId != '') ? codeSeprator+'['+elementId+']' : '['+elementId+']';
		
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: baseUrl+'/admin/magic_editors/add-element',
			type: 'POST',
			data: {'elementId': elementId,'elementType': elementType, 'elementImage': elementImage, 'elementName': elementName, 'oldElementId': oldElementId},
			dataType: 'html',
			success:function(data)
			{

				jQuery('#MagicEditorElementContainer').append(data);
				setEditorValue(editorId, oldElementId + elementDefaultData);

				jQuery('#AddElement').on('hidden.bs.modal', function () {
            clicked = false;
            $this.removeClass('disabled');
            jQuery('#AddElement').off('hidden.bs.modal');
        });

				jQuery('#AddElement').modal('hide');
				addRemoveAddElementBtn();
				removeEditorElement();
				
			},
			complete:function(data)
			{
    		clicked = false;
			}
		});	
		/* Get Element Data by ajax by the use of elementId End */
	});

	
	jQuery(document).on('click', '.Me-EditElement', function() {

		var elementType = jQuery(this).data('element-type');
		
		if (elementType == 'widgets') {
			var url= baseUrl+'/admin/magic_editors/edit-section?type=widgets';
		}else{
			var url= baseUrl+'/admin/magic_editors/edit-section';
		}

		var elementId = jQuery(this).attr('elementId');
		var elementData = jQuery(this).attr('element-form-data');
		var serialized = serializedelementData  = elementData ? JSON.parse(elementData) : '';
		var element_index = jQuery(this).index('.Me-EditElement');

		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: url,
			type: 'POST',
			data: {'elementId': elementId, 'elementData': serialized, 'element_index': element_index},
			dataType: 'html',
			success:function(data)
			{
				jQuery('#AjaxResultContainerMd').html(data);
				jQuery('#AjaxModalBoxMd').modal('show');
				addRemoveAddElementBtn();
				removeEditorElement();
			}
		});

	});

	jQuery(document).on('click', '.ME-ElementFilter', function() {
		jQuery('ul.nav-tabs li').removeClass('active');
		jQuery(this).parent('li').addClass('active');
		var filter_key = jQuery(this).data('element-filter');
		jQuery(".ME-ElementList li").removeClass('ME-Show');
		if(filter_key == 'all')
		{
			jQuery(".ME-ElementList li").addClass('ME-Show');
		} 
		else
		{
			jQuery("."+filter_key).addClass('ME-Show');
		}
	});

	jQuery(document).on('click', '.ME-ElementFormTabFilter', function() {
		jQuery('ul.nav-tabs li').removeClass('active');
		jQuery(this).parent('li').addClass('active');
		var filter_key = jQuery(this).data('element-filter');
		jQuery(".ME-ElementFormTabSection").removeClass('ME-Show');
		jQuery("."+filter_key).addClass('ME-Show');
	});

	jQuery(document).on('click', '.ME-ElementFormTabFilter', function() {
		jQuery('ul.nav-tabs li').removeClass('active');
		jQuery(this).parent('li').addClass('active');
		var filter_key = jQuery(this).data('element-filter');
		jQuery(".ME-ElementFormTabSection").removeClass('ME-Show');
		jQuery("."+filter_key).addClass('ME-Show');
	});

	jQuery("a[data-bs-toggle|='modal'], button[data-bs-toggle|='modal']").on('click',function(e){
		e.preventDefault();

		var url 		  = jQuery(this).attr('href');
		var target 		  = jQuery(this).data('bs-target');

		if(target != 'undefined' && target != '' && url != '' && url != '#' && url != 'undefined'){
			$.get(url, function(data) {
		        $(target).modal('show');
		        jQuery(target).find('.modal-content').html(data);
		    });
		}
	});

	jQuery(document).on('change', ".ContentType", function(e){
		e.preventDefault();
		var val = jQuery(this).val();
	});
	
})(jQuery);


/* Magic Editor Work End */