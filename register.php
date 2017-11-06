<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<!--<script type="text/javascript" >-->
<!--    $(document).on('click', '#registerButton', function () {-->
<!--        var memberName = $("#memberName").val();-->
<!--        var username = $("#memberUsername").val();-->
<!--        var memberPass = $("#memberPassword").val();-->
<!--        var email = $("#memberEmail").val();-->
<!--        $.ajax({-->
<!--            url: 'addUser.php',-->
<!--            type: 'post',-->
<!--            async: false,-->
<!--            data: {-->
<!--                "done": 1,-->
<!--               "name": memberName,-->
<!--               "username": username,-->
<!--               "password": memberPass,-->
<!--               "email": email-->
<!--            },-->
<!--            success: function(data){-->
<!--                $("#registerForm").html('');-->
<!--                $("#registerForm").html(data);-->
<!--    }-->
<!--        });-->
<!--    });-->
<!--</script>-->
<script>
    $(document).foundation();

    /*
      Switch actions
    */
    $('.unmask').on('click', function(){

        if($(this).prev('input').attr('type') == 'password')
            changeType($(this).prev('input'), 'text');

        else
            changeType($(this).prev('input'), 'password');

        return false;
    });

    function changeType(x, type) {
        if(x.prop('type') == type)
            return x; //That was easy.
        try {
            return x.prop('type', type); //Stupid IE security will not allow this
        } catch(e) {
            //Try re-creating the element (yep... this sucks)
            //jQuery has no html() method for the element, so we have to put into a div first
            var html = $("<div>").append(x.clone()).html();
            var regex = /type=(\")?([^\"\s]+)(\")?/; //matches type=text or type="text"
            //If no match, we add the type attribute to the end; otherwise, we replace
            var tmp = $(html.match(regex) == null ?
                html.replace(">", ' type="' + type + '">') :
                html.replace(regex, 'type="' + type + '"') );
            //Copy data from old element
            tmp.data('type', x.data('type') );
            var events = x.data('events');
            var cb = function(events) {
                return function() {
                    //Bind all prior events
                    for(i in events)
                    {
                        var y = events[i];
                        for(j in y)
                            tmp.bind(i, y[j].handler);
                    }
                }
            }(events);
            x.replaceWith(tmp);
            setTimeout(cb, 10); //Wait a bit to call function
            return tmp;
        }
    }


</script>
<body>
<h3>Sign Up</h3>
<div id="error_message">

</div>
<div id="registerForm">
<form method="post" id='regisForm' name='regisForm' onsubmit="return CheckValidator('regisForm')" action="register.php#registerForm">
<table border='1' id='user_data' >
<tr>
<td>Name: </td>
<td><input type='text' id='memberName' msg_error="Please enter your name" class="requiredf"></td>
</tr>
<tr>
<td>Username: </td>
<td><input type='text' id='memberUsername' msg_error="Please enter your username" class="requiredf"></td>
</tr>
<tr>
<td>Password: </td>
<td><input type='text' name="password" id='memberPassword' msg_error="Please enter your password" class="requiredf password">
</td>
</tr>

<tr>
<td>Email: </td>
<td><input type='text' id='memberEmail' msg_error="Please enter your email" class="requiredf email"></td>
</tr>
    <tr>
        <td colspan="2" style="text-align: center"><button  type='submit' id='registerButton'><i class="fa fa-registered"></i> Submit</button></td>
    </tr>

</table>
</form>
</div>
<script type="text/javascript" src="/js/form.js"></script>
</body>
</html>