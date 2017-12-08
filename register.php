<?php
session_start();
error_reporting(0);
require("mail.php");
include("api.php");
$process = new mail_form();

if (isset($_POST['send'])) {
    $valueExist = true;
    unset($_SESSION["contact"]);
    foreach ($_POST as $key => $value) {
        if(gettype($_POST[$key]) == "array")
        {
            foreach ($_POST[$key] as $k => $value) {
                $_SESSION["contact"][$key][] = $value;
                $tmp .= $value.", ";
                }
                $_SESSION["contact"]["$key"] = rtrim($tmp,", ");
                $tmp="";
        }
        else{
        $_SESSION["contact"][$key] = $process->dataFilter($value);
            }
    }
    $imgFile = $_FILES["user-image"]["name"];
    $tmp_dir = $_FILES["user-image"]["tmp_name"];
    $imgSize = $_FILES["user-image"]["size"];
    $upload_dir = getcwd();
    $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
    $userPic = rand(1000,100000).".".$imgExt;
    $upload_dir = $upload_dir."/upload/$userPic";
    copy($tmp_dir, $upload_dir);
//    move_uploaded_file($tmp_dir,$upload_dir.$userPic);
    $_SESSION["UPLOAD_IMGS1"] = $upload_dir;
    $newimgUpload = $_SESSION["contact"]["uploadImage"] ="upload/$userPic";
    $image_info= $_SESSION["contact"]["user-image"] = "'$newimgUpload'";




    $_POST = $_SESSION["contact"];
    $requireValue = array(
        "memberName" => "Name",
        "memberUsername" => "Username",
        "password" => "Password",
        "memberEmail" => "Email",
        "gender" => 'Gender',
        "checkbox" => 'Option'
        );
    $requireValueCheck = $process->requireCheck($requireValue);
    if (!$requireValueCheck["empty_flag"]) {
        $username = mysqli_real_escape_string($_SESSION["contact"]["memberUsername"]);
        $checkUser = "SELECT * FROM account WHERE userName = '" . $username . "'";
        $queryCheck = $con->query($checkUser);
        if ($queryCheck->num_rows > 0) {
            $emailErrorMessage = "<p class =\"error_mess\" style=\"color:#C00;\"> This username has already been taken. Please choose a different username.</p>";
            $valueExist = false;
        }

        if (!filter_var($_POST["memberEmail"], FILTER_VALIDATE_EMAIL)) {
            $emailErrorMessage = '<p class ="error_mess" style="color:#C00;"> Please enter the correct form of email</p>';
            $valueExist = false;
        }

        if ($valueExist) {
            echo "<script> window.location.href = 'confirm.php#registerForm' </script>";
            Header("Location: confirm.php#registerForm");
            exit;
        } else {
            $error = $emailErrorMessage;
        }
    } else {
        $error = $requireValueCheck["errm"];
    }
}

