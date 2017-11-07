function CheckValidator(form_id) {

    var ck_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    var ck_password = /^[a-zA-Z]\w{3,14}$/;
    var isRequired = 1;


    $("div.err_box").remove();
    $("form#" + form_id).removeClass("error_input");

    $("form#" + form_id + " .requiredf").each(function () {
        if ($(this).val() == "") {
            var name = $(this).attr("name");
            var msg_error = $(this).attr("msg_error");
            $(this).addClass("error_input");
            if(msg_error!="" && msg_error !== undefined)
            {
                $("#error_message").append("<div class='err_box'><p style='color:#C00;'>" + msg_error + "</p></div>");
            }
            isRequired = 0;
        } else
        {
            //option email, tell..
            $(this).filter(".email").each(function () {
                if (!ck_email.test($(this).val())) {
                    $(this).addClass("error_input");
                    $("#error_message").append("<div class='err_box'><p style='color:#C00;'>Please enter the correct email format</p></div>");
                    isRequired = 0;
                }
            });
            // password
            $(this).filter(".password").each(function(){
                if (!ck_password.test($(this).val())) {
                    $(this).addClass("error_input");
                    $("#error_message").append("<div class='err_box'><span style='color:#C00;'>The password's first character must be a letter, it must contain at least 4 characters and no more than 15 characters and no characters other than letters, numbers and the underscore may be used</span></div>");
                    isRequired = 0;
                }
            });
        }
    });

    if ($("div.err_box").size() > 0) {
        var top_header = $("div.err_box:first").offset().top - 150;
        $('html,body').animate({scrollTop: top_header}, 'slow');
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

