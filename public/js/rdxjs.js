/*
Requirememnt : Use jQuery file before this.
*/

/*
Event-Tag :  rdx-event  / Default click
UpdateClass : rdxUpdateAjax 
Action-link : rdx-link html5 tag
UpdateContainer : rdx-result-box html5 tag
DeleteElement : rdx-delete-box html5 tag
For Click Event | Selectbox: Change
*/

(function($) { 
    
    "use strict";

    var UpdateContainer;
	var AjaxUpdate;
	var loading_image = "";

 	AjaxUpdate = function(){
	
		jQuery('.rdxUpdateAjax').unbind().on("change click", function(e){
			e.preventDefault();
			
			if(jQuery(this).is('select') && e.type == 'click' )
			{ 
				return false;
			}		
			
			if (jQuery(this).is('[rdx-link]')) {
				/* Check Select box */
				if(e.type == 'change' )
				{
					var actionURL = jQuery(this).attr('rdx-link')+'/'+jQuery(this).val();	
				}
				else
				{
					var actionURL = jQuery(this).attr('rdx-link');	
				}
				
				var AjaxStatus = true;
			}
			else
			{
				var AjaxStatus = false;	
			}
			
			// For delete any element on delete/remove action
			if(jQuery(this).is('[rdx-delete-box]')) {
				DeleteContainer = jQuery(this).attr('rdx-delete-box');
			}
			else
			{
				UpdateContainer = null;
			}
			// For delete any element on delete/remove action
			
			
			if(jQuery(this).is('[rdx-result-box]')) {
				UpdateContainer = jQuery(this).attr('rdx-result-box');
				// Updated By Devendra Soni on 23 Jan 2015 
				// set rdx-no-loading = true if you don't want to show the loading image
				DisplayLoadingContainer = jQuery(this).attr('rdx-no-loading');
				
				if(DisplayLoadingContainer != true)
					jQuery('#'+UpdateContainer).html(loading_image);
			}
			else
			{
				UpdateContainer = null;
			}
			// Updated By Devendra Soni on 23 Jan 2015 
			var DeleteContainer = typeof DeleteContainer == 'undefined' ? '' : DeleteContainer;
			
			if(AjaxStatus == true)
			{
				jQuery.ajax({
					type: 'GET',
					url: actionURL,
					success : function(data)
					{
						if(UpdateContainer != null)
						{
							jQuery('#'+UpdateContainer).html(data);
							AjaxUpdate();
						}
						
						if(DeleteContainer !=  '')
						{
							jQuery('#'+DeleteContainer).fadeOut('slow',function(){
								jQuery('#'+DeleteContainer).remove();	
							});
						}
						
					},
					error : function(data)
					{
	                    alert(JSON.stringify(data));
						alert('Sorry! There is some problem. please check function calling.')
					}
				});	
			}
			else
			{
				if(DeleteContainer !=  '')
				{
					jQuery('#'+DeleteContainer).fadeOut('slow',function(){
						jQuery('#'+DeleteContainer).remove();	
					});
				}	
			}
			
		
			return false;
		})
	}

	jQuery(document).ready(function(){ 
		AjaxUpdate();
	});

})(jQuery);