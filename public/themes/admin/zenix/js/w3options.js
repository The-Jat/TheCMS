(function ($) {
    "use strict";

    function addMoreGroupedSection(key=0,thisElement=null) {	
		
		var container = jQuery(thisElement).parent('.W3OptionsGroupedSectionWapper').find('.W3OptionsGroupedSection:first');
		var form = container.clone().appendTo(jQuery(thisElement).closest('.W3OptionsGroupedSectionWapper')).show();

		container.hide();
		form.find("input").val("");
		form.find("textarea").val("");
		form = container.html();

		form = form.replace(/%KEY%/g, key);
		form = form.replace(/data-bsx/g,'data-bs');

		jQuery(thisElement).parent('.W3OptionsGroupedSectionWapper').find('.W3OptionsGroupedSection:last').html(form);
	}

	function addMoreGroupedSectionClick()
	{
		jQuery('.addMoreGroupedSection').on('click', function() {
			var sectionLength = jQuery(this).parent('.W3OptionsGroupedSectionWapper').find('.W3OptionsGroupedSection').length - 1;
			
			addMoreGroupedSection(sectionLength,this);
			jQuery(this).parent('.W3OptionsGroupedSectionWapper').append(this);
		});

		// for first time after page load append btn to last
		jQuery('.addMoreGroupedSection').each(function() {
			var sectionLength = jQuery(this).parent('.W3OptionsGroupedSectionWapper').find('.W3OptionsGroupedSection').length - 1;

			jQuery(this).parent('.W3OptionsGroupedSectionWapper').find('.W3OptionsGroupedSection:first').hide();

			if (sectionLength == 0) {
				addMoreGroupedSection(sectionLength,this);
			}
			jQuery(this).parent('.W3OptionsGroupedSectionWapper').append(this);
		});
	}
		    
	function handleBoxShadow(element){

		var container = $(element).closest('.BoxShadowContainer'); 
        var inset = container.find('.inset-shadow').is(':checked') ? 'inset ' : '';
        var drop = container.find('.drop-shadow').is(':checked') ? 'inset ' : '';

        if (inset == '') {
        	container.find('.inset-shadow-color, .inset-shadow-horizontal, .inset-shadow-vertical, .inset-shadow-blur, .inset-shadow-spread').prop('disabled', true); 
        }else{
        	container.find('.inset-shadow-color, .inset-shadow-horizontal, .inset-shadow-vertical, .inset-shadow-blur, .inset-shadow-spread').prop('disabled', false); 
        }
        if (drop == '') {
        	container.find('.drop-shadow-color, .drop-shadow-horizontal, .drop-shadow-vertical, .drop-shadow-blur, .drop-shadow-spread').prop('disabled', true); 
        }else{
        	container.find('.drop-shadow-color, .drop-shadow-horizontal, .drop-shadow-vertical, .drop-shadow-blur, .drop-shadow-spread').prop('disabled', false); 
        }


        var inset_color = container.find('.inset-shadow-color').val();
        var inset_horizontal = container.find('.inset-shadow-horizontal').val() + 'px';
        container.find('.inset-horizontal-value').html(inset_horizontal);
        var inset_vertical = container.find('.inset-shadow-vertical').val() + 'px';
        container.find('.inset-vertical-value').html(inset_vertical);
        var inset_blur = container.find('.inset-shadow-blur').val() + 'px';
        container.find('.inset-blur-value').html(inset_blur);
        var inset_spread = container.find('.inset-shadow-spread').val() + 'px';
        container.find('.inset-spread-value').html(inset_spread);

        var drop_color = container.find('.drop-shadow-color').val();
        var drop_horizontal = container.find('.drop-shadow-horizontal').val() + 'px';
        container.find('.drop-horizontal-value').html(drop_horizontal);
        var drop_vertical = container.find('.drop-shadow-vertical').val() + 'px';
        container.find('.drop-vertical-value').html(drop_vertical);
        var drop_blur = container.find('.drop-shadow-blur').val() + 'px';
        container.find('.drop-blur-value').html(drop_blur);
        var drop_spread = container.find('.drop-shadow-spread').val() + 'px';
        container.find('.drop-spread-value').html(drop_spread);

        if (inset != '' & drop == '') {
        	var boxShadow = inset_horizontal + ' ' + inset_vertical + ' ' + inset_blur + ' ' + inset_spread + ' ' + inset_color + ' inset';
        }
        else if (drop != '' & inset == '') {
        	var boxShadow = drop_horizontal + ' ' + drop_vertical + ' ' + drop_blur + ' ' + drop_spread + ' ' + drop_color;
        }
        else if (drop != '' & inset != '') {
        	var boxShadow = drop_horizontal + ' ' + drop_vertical + ' ' + drop_blur + ' ' + drop_spread + ' ' + drop_color +' , '+inset_horizontal + ' ' + inset_vertical + ' ' + inset_blur + ' ' + inset_spread + ' ' + inset_color + ' inset';
        }
        else {
        	var boxShadow = 'none';
        }

        
    	container.find('.ShadowBoxPreview').css('transition', 'all 0.2s ease').css('box-shadow', boxShadow);
	}

	function w3OptionsDependField(elementThis) {
		
		var el_id = jQuery(elementThis).data('depend-id');
		var el_name = el_id;
		var el_value =  jQuery(elementThis).val();
		var el_type =  jQuery(elementThis).attr('type');

		/* Fetch AjaxField */
		if (jQuery(elementThis).data('ajax_container') != undefined && jQuery(elementThis).data('ajax_url') != undefined) {
			var ajax_container = jQuery(elementThis).data('ajax_container');
			var ajax_url = jQuery(elementThis).data('ajax_url');	
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
			el_value = $('input[data-depend-id="'+el_name+'"]:checked').map(function(){
						    return $(this).val();
						}).get();
		}
		if (el_type == 'radio') {
			el_value = $('input[data-depend-id="'+el_name+'"]:checked').map(function(){
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
				
				var secondOperator 	=	jQuery(this).data(el_name+'-operator');
				var secondOperent 	=	jQuery(this).data(el_name+'-value');
				secondOperent 	= 	'"'+secondOperent+'"';
					
				if (typeof el_value === 'object' ) {

					depend_el_common_class = jQuery(this);

					$.each(el_value, function(index, value){
						firstOperent = '"'+value+'"';

						var condition = eval(firstOperent + secondOperator + secondOperent);
						
						if(condition)
						{
							jQuery(depend_el_common_class).removeClass("d-none").show();
						}
					});

				}
				else {
					var condition = eval(firstOperent + secondOperator + secondOperent);
					
					if( condition )
					{
						jQuery(this).removeClass("d-none").show();
					}
				}
			});
		}
		return true;
	}

	function removeGroupSection() {
		jQuery(document).on('click','.delete-group', function() {
			jQuery(this).closest('.W3OptionsGroupedSection').remove();
		});
	}

    var W3options = function () {
			
		var handleSlider = function () {
			if (jQuery(".w3options-slider").length > 0) {
				jQuery('.w3options-slider').on('input', function () {
					var val = jQuery(this).val();
					jQuery(this).parent('.form-group').find('span').html(val);
				});
			}
		}

		var handleSorterList = function () {
			if (jQuery(".sorter-list").length > 0) {
				function updateInputs() {
		            $(".sorter-list").each(function() {
		                var fieldName = $(this).data('field-name');

		                $(this).find('li').each(function(index, element) {
		                    var blockKey = $(element).closest('ul').data('id');
		                    var elementKey = $(element).data('id');
		                    var elementVal = $(element).find('input').val();
		                    $(element).find('input').attr('name', fieldName + '[' + blockKey + ']['+elementKey+']').val(elementVal);
		                });
		            });
				}
		        
		        $(".sorter-list").sortable({
		            connectWith: ".sorter-list",
		            update: function(event, ui) {
		                updateInputs();
		            }
		        }).disableSelection();

		        updateInputs();
	        }
        }

		var handleGroupedSection = function () {
			if (jQuery('.W3OptionsGroupedSection').length > 0) {
				// addMoreGroupedSection();
				removeGroupSection();
				addMoreGroupedSectionClick();
			}
		}

		var handleBtnSet = function () {
			if (jQuery('.theme-option-btn-set').length > 0) {
				jQuery('.theme-option-btn-set .btn').on('click', function () {
					jQuery(this).parent('.theme-option-btn-set').find('.btn').removeClass('active');
					jQuery(this).addClass('active');
				});
			}
		}
		
		var handleBtnSetMulti = function () {
			if (jQuery('.theme-option-btn-set-multi').length > 0) {
				jQuery('.theme-option-btn-set-multi .btn').on('click', function () {
					// jQuery(this).parent('.theme-option-btn-set').find('.btn').removeClass('active');
					jQuery(this).toggleClass('active');
				});
			}
		}

		var handleSelectImageContainer = function () {
			if (jQuery('.SelectImageContainer').length > 0) {
				jQuery('.SelectImageContainer select').on('change', function () {
					var img = jQuery(this).val();
					jQuery(this).parents('.SelectImageContainer').find('img').attr('src',img);

				});
			}
		}

		var handleTextEditor = function () {
			if (jQuery('.ThemeOptionsEditor').length > 0) {
				let editorOptions = {
					removePlugins: 'cloudservices, easyimage, exportpdf',
					disallowedContent: 'script; *[on*]',
					extraPlugins: 'uploadimage,image',
					autoParagraph: false,
					enterMode: CKEDITOR.ENTER_BR,
					fillEmptyBlocks: false,
					clipboard_handleImages: false,
					allowedContent: true,
					extraAllowedContent: '*(*)',
					filebrowserUploadUrl: baseUrl + '/ckeditor/uploads?_token=' + csrf_token,
					filebrowserUploadMethod: 'form',
					toolbar: [
						{ items: ['Source', '-', 'Image', 'SelectAll', 'TextColor', 'BGColor', 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'Undo', 'Redo', '-', 'Find', '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-'] },
						{ items: [, 'BidiLtr', 'BidiRtl', 'Link', 'Unlink', 'Table', 'HorizontalRule', 'SpecialChar'] },
						'/',
						{ name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'Blockquote', 'CreateDiv'] },
						{ name: 'colors', items: [] },
					],
				};

				jQuery(".ThemeOptionsEditor").each(function () {
					CKEDITOR.replace($(this).attr('id'), editorOptions);
					if (jQuery('body[data-theme-version="dark"]').length > 0) {
						CKEDITOR.addCss('.cke_editable { background-color: #000; color: #fff }');
					}
				});
			}
		}

		var handleSpinner = function () {
			if (jQuery('.ThemeOptionsSpinner').length > 0) {
				$(".ThemeOptionsSpinner").each(function() {
			    	var spinnerOptions = [];
			    	var min = $(this).data("min");
			    	var max = $(this).data("max");
			    	var step = $(this).data("step");

				    if (typeof(min) != "undefined" && min !== null) {
				    	spinnerOptions['min'] = min;
				    }
				    if (typeof(max) != "undefined" && max !== null) {
				    	spinnerOptions['max'] = max;
				    }
				    if (typeof(step) != "undefined" && step !== null) {
				    	spinnerOptions['step'] = step;
				    }
				    $(this).spinner(spinnerOptions);
				});
		    }
	    }

		var handleShadows = function () {
	        if (jQuery('.inset-shadow,.drop-shadow').length > 0) {

				$(".inset-shadow,.drop-shadow").each(function() {
			    	handleBoxShadow(this);
				});

			    $('.inset-shadow, .inset-shadow-color, .inset-shadow-horizontal, .inset-shadow-vertical, .inset-shadow-blur, .inset-shadow-spread,.drop-shadow, .drop-shadow-color, .drop-shadow-horizontal, .drop-shadow-vertical, .drop-shadow-blur, .drop-shadow-spread').on('change input',function(){
			    	handleBoxShadow(this);
			    });
			}

			/*
			Selector Class : element-depend - w3o-depend
			*/
			jQuery('.w3o-depend').off('keyup change').on('keyup change', function() {
				w3OptionsDependField(this);
			});

			jQuery('.w3o-depend').each(function() {
				var nameAttr = jQuery(this).attr('name');
			    if (nameAttr && nameAttr.indexOf('%KEY%') === -1) {
			        w3OptionsDependField(this);
			    }
			});
		}


		var handleMainMenu = function () {
			if (jQuery('.ThemeOptionsMainMenu').length > 0) {
				
				$('.ThemeOptionsMainMenu .nav-link').on('click', function() {
					jQuery('.nav-link').removeClass('active');
			      	var tabId = $(this).attr('href');
					
				    $('.nav-link[href="' + tabId + '"]').tab('show');
			    });

				jQuery('.ThemeOptionsMainMenu li a').on('click', function () {

					if (!jQuery(this).closest('.ThemeOptionsMainMenu > .nav-item').hasClass('active-section')) {
						jQuery('.ThemeOptionsSubMenu').slideUp();
					}
					jQuery('.nav-item').removeClass('active-section');
					jQuery(this).closest('.ThemeOptionsMainMenu > .nav-item').addClass('active-section');
					jQuery(this).closest('.nav-item.has-subsection').find('.ThemeOptionsSubMenu').slideDown();
					jQuery(this).closest('.nav-item.has-subsection').find('> a').addClass('active');
					
				});
			}
		}
		

		return {
            init: function () {
                handleSlider();
				handleSorterList();
				handleGroupedSection();
				handleBtnSet();
				handleBtnSetMulti();
				handleSelectImageContainer();
				handleTextEditor();
				handleSpinner();
				handleShadows();
				handleMainMenu();
            }
        }
	}();

    /* Document.ready Start */
    jQuery(document).ready(function () {
        W3options.init();
        
        jQuery(document).ajaxComplete(function () {
			W3options.init();
		});
    });

})(jQuery);
