(function ($) {
    "use strict";

    var w3cms = function () {

        /* Handle Support ============ */
        var handleCommentReply = function () {
            jQuery('.w3-comment-reply').on('click', function (event) {
                event.preventDefault();

                var parent_id = $(this).data("commentid")
                var blog_id = $(this).data('postid');
                var replyto = $(this).data('replyto');
                var parent = $(this).parents('.comment .comment-body:first');

                $("#comment_parent").val(parent_id);
                $('#commentform').trigger("reset");
                $("#cancel-comment-reply").removeClass('d-none');
                $("#reply-title").parent().removeClass('d-none').addClass('d-block');
                $("#reply-title").html(replyto);
                $("#ReplyFormContainer").insertAfter(parent);

            });

            jQuery('#cancel-comment-reply').on('click', function (event) {

                event.preventDefault();

                $("#comment_parent").val(0);
                $("#reply-title").empty();
                $("#reply-title").parent().removeClass('d-block').addClass('d-none');
                $("#cancel-comment-reply").addClass('d-none');
                $("#ReplyFormContainer").appendTo('#comments-div');
            });
        }

        // handleAjaxLoadMore
        var handleAjaxLoadMore = function() {
			jQuery('.ajax-load-more').on('click', function(e) {
				e.preventDefault();

				var thisObj = jQuery(this);
				var formId = thisObj.data('form-id');

				var data_current_page = $('#'+formId).find('input[name="page"]').val();
				var ajax_container = $('#'+formId).find('input[name="ajax_container"]').val();
				var data = $('#'+formId).serialize();
				
				jQuery.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'Post',
					url: baseUrl+'/ajax-get-data',
					data: data,
					success : function(response)
					{
						if (response.html) {
							jQuery('#' + ajax_container).append(response.html);

					        // Check if there are more pages to load
					        if (response.has_more_pages) {

								data_current_page++;
					            $('#'+formId).find('input[name="page"]').val(data_current_page);

					        } else {
					            // No more posts to load
					            $(thisObj).text('No More Posts');
					            $(thisObj).prop('disabled', true).addClass('disabled');
					        }

					        var self = jQuery('#masonry, .masonry');
                            if(self.length)
                            {
                                if(jQuery('.card-container').length)
                                {
                                    self.imagesLoaded(function () {
                                        self.masonry({
                                            gutterWidth: 15,
                                            isAnimated: true,
                                            itemSelector: ".card-container"
                                        });
                                    });
                                }
                                self.masonry('reloadItems');
                            }
						}
						else {
				          	alert('Failed to load more posts.');
				        }
					}
				});
			});
		}

        var handleImageSelect = function () {

			const $_SELECT_PICKER = $('.image-select');
			$_SELECT_PICKER.find('option').each((idx, elem) => {
				const $OPTION = $(elem);
				const IMAGE_URL = $OPTION.attr('data-thumbnail');
				if (IMAGE_URL) {
					$OPTION.attr('data-content', "<img src='%i'/> %s".replace(/%i/, IMAGE_URL).replace(/%s/, $OPTION.text()))
				}
			});
			$_SELECT_PICKER.selectpicker();
		}

        /* Function ============ */
        return {
            init: function () {
                handleImageSelect();
                handleCommentReply();
                handleAjaxLoadMore();
            },
        }
    }();

    /* Document.ready Start */
    jQuery(document).ready(function () {
        w3cms.init();
    });

})(jQuery);