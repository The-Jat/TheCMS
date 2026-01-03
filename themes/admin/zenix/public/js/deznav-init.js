var themeOptionArr = {
	typography: '',
	version: '',
	layout: '',
	primary: '',
	headerBg: '',
	navheaderBg: '',
	sidebarBg: '',
	sidebarStyle: '',
	sidebarPosition: '',
	headerPosition: '',
	containerLayout: '',
	direction: '',
};

function getUrlParams(dParam) {
	var dPageURL = window.location.search.substring(1),
		dURLVariables = dPageURL.split('&'),
		dParameterName,
		i;

	for (i = 0; i < dURLVariables.length; i++) {
		dParameterName = dURLVariables[i].split('=');

		if (dParameterName[0] === dParam) {
			return dParameterName[1] === undefined ? true : decodeURIComponent(dParameterName[1]);
		}
	}
}

/* Cookies Function */
function setCookie(cname, cvalue, exhours) {
	var d = new Date();
	d.setTime(d.getTime() + (30 * 60 * 1000)); /* 30 Minutes */
	var expires = "expires=" + d.toString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for (var i = 0; i < ca.length; i++) {
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

function deleteCookie(cname) {
	var d = new Date();
	d.setTime(d.getTime() + (1)); // 1/1000 second
	var expires = "expires=" + d.toString();
	//document.cookie = cname + "=1;" + expires + ";path=/";
	document.cookie = cname + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT" + ";path=/";
}

function deleteAllCookie(reload = true) {
	jQuery.each(themeOptionArr, function (optionKey, optionValue) {
		deleteCookie(optionKey);
	});
	if (reload) {
		location.reload();
	}
}

/* Cookies Function END */


(function ($) {

	"use strict"

	var direction = getUrlParams('dir');
	var theme = getUrlParams('theme');

	/* Dz Theme Demo Settings  */

	var dzThemeSet0 = { /* Default Theme */
		typography: "poppins",
		version: "light",
		layout: "vertical",
		headerBg: "color_1",
		primary: "color_1",
		navheaderBg: "color_1",
		sidebarBg: "color_1",
		sidebarStyle: "full",
		sidebarPosition: "fixed",
		headerPosition: "fixed",
		containerLayout: "full",
		direction: direction
	};

	var dzThemeSet1 = {
		typography: "poppins",
		version: "light",
		layout: "vertical",
		primary: "color_15",
		headerBg: "color_1",
		navheaderBg: "color_13",
		sidebarBg: "color_13",
		sidebarStyle: "full",
		sidebarPosition: "fixed",
		headerPosition: "fixed",
		containerLayout: "full",
		direction: direction
	};

	var dzThemeSet2 = {
		typography: "poppins",
		version: "light",
		layout: "vertical",
		primary: "color_7",
		headerBg: "color_1",
		navheaderBg: "color_7",
		sidebarBg: "color_1",
		sidebarStyle: "modern",
		sidebarPosition: "static",
		headerPosition: "fixed",
		containerLayout: "full",
		direction: direction
	};


	var dzThemeSet3 = {
		typography: "poppins",
		version: "light",
		layout: "horizontal",
		primary: "color_3",
		headerBg: "color_1",
		navheaderBg: "color_1",
		sidebarBg: "color_3",
		sidebarStyle: "full",
		sidebarPosition: "fixed",
		headerPosition: "fixed",
		containerLayout: "full",
		direction: direction
	};

	var dzThemeSet4 = {
		typography: "poppins",
		version: "light",
		layout: "vertical",
		primary: "color_9",
		headerBg: "color_9",
		navheaderBg: "color_9",
		sidebarBg: "color_1",
		sidebarStyle: "compact",
		sidebarPosition: "fixed",
		headerPosition: "fixed",
		containerLayout: "full",
		direction: direction
	};

	var dzThemeSet5 = {
		typography: "poppins",
		version: "light",
		layout: "vertical",
		primary: "color_7",
		headerBg: "color_1",
		navheaderBg: "color_7",
		sidebarBg: "color_7",
		sidebarStyle: "icon-hover",
		sidebarPosition: "fixed",
		headerPosition: "fixed",
		containerLayout: "full",
		direction: direction
	};

	var dzThemeSet6 = {
		typography: "poppins",
		version: "light",
		layout: "vertical",
		primary: "color_3",
		headerBg: "color_3",
		navheaderBg: "color_1",
		sidebarBg: "color_1",
		sidebarStyle: "mini",
		sidebarPosition: "fixed",
		headerPosition: "fixed",
		containerLayout: "full",
		direction: direction
	};

	var dzThemeSet7 = {
		typography: "poppins",
		version: "light",
		layout: "vertical",
		primary: "color_2",
		headerBg: "color_1",
		navheaderBg: "color_2",
		sidebarBg: "color_2",
		sidebarStyle: "mini",
		sidebarPosition: "fixed",
		headerPosition: "fixed",
		containerLayout: "full",
		direction: direction
	};

	var dzThemeSet8 = {
		typography: "poppins",
		version: "light",
		layout: "vertical",
		primary: "color_2",
		headerBg: "color_14",
		navheaderBg: "color_14",
		sidebarBg: "color_2",
		sidebarStyle: "full",
		sidebarPosition: "fixed",
		headerPosition: "fixed",
		containerLayout: "full",
		direction: direction
	};

	function themeChange(theme, direction) {
		var themeSettings = {};
		themeSettings = eval('dzThemeSet' + theme);
		themeSettings.direction = direction;
		dzSettingsOptions = themeSettings; /* For Screen Resize */
		new dzSettings(themeSettings);

	}

	function setThemeLogo() {
		var logo = getCookie('logo_src');

		var logo2 = getCookie('logo_src2');

		if (logo != '') {
			jQuery('.nav-header .logo-abbr').attr("src", logo);
		}

		if (logo2 != '') {
			jQuery('.nav-header .logo-compact, .nav-header .brand-title').attr("src", logo2);
		}
	}

	function setThemeOptionOnPage() {
		if (getCookie('version') != '') {
			jQuery.each(themeOptionArr, function (optionKey, optionValue) {
				var optionData = getCookie(optionKey);
				themeOptionArr[optionKey] = (optionData != '') ? optionData : dzSettingsOptions[optionKey];
			});
			dzSettingsOptions = themeOptionArr;
			new dzSettings(dzSettingsOptions);

			setThemeLogo();
		}
	}

	jQuery(document).on('click', '.AdminLayout', function () {
		var demoTheme = jQuery(this).val();
		themeChange(demoTheme, 'ltr');
	});

	jQuery(document).ready(function () {
		direction = (direction != undefined) ? direction : 'ltr';
		new dzSettings(dzSettingsOptions);

	});

	jQuery(window).on('resize', function () {
		direction = (direction != undefined) ? direction : 'ltr';
		new dzSettings(dzSettingsOptions);
	});

	const typographySelect = $('#typography');
	const versionSelect = $('#theme_version');
	const layoutSelect = $('#theme_layout');
	const sidebarStyleSelect = $('#sidebar_style');
	const sidebarPositionSelect = $('#sidebar_position');
	const headerPositionSelect = $('#header_position');
	const containerLayoutSelect = $('#container_layout');
	const themeDirectionSelect = $('#theme_direction');

	//change the theme typography controller
	typographySelect.on('change', function () {
		body.attr('data-typography', this.value);
	});

	//change the theme version controller
	versionSelect.on('change', function () {
		body.attr('data-theme-version', this.value);

		if (this.value === 'light') {
			jQuery(".nav-header .logo-abbr").attr("src", "../../../public/images/logo-white.png");
			jQuery(".nav-header .logo-compact").attr("src", "../../../public/images/logo-text.png");
			jQuery(".nav-header .brand-title").attr("src", "../../../public/images/logo-text.png");
		} else {
			jQuery(".nav-header .logo-abbr").attr("src", "../../../public/images/logo-white.png");
			jQuery(".nav-header .logo-compact").attr("src", "../../../public/images/logo-text-white.png");
			jQuery(".nav-header .brand-title").attr("src", "../../../public/images/logo-text-white.png");
		}

	});



	//change the sidebar position controller
	sidebarPositionSelect.on('change', function () {
		this.value === "fixed" && body.attr('data-sidebar-style') === "modern" && body.attr('data-layout') === "vertical" ?
			alert("Sorry, Modern sidebar layout dosen't support fixed position!") :
			body.attr('data-sidebar-position', this.value);
	});

	//change the header position controller
	headerPositionSelect.on('change', function () {
		if(this.value == 'fixed'){
			$('.deznav').removeClass('fixed');
		}else{
			$('.deznav').addClass('fixed');
		}
		body.attr('data-header-position', this.value);
	});

	//change the theme layout controller
	layoutSelect.on('change', function () {
		if (body.attr('data-sidebar-style') === 'overlay') {
			body.attr('data-sidebar-style', 'full');
			body.attr('data-layout', this.value);
			return;
		}

		body.attr('data-layout', this.value);
	});

	//change the container layout controller
	containerLayoutSelect.on('change', function () {
		if (this.value === "boxed") {

			if (body.attr('data-layout') === "vertical" && body.attr('data-sidebar-style') === "full") {
				body.attr('data-sidebar-style', 'overlay');
				body.attr('data-container', this.value);

				setTimeout(function () {
					$(window).trigger('resize');
				}, 200);

				return;
			}


		}

		body.attr('data-container', this.value);
		setCookie('containerLayout', this.value);
	});

	//change the sidebar style controller
	sidebarStyleSelect.on('change', function () {
		if (body.attr('data-layout') === "horizontal") {
			if (this.value === "overlay") {
				alert("Sorry! Overlay is not possible in Horizontal layout.");
				return;
			}
		}

		if (body.attr('data-layout') === "vertical") {
			if (body.attr('data-container') === "boxed" && this.value === "full") {
				alert("Sorry! Full menu is not available in Vertical Boxed layout.");
				return;
			}

			if (this.value === "modern" && body.attr('data-sidebar-position') === "fixed") {
				alert("Sorry! Modern sidebar layout is not available in the fixed position. Please change the sidebar position into Static.");
				return;
			}
		}

		body.attr('data-sidebar-style', this.value);

		if (body.attr('data-sidebar-style') === 'icon-hover') {
			$('.deznav').on('hover', function () {
				$('#main-wrapper').addClass('iconhover-toggle');
			}, function () {
				$('#main-wrapper').removeClass('iconhover-toggle');
			});
		}
	});

	jQuery("#nav_header_color_1").on('click', function () {
		jQuery(".nav-header .logo-abbr").attr("src", "../../../public/images/logo.png");
		jQuery(".nav-header .brand-title").attr("src", "../../../public/images/logo-text.png");
	});

	jQuery("#nav_header_color_2, #nav_header_color_3, #nav_header_color_4, #nav_header_color_5, #nav_header_color_6, #nav_header_color_7, #nav_header_color_8, #nav_header_color_9, #nav_header_color_10, #nav_header_color_11, #nav_header_color_12, #nav_header_color_13, #nav_header_color_14, #nav_header_color_15").on('click', function () {
		jQuery(".nav-header .logo-abbr").attr("src", "../../../public/images/logo-white.png");
		jQuery(".nav-header .brand-title").attr("src", "../../../public/images/logo-text-white.png");
	});

	jQuery("#nav_header_color_3").on('click', function () {
		jQuery(".nav-header .logo-abbr").attr("src", "../../../public/images/logo-white.png");
		jQuery(".nav-header .brand-title").attr("src", "../../../public/images/logo-text-white.png");
	});


	//change the nav-header background controller
	$('input[name="navigation_header"]').on('click', function () {
		body.attr('data-nav-headerbg', this.value);
	});

	//change the header background controller
	$('input[name="header_bg"]').on('click', function () {
		body.attr('data-headerbg', this.value);
	});

	//change the sidebar background controller
	$('input[name="sidebar_bg"]').on('click', function () {
		body.attr('data-sidebar_bg', this.value);
	});

	//change the primary color controller
	$('input[name="primary_bg"]').on('click', function () {
		body.attr('data-primary', this.value);
	});

})(jQuery);