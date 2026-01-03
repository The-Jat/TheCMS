(function($) { 
    
    "use strict";

    function handleAlert(argument) {
        var x = document.getElementById('error_alert');
        var y = document.getElementById('close_alert');
        if (typeof(y) !== undefined && y != null) {
            y.onclick = function() {
                x.style.display = "none";
            };
        }
    }

    function handleCheckEnvironment() {

        jQuery('#environment').on('change', function() {
            var val = jQuery(this).val();
            if(val=='other') {
                jQuery('#environment_text_input').removeClass('d-none');
            } else {
                jQuery('#environment_text_input').addClass('d-none');
            }
        })
    }

    jQuery('.DB-InstallationBtn').on('click', function(){
        jQuery(this).append('<i class="fa fa-spinner fa-spin"></i>');
        jQuery(this).addClass('disabled');
    });


    jQuery(document).ready(function() {
        handleAlert();
        handleCheckEnvironment();
    });

})(jQuery);