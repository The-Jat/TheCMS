(function($) {
	
	"use strict";

	/* Created by Khelesh Mehra 29 Dec 2014*/

	/* Menu Function */
		createMenu();
	/* Menu Function */

	/* Select all and select none function */
		selectAll();
	/* Select all and select none function */

	/*-------*/
	checkboxUtility();
	/*-------*/

	/* Pages add to menu and remove */
		AddToMenu();
		pagesAddToMenu();
		addLinkToMenu();
		itemLabel();
		removeMenuObject();
		cancelMenuObject();
		deleteMenu();
	/* Pages add to menu and remove */

	/* Pages searching */
		SearchForMenu();
	/* Pages searching */


	/* checkbox Utility */
	checkboxUtility();
	/* checkbox Utility */

	/* Allow Block */
		allowBlock();
	/* Allow Block */

	/* Screen Option */
		setScreenOption();
	/* Screen Option */

	function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

	function createMenu()
	{
		jQuery('.CancelCreateMenu').addClass('d-none');
		jQuery('#MenuCreateMessageContainer').hide('slow');
		jQuery('#CreateMenu').on('click', function(){
			jQuery("#MenuSelect option").prop("selected", false)
			jQuery('#MenuTitle').val('');
			jQuery('#NewMenuId').val('');
			jQuery('#MenuItemContainer').empty();
			jQuery('#MenuAdminIndexForm').attr('action', create_menu_url);
			jQuery('#MenuItemContainerDisable').addClass('disable_menu');
			jQuery('#MenuAttributeContainerDisable').addClass('disable_menu');
			jQuery('#MenuCreateMessageContainer').show();
			jQuery('#CreateMenu').hide('slow');
			jQuery('.CancelCreateMenu').removeClass('d-none');
			
		});
	}


	function selectAll()
	{
		jQuery('.SelectAllItems').on('click', function(){
			jQuery(this).parents('.ItemsCheckboxSec').find('input[type="checkbox"]').prop( "checked", true );		
		});
		jQuery('.DeSelectAllItems').on('click', function(){
			jQuery(this).parents('.ItemsCheckboxSec').find('input[type="checkbox"]').prop( "checked", false );		
		});

	}


	function checkboxUtility()
	{
	    jQuery(document).on('click', '.checkboxUtility', function(){
	        jQuery(this).parents('.default-tab').find('input[type="checkbox"]').prop( "checked", false );
		});
	}


	function pagesAddToMenu()
	{
		
		jQuery(document).on('click', '.PagesAddToMenu', function() {
			var olSize = jQuery('.dd ol').length;
			var PageMenuId = jQuery('.PageMenu').val();
			PageMenuId 	   = parseInt(PageMenuId, 10) ;
			var error = 1;
		
			jQuery('.CheckboxViewAll').each(function() {
				if (jQuery(this).prop('checked') == true)
				{
					error = 0;
					return false;
				}
				else
				{
					error = 1;
				}
			});
			
			if(error == 1) 
			{
				error = 'Please select page.';
			}
			if((PageMenuId < 1) || (PageMenuId == '')) 
			{ 
				error = 'Please Select Menu.';
			}
			
			if(error == 0)
			{
				var formData = jQuery(this).closest("form").serialize();
				var actionUrl = jQuery(this).closest("form").attr('action');
				jQuery.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					url : actionUrl,
					data: formData,
					type: 'POST',
					success:function(data)
					{
						if(olSize == 0)
						{
							var result = '<ol class="dd-list setMenu"></ol>';
							jQuery('.menuss').append(data);
						}
					
						jQuery('#MenuItemContainer').css("background-color","#FFFF99");
						setTimeout(function(){
							jQuery('.setMenu').first().append(data);
							jQuery('#MenuItemContainer').removeAttr('style');
						}, 500);
						
						
					}	
				});
			}
			else
			{
				alert(error);
			}
		});
		
	}

	function addLinkToMenu()
	{
		
		jQuery(document).on('click', '.LinksAddToMenu', function(){
			var olSize = jQuery('.dd ol').length;
			var LinkMenuId = jQuery('.LinkMenu').val();
			var MenuLinkUrl = jQuery('.MenuLinkUrl').val();
			var MenuLinkTitle = jQuery('.MenuLinkTitle').val();
			var error = '';
			if((jQuery.trim(MenuLinkUrl) == "") && (jQuery.trim(MenuLinkTitle) == "")) 
			{ 
				error = 'Please fill these fields.';
			}
			else if((jQuery.trim(LinkMenuId) == "")) 
			{ 
				error = 'Please fill these fields.'; 
			}
			
			if(error == '')
			{
				var formData = jQuery(this).closest("form").serialize();
				var actionUrl = jQuery(this).closest("form").attr('action');
				jQuery.ajax({
					url : actionUrl,
					data: formData,
					type: 'POST',
					success:function(data)
					{
						if(olSize == 0)
						{
							var result = '<ol class="dd-list setMenu"></ol>';
							jQuery('.menuss').append(data);
						}
						
						jQuery('#MenuItemContainer').css("background-color","yellow");
						setTimeout(function(){
							jQuery('.setMenu').first().append(data);
							jQuery('#MenuItemContainer').removeAttr('style');
							itemLabel();
							cancelMenuObject();
						}, 500);
						
					}	
				});
			}
			else
			{
				alert(error);
			}
		});
	}


	function itemLabel()
	{
		jQuery(document).on('keyup', '.itemLabel', function() {
			var label = jQuery(this).val();	
			var rel = jQuery(this).attr('rel');	
			jQuery('.showLabel_'+rel).text(label);				  
		});
	}

	function removeMenuObject()
	{	
		jQuery(document).on('click', '.RemoveItem', function() {

			var itemId 		=  jQuery(this).attr('rel');
			var item_name 	=  jQuery(this).attr('item-name');

			if(!confirm("Are you sure you want to delete item "+item_name+"?"))
			{
				return false;
			}

			if(itemId != "" && typeof ajax_menu_item_delete != 'undefined')
			{
				var url = ajax_menu_item_delete;

				jQuery.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					url: url,
					type: 'POST',
					data: {'item_id': itemId},
					success:function(data)
					{
						if(data.status == false)
						{
							alert(data.msg);
							return false;
						}
						
						var child = jQuery('.xLi_'+itemId+' ol').children().first();
						jQuery('.xLi_'+itemId+' .dd3-content').css("background-color","red");
						jQuery('.xLi_'+itemId).before(child);
						jQuery('.xLi_'+itemId).fadeOut('slow', function(){
							jQuery(this).remove();	
						});
					}
				});
			}
		});	
	}

	function deleteMenu()
	{	
		jQuery(document).on('click', '.DeleteMenu', function(){
				
			var menuId =  jQuery(this).attr('rel');
			var menu_name 	=  jQuery(this).attr('menu-name');

			if(menuId != "")
			{
				if(confirm("Are you sure you want to delete menu "+menu_name+"?"))
				{
					var url= admin_menu_destroy;
					jQuery.ajax({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						url: url,
						type: 'POST',
						data: {'menu_id': menuId},
						success:function(data)
						{
							if(data.status == false)
							{
								alert(data.msg);
								return false;
							}
							window.location.replace(admin_menu_index);
						}
					});
				}
			}
		});	
	}

	function SearchForMenu()
	{	
		
		jQuery(document).on('keyup', '.SearchForMenu', function() {
			
			var keyValue 			= jQuery(this).val();
			var searchType 			= jQuery(this).parent().children('.search_type').val();
			var searchContentDiv 	= jQuery(this).closest('.tab-pane').children('.searchContentDiv');
			if(jQuery.trim(keyValue) != "" && jQuery.trim(searchType) != "" && typeof search_menus_url !== 'undefined')
			{
				jQuery.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'POST',
					url: search_menus_url,
					data: {'page_key': keyValue, 'search_type': searchType},
					success : function(data)
					{
						searchContentDiv.html(data);
					}
				});
			}
			else
			{
				var data = ''; 
				searchContentDiv.html(data);
			}

		});	
	}

	function checkboxUtility()
	{
		jQuery('.checkboxUtility').on('click', function(){
			jQuery('.AllUncheck span').removeClass('checked');
			jQuery('.CheckboxViewAll').prop( "checked", false );							
		});
	}

	function cancelMenuObject()
	{
		jQuery(document).on('click', '.CancelItem', function(){
			var $this = jQuery(this).parents('.accordion__item');
			$this.find('.accordion-header').addClass('collapsed');
			$this.find('.accordion__body').removeClass('show');
		});	
		
	}

	function setScreenOption()
	{
		if(typeof screenOptionArray == 'undefined')
        {
            return false;
        }

		var screenOption = [];
		var obj = JSON.parse(screenOptionArray);
		jQuery.each( obj, function( outerKey, outerValue ) {				   
			jQuery.each( outerValue, function( innerKey, innerValue ) {
				var setOptionValue = getCookie('isCheck_'+outerKey);
				setOptionValue = parseInt(setOptionValue, 10) ;
				if(setOptionValue == 1)
				{
					jQuery('.X'+outerKey).removeClass('d-none');
					jQuery('.Allow'+outerKey).prop( "checked", true );
				}
				else if(setOptionValue == 0)
				{
					jQuery('.X'+outerKey).addClass('d-none');
					jQuery('.Allow'+outerKey).prop( "checked", false );
				}
			});
		});
	}

	function allowBlock()
	{
		jQuery(document).on('click', '.allowField', function() {
			var result  = jQuery(this).attr('rel');
			if (jQuery(this).prop('checked')==true)
			{
				var isCheck = 1;
				jQuery('.X'+result).slideDown('slow', function(){
					jQuery(this).removeClass('d-none');
				});
			}
			else
			{
				var isCheck = 0;
				jQuery('.X'+result).slideUp('slow', function(){
					jQuery(this).addClass('d-none');
				});
			}

			var date = new Date();
			date.setDate(date.getDate() + 30); 					//FOR DAYS
			
			document.cookie = "isCheck_"+result+"="+isCheck+"; expires="+date.toGMTString()+"path=/";
		});
	}

	$(document).ready(function() {
	    var updateOutput = function(e) {
	        var list = e.length ? e : $(e.target),
	        output = list.data('output');

	        if (output != undefined)
	        {
		        if (window.JSON) 
		        {
		            output.val(window.JSON.stringify(list.nestable('serialize')));
		        } 
		        else 
		        {
		            output.val('JSON browser support required for this demo.');
		        }
	        }
	    };
	    // activate Nestable for list 1
	    $('#NestableMenu').nestable({
	        group: 1
	    }).on('change', updateOutput);
	    // output initial serialised data
	    updateOutput($('#NestableMenu').data('output', $('#nestable-output')));
	});

	function AddToMenu()
	{
		
		jQuery(document).on('click', '.AddToMenu', function() {
			var olSize 		= jQuery('.dd ol').length;
			var $this 		= jQuery(this);
			var MenuType	= $this.attr('menu-type');
			var MenuId 		= $this.attr('menu-id');
			var error 		= 1;
			MenuId 	   		= parseInt(MenuId, 10);
		
			jQuery('.CheckboxViewAll').each(function() {
				if (jQuery(this).prop('checked') == true)
				{
					error = 0;
					return false;
				}
				else
				{
					error = 1;
				}
			});
			
			if(error == 1) 
			{
				error = 'Please select one item.';
			}
			if((MenuId < 1) || (MenuId == '')) 
			{ 
				error = 'Please Select Menu.';
			}
			
			if(error == 0)
			{
				var formData 	= jQuery(this).closest("form").serialize()+"&menu_type="+MenuType;
				var actionUrl 	= jQuery(this).closest("form").attr('action');
				jQuery.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					url : actionUrl,
					data: formData,
					type: 'POST',
					success:function(data)
					{
						if(data.status == false)
						{
							alert(data.msg);
							return false;
						}

						if(olSize == 0)
						{
							var result = '<ol class="dd-list setMenu"></ol>';
							jQuery('.menuss').append(data);
						}
					
						jQuery('#MenuItemContainer').css("background-color","#FFFF99");
						setTimeout(function(){
							jQuery('.setMenu').first().append(data);
							jQuery('#MenuItemContainer').removeAttr('style');
						}, 500);	
					}	
				});
			}
			else
			{
				alert(error);
			}
		});
		
	}
})(jQuery);