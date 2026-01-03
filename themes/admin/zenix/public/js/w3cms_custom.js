(function ($) {

	"use strict";

	var W3cms = function () {

		var handleSelectPicker = function () {
			setTimeout(function(){
				if (jQuery('.default-select').length > 0) {
					jQuery('.default-select').selectpicker("refresh");
				}
				$('.filter-option .lang-selected-text').css({ "visibility": "hidden" });
				$('.filter-option .lang-select-text').show();
				$('.lang-dropdown').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
					if (isSelected) {
						// Hide the text span and show only the image in the selected option
						$('.filter-option .lang-selected-text').css({ "visibility": "hidden" });
						$('.filter-option .lang-select-text').show();
					}
				});
			},500);
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

		var handleshowConfirmPass = function () {
			jQuery('.show-con-pass').on('click', function () {
				jQuery(this).toggleClass('active');
				if (jQuery('#dz-con-password').attr('type') == 'password') {
					jQuery('#dz-con-password').attr('type', 'text');
				} else if (jQuery('#dz-con-password').attr('type') == 'text') {
					jQuery('#dz-con-password').attr('type', 'password');
				}
			});
		}

		var handleDateTimePicker = function () {

			if (jQuery('.datetimepicker').length > 0) {
				$('.datetimepicker').pickadate({
					format: 'yyyy-mm-dd',
				});
			}
		}

		var handleCkEditor = function () {
			if (jQuery("#ckeditor").length > 0) {
				ClassicEditor
					.create(document.querySelector('#ckeditor'), {
					})
					.then(editor => {
						window.editor = editor;
					})
					.catch(err => {
						console.error(err.stack);
					});
			}

			if (jQuery('.W3cmsCkeditor').length > 0 && typeof enableCkeditor !== undefined && enableCkeditor == true) {
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

				jQuery(".W3cmsCkeditor").each(function () {
					CKEDITOR.replace($(this).attr('id'), editorOptions);
					if (jQuery('body[data-theme-version="dark"]').length > 0) {
						CKEDITOR.addCss('.cke_editable { background-color: #000; color: #fff }');
					}
				});
			}

		}

		var tagify = function () {
			if (jQuery('input[name=tagify]').length > 0) {

				// The DOM element you wish to replace with Tagify
				var input = document.querySelector('input[name=tagify]');

				// initialize Tagify on the above input node reference
				new Tagify(input);

			}
		}

		var handleThemeMode = function () {

			jQuery('.dz-theme-mode').on('click', function () {
				jQuery(this).toggleClass('active');

				if (jQuery(this).hasClass('active')) {
					jQuery('body').attr('data-theme-version', 'dark');
				} else {
					jQuery('body').attr('data-theme-version', 'light');
				}
			});
		}

		var handleLoginDetails = function () {
			jQuery(document).on('click', '#admin_detail', function () {
				$('#login_email').val('admin@gmail.com');
				$('#login_password').val('12345678');
			});
			jQuery(document).on('click', '#manager_detail', function () {
				$('#login_email').val('manager@gmail.com');
				$('#login_password').val('12345678');
			});
			jQuery(document).on('click', '#customer_detail', function () {
				$('#login_email').val('customer@gmail.com');
				$('#login_password').val('12345678');
			});
		}

		var handleTwoFactorAuthForm = function () {

			jQuery('.TwoFactorAuthForm').on('click', function () {
				var rel = jQuery(this).attr('rel');
				jQuery('#recoveryCodeForm').addClass('d-none');
				jQuery('#secretCodeForm').removeClass('d-none');
				if (rel == 'recovery_form') {
					jQuery('#recoveryCodeForm').removeClass('d-none');
					jQuery('#secretCodeForm').addClass('d-none');
				}
			});

		}

		var handleImgOnChange = function () {

			$(document).on('change', ".img-input-onchange", function () {
				var input = this;
				var url = $(this).val();

				var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
				if (input.files && input.files[0]) {
					var reader = new FileReader();
					reader.onload = function (e) {
						$(input).parents('.img-parent-box').find('.img-for-onchange').attr('src', e.target.result);
					}
					reader.readAsDataURL(input.files[0]);
				}
			});
		}

		/* ===============Permalink configuration page js start=============== */

		var handlePermalinks = function () {

			jQuery('.permalink_selection').on('change', function () {
				var permalink_selection = $(this).val();
				if (permalink_selection !== 'custom') {
					$('#permalink_structure').val(permalink_selection);
				}
			});

			jQuery('#permalink_structure').on('click', function () {
				$('#CustomeStructure').prop('checked', true);
			});

			jQuery('.permas_type').on('click', function () {
				var all_custom_structure = jQuery('#permalink_structure').val();
				var thisData = jQuery(this);
				var this_val = thisData.val();
				var permas_length = all_custom_structure.search(this_val);

				if ((permas_length > -1) || thisData.hasClass('active')) {
					all_custom_structure = all_custom_structure.replace('/' + this_val, '');
					thisData.removeClass('active');
				} else {
					all_custom_structure = all_custom_structure ? all_custom_structure + this_val + '/' : all_custom_structure + '/' + this_val + '/';
					thisData.addClass('active');
				}
				if (jQuery('button.active').length == 0) {
					all_custom_structure = '';
				}
				jQuery('#permalink_structure').val(all_custom_structure);
				$('#CustomeStructure').prop('checked', true);
			});

		}

		/* ================Permalink configuration page js end================ */

		/* ================User and role permissions page js start================ */
		var handleUserRolePermissions = function () {

			jQuery('.bulkActionRoleCheckbox').on('change', function () {

				var role_id = jQuery(this).data('role-id');
				var actionURL = jQuery(this).attr('rdx-link');
				var $this = jQuery(this);

				jQuery.ajax({
					type: 'GET',
					url: actionURL,
					success: function (data) {
						if (!data.status) {
							$this.prop('checked', $this.is(':checked') ? false : true);
						}
						else {
							jQuery('.permissionCheckbox_' + role_id).prop('checked', $this.is(':checked'));
						}
						alert(data.msg);

					},

					error: function (data) {
						alert(JSON.stringify(data));
						alert('Sorry! There is some problem. please check function calling.')
					}

				});
			});

			jQuery(document).on('change', '.RoleCheckbox', function () {

				event.preventDefault();
				var actionURL = jQuery(this).attr('rdx-link');
				var $this = jQuery(this);

				jQuery.ajax({
					type: 'GET',
					url: actionURL,
					success: function (data) {
						if (!data.status) {
							$this.prop('checked', $this.is(':checked') ? false : true);
						}
						else {
							$this.prop('checked', $this.is(':checked'));
						}
						alert(data.msg);
					},
					error: function (data) {
						alert(JSON.stringify(data));
						alert('Sorry! There is some problem. please check function calling.')
					}
				});
			});



			jQuery(document).on('change', '.UserCheckbox', function () {

				event.preventDefault();
				var user_id = jQuery(this).data('user-id');
				var permission_id = jQuery(this).data('permission-id');
				var actionURL = jQuery(this).attr('rdx-link');
				var $this = jQuery(this);

				jQuery.ajax({

					type: 'GET',
					url: actionURL,
					success: function (data) {
						if (!data.status) {
							$this.prop('checked', $this.is(':checked') ? false : true);
						}
						else {
							jQuery('#userCheckbox_' + user_id).prop('checked', $this.is(':checked'));
						}
						alert(data.msg);
					},

					error: function (data) {
						alert(JSON.stringify(data));
						alert('Sorry! There is some problem. please check function calling.')
					}

				});
			});

			jQuery('.deleteUserPermission').on('click', function () {

				event.preventDefault();
				if (!confirm('Are you sure you want to delete User Level permission?')) {
					return false;
				}

				var user_id = jQuery(this).data('user-id');
				var permission_id = jQuery(this).data('permission-id');
				var actionURL = jQuery(this).attr('rdx-link');
				var $this = jQuery(this);

				jQuery.ajax({
					type: 'GET',
					url: actionURL,
					success: function (data) {
						if (data.status) {
							if (jQuery('#userCheckbox_' + user_id + '_' + permission_id).is(':checked')) {
								jQuery('#userCheckbox_' + user_id + '_' + permission_id).prop('checked', false);
							}
							jQuery('#userCheckbox_' + user_id + '_' + permission_id).parent().find('.deny-permission').removeClass('deny-permission');
							$this.remove();
						} else {
							alert(data.msg);
						}
					},
					error: function (data) {
						alert(JSON.stringify(data));
						alert('Sorry! There is some problem. please check function calling.')
					}

				});
			});

			jQuery('.RemoveUserPermission').on('change', function () {

				event.preventDefault();
				var user_id = jQuery(this).data('user-id');
				var actionURL = jQuery(this).attr('rdx-link');
				var $this = jQuery(this);

				jQuery.ajax({
					type: 'GET',
					url: actionURL,
					dataType: 'json',
					success: function (data) {
						if (!data.status) {
							$this.prop('checked', $this.is(':checked') ? false : true);
						}
						else {
							jQuery('.permissionCheckbox_' + user_id).prop('checked', $this.is(':checked'));
						}
						alert(data.msg);

					},
					error: function (data) {
						alert(JSON.stringify(data));
						alert('Sorry! There is some problem. please check function calling.')
					}

				});

			});

			jQuery(document).on("click", ".toggle-icon", function () {
				jQuery(this).toggleClass('active');
				jQuery('.support-menu').toggleClass('active');
			});

			jQuery(document).on("click", ".AssignRevokePermissions", function () {

				event.preventDefault();
				var permission_id = jQuery(this).data('permission-id');
				var type = jQuery(this).data('type');
				var actionURL = jQuery(this).attr('href');
				var $this = jQuery(this);

				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'POST',
					url: actionURL,
					data: { 'permission_id': permission_id, 'type': type },
					success: function (data) {
						jQuery("#AssignRevokePermissionsModalBody").html(data);
						jQuery('#AssignRevokePermissionsModal').modal('show');

					},
					error: function (data) {
						alert('Sorry! There is some problem. please check function calling.')
					}
				});

			});

			jQuery(document).on("change", "#RoleId", function () {

				event.preventDefault();
				var role_id = jQuery(this).val();
				var actionURL = jQuery(this).attr('rdx-link');
				var $this = jQuery(this);

				jQuery.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'POST',
					url: actionURL,
					data: { 'role_id': role_id },
					success: function (data) {
						jQuery("#PermissionUserId").html(data);
						jQuery('#AssignRevokePermissionsModal').modal('show');

					},
					error: function (data) {
						alert('Sorry! There is some problem. please check function calling.')
					}
				});

			});

			jQuery(document).on("change", "#PermissionUserId", function () {

				event.preventDefault();
				var user_id = jQuery(this).val();

				var permission_id = jQuery("#PermissionId").val();
				var actionURL = jQuery(this).attr('rdx-link');
				var $this = jQuery(this);
				if (!user_id) {
					return false;
				}
				jQuery.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'POST',
					url: actionURL,
					data: { 'user_id': user_id, 'permission_id': permission_id },
					success: function (data) {
						jQuery("#PermissionActionBtn").html(data);
						jQuery('#AssignRevokePermissionsModal').modal('show');

					},
					error: function (data) {
						alert('Sorry! There is some problem. please check function calling.')
					}
				});

			});

		}
		/* ================User and role permissions page js end================ */

		var handleLogoutSystem = function () {

			jQuery('.LogOutBtn').on('click', function () {
				event.preventDefault();
				jQuery(this).closest('form').submit();
			});
		}

		var handleDisableImportBtn = function () {
			jQuery(document).on('click', '#importBtn', function () {
				jQuery('#importBtn').addClass('disabled');
			});

			jQuery("#importBtn").on('click', function () {
				jQuery(this).append(' <i class="fa fa-spinner fa-spin"></i>');
				jQuery(this).addClass('disabled');
			});
		}

		var handleReadingConfigs = function () {
			$('.ReadingPostBtn').on('change', function () {
				var rel = jQuery(this).attr('id');

				jQuery('.page-filters').addClass('d-none');
				if (rel == 'show_on_front_page') {
					jQuery('.page-filters').removeClass('d-none');
				}

			});
		}

		var handleToolsExport = function () {
			var form = $('#export-filters'),
				filters = form.find('.export-filters');
			filters.hide();
			form.find('input:radio').on('change', function () {
				filters.slideUp('fast');
				switch ($(this).val()) {
					case 'attachment': $('#attachment-filters').slideDown(); break;
					case 'posts': $('#post-filters').slideDown(); break;
					case 'pages': $('#page-filters').slideDown(); break;
				}
			});
		}

		var handlePopovers = function () {
			$('[data-bs-toggle="popover"]').popover({
				html: true,
				content: function () {
					return '<img src="https://ps.w.org/contact-form-7/assets/icon-256x256.png"><p>this is a content.</p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.';
				}
			});
		}

		var handleFrontendEditorIssue = function () {
			jQuery('i').empty();
		}

		var handleImportDemoData = function () {

			jQuery('.ImportDemo').on('click', function () {
				event.preventDefault();
				var rel = jQuery(this).attr('rel');
				jQuery('#DBFileUrl').val(rel);
				jQuery('#ImportDataForm').modal('show');
			});
		}

		var handleMakeSlug = function () {

			if (typeof makeSlugUrl == undefined) {
				return false;
			}

			var delayTime = 500;
			var searchTimer = null;

			$('.MakeSlug').on('keypress, blur, input', function () {
				var thisData = jQuery(this);
				var rel = thisData.attr('rel');
				var value = thisData.val();
				if (value == '') {
					return false;
				}
				if (searchTimer) {
					clearTimeout(searchTimer);
				}
				searchTimer = setTimeout(function () {

					jQuery.ajax({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						type: 'POST',
						url: makeSlugUrl,
						data: { 'slug_text': value },
						success: function (data) {
							jQuery("#" + rel).val(data);

						},
						error: function (data) {
							alert('Sorry! There is some problem. please check function calling.')
						}
					});
				}, delayTime);

			});
		}

		var handleConfigDateTimeFormat = function () {

			$(document).ready(function() {
				if ($('input.ChangeDateFormat[value="custom"]:checked').length > 0) {
					$('input[name="Site[custom_date_format]"]').removeAttr('readonly');
				}else {
					$('input[name="Site[custom_date_format]"]').attr('readonly','readonly');
				}

				$('input.ChangeDateFormat[name="Site[date_format]"]').click(function() {
					if ($('input.ChangeDateFormat[value="custom"]').is(':checked')) {
						$('input[name="Site[custom_date_format]"]').removeAttr('readonly');
					} else {
						$('input[name="Site[custom_date_format]"]').attr('readonly','readonly');
					}
				});

				if ($('input.ChangeTimeFormat[value="custom"]:checked').length > 0) {
					$('input[name="Site[custom_time_format]"]').removeAttr('readonly');
				}else {
					$('input[name="Site[custom_time_format]"]').attr('readonly','readonly');
				}

				$('input.ChangeTimeFormat[name="Site[time_format]"]').click(function() {
					if ($('input.ChangeTimeFormat[value="custom"]').is(':checked')) {
						$('input[name="Site[custom_time_format]"]').removeAttr('readonly');
					} else {
						$('input[name="Site[custom_time_format]"]').attr('readonly','readonly');
					}
				});
			});

			jQuery('.ChangeDateFormat').on('change', function () {
				var dateFormat = jQuery(this).val();
				var date = jQuery(this).data('date');
				if ('custom' !== dateFormat)
					$('input[name="Site[custom_date_format]"').val(dateFormat);
				$('.DateFormatContainer').text(date);
			});

			jQuery('.ChangeTimeFormat').on('change', function () {
				var timeFormat = jQuery(this).val();
				var time = jQuery(this).data('time');
				if ('custom' !== timeFormat)
					$('input[name="Site[custom_time_format]"').val(timeFormat);
				$('.TimeFormatContainer').text(time);
			});

			jQuery('input[name="Site[custom_date_format]"], input[name="Site[custom_time_format]"]').on('input click', function () {
				var thisVal = jQuery(this);
				var url = thisVal.data('link');

				// Debounce the event callback while users are typing.
				clearTimeout(jQuery.data(this, 'date_timer'));
				jQuery(this).data('date_timer', setTimeout(function () {
					if (thisVal.val()) {
						jQuery.ajax({
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
							type: 'POST',
							url: url,
							data: { 'format': thisVal.val() },
							success: function (data) {

								if (thisVal.attr('name') == 'Site[custom_date_format]') {
									jQuery('.DateFormatContainer').text(data);
								}
								if (thisVal.attr('name') == 'Site[custom_time_format]') {
									jQuery('.TimeFormatContainer').text(data);
								}

							},
							error: function (data) {
								alert('Sorry! There is some problem. please check function calling.')
							}
						});
					}
				}, 500));
			});

		}

		var handleNotificationJs = function () {

			jQuery("#DefaultPlaceholder").on("click", function () {
				CKEDITOR.instances['Placeholders'].setData(jQuery("#PlaceholderSec").text())
			});

			jQuery(".EnableNotificationBox").on('change', function () {

				if (jQuery('.' + jQuery(this).attr('rel')).hasClass('d-none')) {
					jQuery('.' + jQuery(this).attr('rel')).removeClass('d-none');
				}
				else {
					jQuery('.' + jQuery(this).attr('rel')).addClass('d-none');
				}

			});

			jQuery('.All-Notification').on('change', function () {
				if (jQuery(this).is(':checked')) {
					jQuery(this).parents('tr').find('.Notification').prop('disabled', false);
				} else {
					jQuery(this).parents('tr').find('.Notification').prop('disabled', true);
				}
			});

			if (jQuery('.NotifyPlaceholderCkeditor').length > 0) {
				let editorOptions = {
					removePlugins: 'cloudservices, easyimage, exportpdf',
					disallowedContent: 'script; *[on*]',

					autoParagraph: false,
					enterMode: CKEDITOR.ENTER_BR,
					fillEmptyBlocks: false,
					allowedContent: true,
					extraAllowedContent: '*(*)',
					toolbar: [
						{ items: ['Bold', 'Italic', 'Underline', 'Strike'] },
					],
				};

				CKEDITOR.replace($('.NotifyPlaceholderCkeditor').attr('id'), editorOptions);
			}

		}

		var handleDeleteUserModal = function () {

			jQuery('.DeleteUser').on('click', function () {
				event.preventDefault();
				var url = jQuery(this).attr('href');
				var user_name = jQuery(this).data('user-name');

				$('#DeleteUserForm').attr('action', url);
				$('select[name="reassign_user"] option:contains("' + user_name + '")').remove();
				$('#UserName').text(user_name);
				jQuery('#DeleteUserModal').modal('show');
			});

			var deleteUserForm = $('#DeleteUserForm'),
				filters = deleteUserForm.find('.delete-filters');
			filters.hide();
			deleteUserForm.find('input:radio').on('change', function () {
				$('#DeleteUserForm button[type="submit"]').removeAttr('disabled');
				filters.slideUp();
				switch ($(this).val()) {
					case 'reassign': $('#reassign-selectbox').slideDown(); break;
				}
			});

		}

		var handleElemetsSortable = function () {

			if (jQuery("#MagicEditorElementContainer").length > 0) {
				jQuery("#MagicEditorElementContainer").sortable({
					handle: ".drag-handle",

					start: function (event, ui) {
						var start_pos = ui.item.index();
						ui.item.data('start_pos', start_pos);
					},
					update: function (event, ui) {
						var start_pos = ui.item.data('start_pos');
						var last_pos = ui.item.index();
						var editorContent = getEditorValue('PageContent').split('<%ME%>');
						var removedElement = editorContent.splice(start_pos, 1);
						editorContent.splice(last_pos, 0, removedElement);

						var elementData = editorContent.join('<%ME%>');
						setEditorValue('PageContent', elementData);
					}
				});
			}

		}

		var handleDropzone = function () {

			if (jQuery("#UploadFiles").length > 0) {
				var csrfToken = jQuery('meta[name="csrf-token"]').attr('content');
				// set the dropzone container id
				const id = "#UploadFiles";
				// set the preview element template
				var previewTemplate = jQuery(".dropzone-item").parent().html();
				jQuery(".dropzone-item").remove();

				var myDropzone = new Dropzone(id, { // Make the whole body a dropzone
					headers: {
						'X-CSRF-TOKEN': csrfToken
					},
					url: uploadFilesRoute, // Set the url for your upload script location
					parallelUploads: 1,
					maxFilesize: 300, // Maximum file size in MB
					acceptedFiles: ".png,.jpg,.jpeg,.gif,.zip",
					previewTemplate: previewTemplate,
					previewsContainer: id + " .dropzone-items", // Define the container to display the previews
					clickable: id + " .dropzone-select", // Define the element that should be used as click trigger to select files.
					init: function () {

						this.on("success", function (file, response) {
							jQuery('.UploadFilesList').append('<option value="' + response.file.full_name + '">' + response.file.name + ' (' + response.file.time + ')' + '</option>');
						});

						this.on("error", function (file, errorMessage) {
							console.log(errorMessage); // Handle the upload error
						});
					}
				});

				myDropzone.on("addedfile", function (file) {
					// Hookup the start button
					jQuery('.dropzone-item').show();
				});

				// Hide the total progress bar when nothing"s uploading anymore
				myDropzone.on("complete", function (progress) {
					if (progress.xhr) {
						var response = JSON.parse(progress.xhr.response);
						var filename = response.file.name + ' (' + response.file.time + ')';
						jQuery('span[data-dz-name]:contains(' + response.file.name + ')').text(filename);
					}
					setTimeout(function () {
						jQuery('.dz-complete .progress-bar').css({ 'opacity': 0 });
						jQuery('.dz-complete .progress').css({ 'opacity': 0 });
					}, 300);
				});

				// Hide the total progress bar when nothing"s uploading anymore
				myDropzone.on("removedfile", function (file) {
					var response = JSON.parse(file.xhr.response);
					var name = response.file.path;
					$.ajax({
						headers: {
							'X-CSRF-TOKEN': csrfToken
						},
						type: 'POST',
						url: removeFilesRoute,
						data: { filename: name },
						success: function (data) {
							$('.UploadFilesList option').each(function () {
								if ($(this).val() == response.file.full_name) {
									$(this).remove();
								}
							});
							console.log(data.msg);
						},
						error: function (e) {
							console.log(e);
						}
					});
				});
			}

		}

		var handleW3appsSearch = function () {

			var delayTime = 500;
			var searchTimer = null;

			$('#SearchApps').on('keypress, blur, input', function () {
				var value = jQuery(this).val();
				jQuery("#ThemeSection").empty();
				jQuery(".ThemeSectionSpinner").removeClass('d-none');
				if (value.trim() == '') {
					value = 'all_theme';
				}
				if (searchTimer) {
					clearTimeout(searchTimer);
				}
				searchTimer = setTimeout(function () {

					jQuery.ajax({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						type: 'POST',
						url: addThemeRoute,
						data: { 'search_apps': value },
						success: function (data) {
							if (data.error == false) {
								alert(data.msg);
								return false;
							}

							jQuery('#ThemeSection').html(data);
							jQuery(".ThemeSectionSpinner").addClass('d-none');

						},
						error: function (data) {
							alert('Sorry! There is some problem. please check function calling.')
						}
					});
				}, delayTime);

			});

		}

		var handleW3appPreviewModal = function () {

			jQuery(".ThemePreview").on("click", function () {
				var themeData = JSON.parse(jQuery(this).attr("theme-data"));
				jQuery("#theme-modal-title").text(themeData.title);
				jQuery("#modal-body-description").html(themeData.description);
				jQuery("#LastUpdated").html(themeData.updated_at);

				if (themeData.screenshots) {
					var tabPanel = '';
					var tabContent = '';
					jQuery.each(themeData.screenshots, function (index, value) {
						var tabPanelClass = index == 0 ? ' show active' : '';
						var tabContentClass = index == 0 ? ' show' : '';
						tabPanel += '<div role="tabpanel" class="tab-pane fade' + tabPanelClass + '" id="image-' + index + '">' +
							'<img class="img-fluid border" src="' + value + '" alt="' + value + '" width="100%">' +
							'</div>';
						tabContent += '<li role="presentation" class="mb-1' + tabContentClass + '">' +
							'<a href="#image-' + index + '" role="tab" data-bs-toggle="tab">' +
							'<img class="img-fluid border" src="' + value + '" alt="' + value + '" width="50">' +
							'</a>' +
							'</li>';
					});
					jQuery(".tab-content").html(tabPanel);
					jQuery(".slide-item-list").html(tabContent);
				}

				if (themeData.tags) {
					var tags = '';
					jQuery.each(themeData.tags, function (index, value) {
						tags += '<span class="badge badge-success badge-sm m-1">' + value + '</span>';
					});
					jQuery("#TagsContent").html(tags);
				}

				jQuery('#basicModal').modal('show');
			});

		}

		var handleW3appInstallTheme = function () {

			if (typeof installThemeRoute == undefined) {
				return false;
			}
			jQuery(".InstallTheme").on("click", function () {
				event.preventDefault();
				var thisData = jQuery(this);
				thisData.text('Installing.....');
				jQuery.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'POST',
					url: installThemeRoute,
					data: { 'package': thisData.attr('href'), 'themename': thisData.attr('theme-name'), 'themetype': thisData.attr('theme-type') },
					success: function (data) {
						if (data.error == false) {
							alert(data.msg);
							return false;
						}

						var activeThemeBtn = '<a href="' + data.active_theme + '" class="btn btn-xs btn-primary light w-100">Active</a>';
						thisData.after(activeThemeBtn);
						thisData.remove();

					},
					error: function (data) {
						alert('Sorry! There is some problem. please check function calling.')
					}
				});
			});

		}

		var handleW3appUploadTheme = function () {

			jQuery("#UploadThemeBtn").on("click", function () {
				jQuery("#UploadThemeSec").toggleClass('d-none');
			});

			jQuery("#theme_zip").on("change", function () {
				jQuery("#install_theme").attr('disabled', true);
				if (jQuery(this).val()) {
					jQuery("#install_theme").attr('disabled', false);
				}
			});

		}

		var handleLanguages = function () {

			jQuery("#LanguageForm").on("submit", function () {
				event.preventDefault();
				var language = jQuery('#language').val();
				var file_name = jQuery('#file_name').val();
				jQuery.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'POST',
					url: jQuery(this).attr('action'),
					data: { 'language': language, 'file_name': file_name },
					success: function (data) {
						if (data.error == false) {
							alert(data.msg);
							return false;
						}

						jQuery("#language_hidden").val(language);
						jQuery("#file_name_hidden").val(file_name);
						jQuery("#LanguageData").html(data);

					},
					error: function (data) {
						alert('Sorry! There is some problem. please check function calling.')
					}
				});
			});

			jQuery("#UpdateLanguageFile").on("submit", function () {
				event.preventDefault();

				if (!confirm('Are you sure?')) {
					return false;
				}

				var language_hidden = jQuery('#language_hidden').val();
				var file_name_hidden = jQuery('#file_name_hidden').val();
				jQuery.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'POST',
					url: jQuery(this).attr('action'),
					data: jQuery(this).serialize(),
					success: function (data) {
						if (data.error == false) {
							alert(data.msg);
							return false;
						}

						alert('File updated successfully.');

					},
					error: function (data) {
						alert('Sorry! There is some problem. please check function calling.')
					}
				});
			});

		}

		/**
		 * methode is used for hide or display language position button
		 */
		var handleLanguagePosition = function () {
			$('.reading-multi-lang').on("change", function () {
				if (this.checked) {
					$('.reading-multi-position').removeClass('d-none');
				} else {
					$('.reading-multi-position').addClass('d-none');
				}
			});
		}

		/**
		 * created by raj
		 * This will check after reload if the checkbox was clicked or not 
		 */
		var handleDependElements = function () {
			$('input.element-depend[type="checkbox"]:checked').each(function() {
				var checkbox_name = $(this).attr('name');
			
				if ($('[class*="' + checkbox_name + '-depend"]').length > 0) {
					$('[class*="' + checkbox_name + '-depend"]').show().removeClass('d-none');
				}
			});

			var radio = $('input.element-depend[type="radio"]:checked');
			var radio_name = radio.attr('name');
			var radio_value = radio.val()

			$('div[data-' + radio_name + '-value]').each(function() {
				if($(this).attr('data-' + radio_name + '-value') == radio_value){
					$(this).show().removeClass('d-none');
				}
			});

			var selectedOption = $('select.element-depend').val();
			if(selectedOption){
				var parentId = $('select.element-depend option:selected').parent().attr('id');

				if ($('#' + parentId).data('ajax_container') !== undefined && $('#' + parentId).data('ajax_url') !== undefined) {
					var elValue = $('#' + parentId).val();
					var elementId = $('#element_id').val();
					var ajaxContainer = $('#' + parentId).data('ajax_container');
					var ajaxUrl = $('#' + parentId).data('ajax_url');
					var paramName = ajaxContainer.replace('Container', '');
					
					if($('#' + ajaxContainer)){
						var selectbox = $('#' + ajaxContainer).find('select');
						if(selectbox.children('option').length === 1){
							jQuery.ajax({
								headers: {
									'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								},
								type: 'POST',
								url: ajaxUrl,
								data: {
									'element_id': elementId,
									'content': elValue,
									'param_name': paramName,
									'elementData': serializedelementData
								},
								success: function (data) {
									if ($('#' + ajaxContainer).length > 0) {
										$('#' + ajaxContainer).html(data);
									}
								}
							});
						}
					}
				}

				if ($('div').hasClass(parentId + '-depend')) {
					$('div.' + parentId + '-depend').show().removeClass('d-none');
				}
			}
		}

		var handleLangTranslator = function () {

			jQuery(document).on("click", ".LangTranslator", function () {

				var thisData = jQuery(this);
				var key = thisData.parent('td').find('input').attr('name');
				var language = jQuery('#language').val();
				var value = thisData.parent('td').find('input').val();

				jQuery.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'POST',
					url: translatorRoute,
					data: { 'text': value, 'lang_type': language },
					success: function (data) {
						if (data.error == false) {
							alert(data.msg);
							return false;
						}
						thisData.parent('td').find('input').val(data.translation);

					},
					error: function (data) {
						alert('Sorry! There is some problem. please check function calling.')
					}
				});
			});
		}

		var handleTaxonomyNameRegex = function () {

			function generateSlug(input) {
				return input
					.toLowerCase() // Convert to lowercase
					.replace(/\s+/g, '-') // Replace spaces with hyphens
					.replace(/[^a-z0-9-]/g, '') // Remove non-alphanumeric characters except hyphens
					.replace(/--+/g, '-'); // Replace multiple hyphens with a single hyphen
			}

			jQuery('.TaxonomyNameRegex').on('input', function (e) {
				$(this).val(generateSlug($(this).val()));
			});
		}

		var handleZoomElementImg = function () {

			$('.el-img').on({
				mouseenter: function (e) {
					var src = jQuery(this).attr('src');
					var img = '<img src="' + src + '">';
					var zoomCon = jQuery(this).parent(".icon-lg").find('.zoom-img-container');
					zoomCon.html(img);
				},
				mousemove: function (e) {
					var zoomCon = jQuery(this).parent(".icon-lg").find('.zoom-img-container');
					var windowHeight = $(window).height();
					var windowWidth = $(window).width();
					var offset = jQuery(this).offset();
					var x = e.pageX - offset.left + 40;
					var y = e.pageY - offset.top + 20;
					var conHei = zoomCon.height();
					var conWid = zoomCon.width();
					var conTop = zoomCon.offset().top - $(window).scrollTop();
					var conLeft = e.pageX + 15 + conWid;
					var conDis = e.pageY - $(window).scrollTop() + conHei +20;

					if (conDis > windowHeight) {
						conHei = (-conHei);
						y = y+conHei-25;
					}

					if(conLeft > windowWidth) {
						conWid = (-conWid);
						x = x+conWid -25;
					}
					zoomCon.css({
						"top": y,
						"left": x,
					});
				},
				mouseleave: function (e) {
					$('.zoom-img-container').empty();
				}
			});
		}


        /* ================handleFlatIcon Code js start created by raj ================ */

		var handleFlatIcon = function () {
			var $currentInput = '';

			$(document).on('focus', '.selectIcon', function () {
				$currentInput = $(this);
				$currentInput.attr('autocomplete', 'off');
				$("#selectIcon").fadeIn();

				// Check if icons are already loaded
				if ($('#selectIcon .icons').length === 0) {
					if (active_frontend_theme == 'frontend/bodyshape') {
						var url = baseUrl + '/public/themes/' + active_frontend_theme + '/icons/flaticon/flaticon_bodyshape.css';
					}else{
						var url = baseUrl + '/public/themes/' + active_frontend_theme + '/icons/flaticon/flaticon.css';
					}

					$.get(url, function (data) {
						// Extract class names using regular expression
						var classNames = data.match(/(?:\.flaticon-)([a-z\-]+)(?=:before)/g);

						if (classNames) {
							// Extract the class names without the . and flaticon- prefix
							classNames = classNames.map(function (fullClassName) {
								return fullClassName.replace(/\./, '');
							});
						}

						$.each(classNames, function (index, value) {
							// Use 'value' for each class name
							$('.custom-modal-content > .row').append(
								'<div class="col-lg-2 col-sm-3 col-4 icons"><i class=' + value + '></i><p>' + value + '</p></div>'
							);
						});
					})
                    .done(function () {
                        // Event delegation for dynamically added icons
                        $('#selectIcon .icons').click(function () {
                            $($currentInput).next('i').remove();
                            var text = $(this).find('p').text();
                            var iconClass = $(this).find('i').attr('class');
                            $($currentInput).val(text).after('<i class="d-inline-block ' + iconClass + '"></i>');
                            $("#selectIcon").fadeOut();
                        });
                    });
				}
			});

			$("#closeModal, .custom-modal-wrapper").click(function () {
				$("#selectIcon").fadeOut();
			});

			$('.custom-modal-content').click(function (e) {
				e.stopPropagation();
			});
		}

        var handleSmallFlatIcon = function () {
            if ($('.selectIcon').parent('.position-relative').length < 1) {
                $('.selectIcon').each(function () {
                    var iconClass = $(this).val();
                    if (iconClass.trim() !== "") {
                        var icon = '<i class="d-inline-block ' + iconClass + '"></i>';
                    }
                    $(this).wrap('<div class="position-relative"></div>');
                    $(this).after(icon);
    
                    // Set a flag to indicate that this element has been processed
                    $(this).data('processed', true);
                });
            }
        }

        var handleASColorPicker = function () {
            // Colorpicker
		    if ($('.as_colorpicker').length > 0) {
			    
			    $(".as_colorpicker").asColorPicker({
			        mode: 'complex'
			    });
			}
			    
		    if ($('.as_colorpicker_gradient').length > 0) {
			    
			    $(".as_colorpicker_gradient").asColorPicker({
			        mode: 'gradient'
			    });
			}
        }

        var handleCustomFieldInputTypeSelect = function () {
            // Colorpicker
        	var groupedContainer = '';
        	let groupedIndex = 0;

			if ($('#customFieldInputTypeSelect').length > 0) {
			    $(document).on('change', '#customFieldInputTypeSelect', function () {

			    	if ($(this).val() == 'group') {

			    		$('#GroupFieldsContainer').show().prop('disabled', false);
			    		$('#CustomFieldFormSubPart').hide();

	    				if ($('#GroupFieldsContainer .groupFieldItems').length === 0) {
	    					addGroupField(groupedIndex);
	    					groupedIndex++;
	    				}

			    		
			    	}else{
			    		$('#GroupFieldsContainer').hide().prop('disabled', true);
			    		$('#CustomFieldFormSubPart').show();
			    	}
			    });
			    $(document).on('click', '#AddMoreGropedFields', function (e) {
			    	e.preventDefault();
		    		addGroupField(groupedIndex);
					groupedIndex++;
			    });
			    $(document).on('click', '#RemoveGroupFields', function (e) {
			    	e.preventDefault();
		    		$(this).closest('.groupFieldItems').remove();
			    });
			}
        	

        }


		function addGroupField(groupedIndex) {

		    let template = $('#GroupFieldTemplate').clone().removeAttr('id');
		    
		    // Replace %key% with actual index
		    template.find('[name]').each(function () {
		        let name = $(this).attr('name');
		        name = name.replace('%key%', groupedIndex);
		        $(this).attr('name', name);
		    });

		    // Refresh aelect picker on every add item
		    template.find('select').selectpicker('refresh');
		    
		    $('#GroupFieldsContainer').append(template);
		}


        /* ================handleFlatIcon Code js end================ */

		/* Function ============ */
		return {
			init: function () {
				handleSelectPicker();
                handleshowConfirmPass();
                handleDateTimePicker();
                handleCkEditor();
                tagify();
                handleThemeMode();
                handleLoginDetails();
                handleTwoFactorAuthForm();
                handleImgOnChange();
                handlePermalinks();
                handleUserRolePermissions();
                handleLogoutSystem();
                handleDisableImportBtn();
                handleReadingConfigs();
                handleToolsExport();
				handlePopovers();
                handleFrontendEditorIssue();
                handleImportDemoData();
                handleMakeSlug();
                handleConfigDateTimeFormat();
                handleNotificationJs();
                handleDeleteUserModal();
                handleElemetsSortable();
				handleDropzone();
                handleW3appsSearch();
                handleW3appPreviewModal();
                handleW3appInstallTheme();
                handleW3appUploadTheme();
                handleLanguages();
				handleLanguagePosition();
                handleLangTranslator();
                handleTaxonomyNameRegex();
                handleZoomElementImg();
                handleImageSelect();
                handleASColorPicker();
                handleCustomFieldInputTypeSelect();
			},

			ajax: function () {
                handleSmallFlatIcon();
				handlePopovers();
				handleSelectPicker();
				handleZoomElementImg();
				handleW3appPreviewModal();
				handleW3appInstallTheme();
				handleDependElements();
				handleCustomFieldInputTypeSelect();
			},

			load: function () {
                handleFlatIcon();
				handleSelectPicker();
				handleImageSelect();
				handleASColorPicker();
			},
		}

	}();

	/* Document.ready Start */
	jQuery(document).ready(function () {
		$('[data-bs-toggle="popover"]').popover();

		$(document).ajaxComplete(function () {
			W3cms.ajax();
		});

		W3cms.init();
	});
	/* Document.ready END */

	/* Window Load START */
	jQuery(window).on('load', function () {
		W3cms.load();
	});
	/*  Window Load END */

	/*==================== Sweet alert for delete record event start ====================*/
	/*
	* if you want to more custom text you can add data attr with deleteRecord class.
	*/
	jQuery(document).on('click', '.deleteRecord', function(){
		event.preventDefault();
		var alert_text = jQuery(this).data('alert_text');
		var link = jQuery(this).attr('href');
		deleteSweetAlert(alert_text, link);
	});

	function deleteSweetAlert(alert_text, link)
	{
		Swal.fire({
			title: 'Are you sure to delete?',
			text: alert_text,
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.value) {
				window.location.href = link;
				return true;
			} else {
				return false;
			}
		})
	}
	/*==================== Sweet alert for delete record event end ====================*/

	jQuery(document).ready(function () {
		if ($("#dz_tree").length > 0) {
			$("#dz_tree").jstree({
				"core": {
					"themes": {
						"responsive": false
					}
				},
				"types": {
					"default": {
						"icon": "fa fa-folder"
					},
					"file": {
						"icon": "fa fa-file-text"
					}
				},
				"plugins": ["types"]
			});
		}
	});

})(jQuery);