?>
<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<!--<script>-->
<!--    $(document).foundation();-->
<!---->
<!--    /*-->
<!--      Switch actions-->
<!--    */-->
<!--    $('.unmask').on('click', function(){-->
<!---->
<!--        if($(this).prev('input').attr('type') == 'password')-->
<!--            changeType($(this).prev('input'), 'text');-->
<!---->
<!--        else-->
<!--            changeType($(this).prev('input'), 'password');-->
<!---->
<!--        return false;-->
<!--    });-->
<!---->
<!--    function changeType(x, type) {-->
<!--        if(x.prop('type') == type)-->
<!--            return x; //That was easy.-->
<!--        try {-->
<!--            return x.prop('type', type); //Stupid IE security will not allow this-->
<!--        } catch(e) {-->
<!--            //Try re-creating the element (yep... this sucks)-->
<!--            //jQuery has no html() method for the element, so we have to put into a div first-->
<!--            var html = $("<div>").append(x.clone()).html();-->
<!--            var regex = /type=(\")?([^\"\s]+)(\")?/; //matches type=text or type="text"-->
<!--            //If no match, we add the type attribute to the end; otherwise, we replace-->
<!--            var tmp = $(html.match(regex) == null ?-->
<!--                html.replace(">", ' type="' + type + '">') :-->
<!--                html.replace(regex, 'type="' + type + '"') );-->
<!--            //Copy data from old element-->
<!--            tmp.data('type', x.data('type') );-->
<!--            var events = x.data('events');-->
<!--            var cb = function(events) {-->
<!--                return function() {-->
<!--                    //Bind all prior events-->
<!--                    for(i in events)-->
<!--                    {-->
<!--                        var y = events[i];-->
<!--                        for(j in y)-->
<!--                            tmp.bind(i, y[j].handler);-->
<!--                    }-->
<!--                }-->
<!--            }(events);-->
<!--            x.replaceWith(tmp);-->
<!--            setTimeout(cb, 10); //Wait a bit to call function-->
<!--            return tmp;-->
<!--        }-->
<!--    }-->
<!---->
<!---->
<!--</script>-->
<body>
<h3>Sign Up</h3>
<div id="error_message">

</div>
<div id="registerForm">
    <?php if ($error) echo "<div class='txt-contact'>" . $error . "</div>"; ?>
    <form method="post" id='regisForm' name='regisForm' onsubmit="return CheckValidator('regisForm')"
          action="register.php#registerForm" enctype="multipart/form-data" >
        <table border='1' id='user_data' width="50%">
            <tr>
                <td>Name:</td>
                <td colspan="2"><input type='text' id='memberName' name="memberName" msg_error="Please enter your name"
                                       class="requiredf" value="<?php echo $_SESSION["contact"]["memberName"] ?>"></td>
            </tr>
            <tr>
                <td>Username:</td>
                <td colspan="2"><input type='text' id='memberUsername' name="memberUsername"
                                       msg_error="Please enter your username" class="requiredf"
                                       value="<?php echo $_SESSION["contact"]["memberUsername"] ?>"></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td colspan="2"><input type='text' name="password" id='memberPassword'
                                       msg_error="Please enter your password" class="requiredf password"
                                       value="<?php echo $_SESSION["contact"]["memberPassword"] ?>">
                </td>
            </tr>

            <tr>
                <td>Email:</td>
                <td colspan="2"><input type='text' id='memberEmail' name="memberEmail"
                                       msg_error="Please enter your email" class="requiredf email"
                                       value="<?php echo $_SESSION["contact"]["memberEmail"] ?>"></td>
            <tr>
                <td>Gender:</td>
                <td><input type="radio" name="gender" <?php if ($_SESSION["contact"]["gender"]) {
                        echo ($_SESSION["contact"]["gender"] == "male") ? "checked" : " ";
                    } ?> value="male"/>Male
                </td>
                <td><input type="radio" name="gender" <?php echo ($_SESSION["contact"]["gender"] == "female") ?: " "; ?>
                           value="female"/>Female
                </td>
            </tr>
            <tr>
                <td>Option:</td>
                <?php $value_checked = explode(', ', $_SESSION["contact"]["checkbox"]); ?>
                <td colspan="2">
                    <label style="display: block">
                        <input type="checkbox"
                               name="checkbox[]" <?php echo (in_array('Saw')) ? "checked" : " "; ?>
                               value="Saw"/>Saw
                    </label>
                    <label style="display: block">
                        <input type="checkbox"
                               name="checkbox[]" <?php echo (in_array('Drill')) ? "checked" : " "; ?>
                               value="Drill"/>Drill
                    </label>
                </td>

            </tr>
            <tr>
                <td>Image:</td>
                <td colspan="2"><input type="file" accept="image/" name="user-image" onchange="document.getElementById('send').disabled=false;" /></td>
            </tr>
            <tr>
                <?php if(!$image_info):?>
                <td colspan="3" style="text-align: center">
                    <button type='submit' name="send" id='send'><i class="fa fa-registered"></i> Submit</button>
                </td>
                <?php else:?>
                <td colspan="3" style="text-align: center">
                <?php echo $image_info;?>
                </td>
                <?php endif?>
            </tr>

        </table>
    </form>
</div>
<script type="text/javascript" src="/js/form.js"></script>
</body>
</html>