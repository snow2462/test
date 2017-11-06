function checknumber(evt, objectid) {

    var key = (!window.ActiveXObject) ? evt.which : window.event.keyCode;
    var values = document.getElementById(objectid).value;
    if ((key < 48 || key > 57) && key != 8 && key != 0 && key != 46) return false;
    return true;
}

function CheckValidator(form_id) {
    var isRequired = 1;

    jQuery("td.err_box").remove();
    jQuery("form#" + form_id).removeClass("error_input");

    jQuery("form#" + form_id + " .requiredf").each(function () {
        if (jQuery(this).val() == "") {
            var name = jQuery(this).attr("name");
            var msg_error = jQuery(this).attr("msg_error");
            jQuery(this).addClass("error_input");
            if(msg_error!="" && msg_error !== undefined)
            {
                jQuery(this).parent().parent().append("<td class='err_box'><p style='color:#C00;font-weight:bold'>" + msg_error + "</p></td>");
            }
            isRequired = 0;
        }
    });

    if (jQuery("div.err_box").size() > 0) {
        var top_header = jQuery("div.err_box:first").offset().top - 150;
        jQuery('html,body').animate({scrollTop: top_header}, 'slow');
        return false;
    }

    if (isRequired)
    {
        return true;
    } else
    {
        return false;
    }
}

