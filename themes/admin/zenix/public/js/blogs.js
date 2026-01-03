(function($) {
    "use strict";

    /* Created By CakeReady on 19 June 2015 */
    var current = jQuery('#customFieldContainer .Newfild').length;
    var index = current = parseInt(current, 10);
    index = current + 1;

    /* Create New Blog */
    createNewBlog();
    /* Create New Blog */

    /* Allow Block */
    allowBlock();
    /* Allow Block */

    /* Screen Option */
    setScreenOption();
    /* Screen Option */

    /* permalink on edit */
    permalink();
    /* permalink on edit */

    if(typeof blogCategoryIds != 'undefined')
    {
        categoryTreeSelected(blogCategoryIds);
    }
    addNewBlogCategory();

    jQuery('#BlogTitle').slug({hide:false});

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


    function createNewBlog() {
        removeField();

        /* Add Custom Field  */
        addCustomField();
        /* Add Custom Field  */
    }

    function addCustomField() {
        jQuery('#AddCustomField').on('click', function() {

            index                   = index + 1;
            var last_cf_num         = parseInt(jQuery('#last_cf_num').val());
            var BlogMetaName        = jQuery('#BlogMetaName').val();
            var BlogMetaValue       = jQuery('#BlogMetaValue').val();

            if((jQuery.trim(BlogMetaName) === "") && jQuery.trim(BlogMetaValue === ""))
            {
                alert('Please fill these fields.');
            }
            else
            {
                current = current + 1 ;
                index = last_cf_num > 0 ? last_cf_num + 1 : index;
                var customFieldContainer = '<div id="customFieldContainer"></div>';
                //jQuery("#AppendContainer").append(customFieldContainer);

                var html = '<div class="row xrow pt-3 mb-2 bg-light "> <div class="col-md-6 form-group"> <label for="BlogMetaName_'+index+'">Title</label> <input type="text" name="data[BlogMeta]['+index+'][title]" class="form-control" id="BlogMetaName_'+index+'" value="'+BlogMetaName+'"> </div> <div class="col-md-6 form-group"> <label for="">Value</label> <textarea name="data[BlogMeta]['+index+'][value]"" id="BlogMetaValue_'+index+'" class="form-control" rows="5">'+BlogMetaValue+'</textarea> </div> <div class="col-md-12 form-group"> <button class="btn btn-danger btn-sm CustomFieldRemoveButton" type="button">Delete</button> </div> </div>';

                jQuery("#customFieldContainer").css("background-color","green").fadeIn('slow', function(){
                    jQuery("#customFieldContainer").append(html);
                    jQuery("#customFieldContainer").delay( 800 ).fadeIn( 400 ).removeAttr('style');
                });
                jQuery('#BlogMetaName').val("");
                jQuery('#BlogMetaValue').val("");
                jQuery('#last_cf_num').val(index);

            }
            removeField();
        });
    }

    function removeField() {
        jQuery('.CustomFieldRemoveButton').on('click', function() {

            var removeId = jQuery(this).attr('rel');

            if (removeId != "" && removeId !== undefined) {
                url = baseUrl + 'admin/blog/blogs/ajax_delete/' + removeId;
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        jQuery('.swaprow_' + removeId).css("background-color", "red").fadeOut('slow', function() {
                            jQuery(this).remove();
                        });

                    }
                });
            } else {
                jQuery(this).closest('.xrow').css("background-color", "red").fadeOut('slow', function() {
                    jQuery(this).remove();
                });
            }

            var rowCount = jQuery('#AppendContainer .row').length;
            if (rowCount == 0) {
                jQuery('#customFieldContainer').hide('slow').remove();
            }
        });
    }

    function permalink() {

        jQuery('.editPermalinkContainer').hide();
        jQuery('.editPermalink').on('click', function() {
            var slug = jQuery('.permalinkSlugSpan').text();
            jQuery('.permalinkSlugSpan').hide('slow');
            jQuery('.editPermalink').hide('slow');
            jQuery('#BlogEditSlug').val(slug);
            jQuery('.editPermalinkContainer').show('slow');
        });

        jQuery('.editPermalinkOkButton').on('click', function() {

            var slug = jQuery('#BlogEditSlug').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: makeSlugUrl,
                type: 'POST',
                data: {'slug_text':slug}, // serializes the form's elements.
                dataType: 'html',
                success: function(data) {

                    jQuery('.permalinkSlugSpan').text(data);
                    jQuery('#slug').val(data);
                    jQuery('.editPermalinkContainer').hide('slow');
                    jQuery('.permalinkSlugSpan').show('slow');
                    jQuery('.editPermalink').show('slow');

                }
            });


        });

        jQuery('.editPermalinkCancelButton').on('click', function() {
            jQuery('.editPermalinkContainer').hide('slow');
            jQuery('.permalinkSlugSpan').show('slow');
            jQuery('.editPermalink').show('slow');
        });
    }

    function allowBlock() {
        jQuery('.allowField').on('click', function() {

            var result = jQuery(this).attr('rel');

            if (jQuery(this).prop('checked') == true) {
                jQuery('.X' + result).removeClass('d-none');
                var isCheck = 1;
            } else {
                var isCheck = 0;
                jQuery('.X' + result).addClass('d-none');
            }

            var date = new Date();
            date.setDate(date.getDate() + 30);                  //FOR DAYS

            document.cookie = "isCheck_"+result+"="+isCheck+"; expires="+date.toGMTString()+"path=/";
        });
    }

    function getScreenOptionValue(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(',');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
        }
        return "";
    }

    function setScreenOption() {
        if(typeof screenOptionArray == 'undefined')
        {
            return false;
        }
        var screenOption = [];
        var obj = JSON.parse(screenOptionArray);
        jQuery.each(obj, function(outerKey, outerValue) {
            jQuery.each(outerValue, function(innerKey, innerValue) {
                var setOptionValue = getCookie('isCheck_' + outerKey);
                setOptionValue = parseInt(setOptionValue, 10);
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

    function categoryTreeSelected(blogCategoryIds) {

        if (jQuery.trim(blogCategoryIds) != '') {
            var obj = JSON.parse(blogCategoryIds);

            jQuery.each(obj, function(outerKey, outerValue) {
                jQuery('.blog_categories').each(function() {

                    if (jQuery(this).val() == outerValue) {
                        jQuery(this).prop("checked", true);
                    }

                });
            });

        }
    }

    function addNewBlogCategory() {

        jQuery('.newCategoryDiv').hide();
        jQuery('.addNewBlogCategorylink').on('click', function() {
            jQuery(this).closest('.card').find('.newCategoryDiv').toggle('slow');
        });

        jQuery('.addNewBlogCategoryBtn').on('click', function() {

            var parentBox = jQuery(this).closest('.card');

            var title       = parentBox.find('.newCategoryField').val();
            var parent_id   = parentBox.find('.CategoryParentId :selected').val();
            var rdx_link    = parentBox.find('.rdx-link').val();
            
            if (title != "" && rdx_link != "")
            {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: rdx_link,
                    type: 'POST',
                    data: {'title':title, 'parent_id': parent_id}, // serializes the form's elements.
                    dataType: 'html',
                    success: function(data) {

                        if(jQuery('.BlogCategory'+parent_id).length > 0)
                        {
                            jQuery('.BlogCategory'+parent_id).after().append(data);
                        } else
                        {
                            parentBox.find('.appendCategory  ul:first').append(data);
                        }
                        setTimeout(function() {
                            parentBox.find('.newCategoryField').val('');
                            parentBox.find('.CatNotExit').remove();
                        }, 1000);

                    }
                });
            }
        });
    }

    jQuery(document).on('change', '#ContentVisibility', function() {

        var result = jQuery(this).val();

        if(result == 'PP') {
            jQuery('#PublicPasswordTextbox').slideDown('slow').removeClass('d-none');
            jQuery( "#ContentPassword" ).focus();
        } else {
            jQuery('#PublicPasswordTextbox').slideUp('slow', function(){
                jQuery('#PublicPasswordTextbox').addClass('d-none');
            });
            jQuery('#PublicPasswordTextbox').val(" ");
        }

    });

})(jQuery);
