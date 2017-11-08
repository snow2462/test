<?php
session_start();
error_reporting(0);
require("mail.php");
include_once("api.php");
$process = new mail_form();
$allowEdit = 0;
$isLogin = 1;
if (isset($_POST["log-in"])) {
    $valueExist = true;
    foreach ($_POST as $key => $value) {
        $_SESSION["contact"][$key] = $process->dataFilter($value);
    }

    $_POST = $_SESSION["contact"];
    $requireValue = array(
        'username' => 'Username',
        'password' => 'Password'
    );

    $requireValueCheck = $process->requireCheck($requireValue);
    if (!$requireValueCheck["empty_flag"]) {
        $username = $_SESSION["contact"]["username"];
        $password = $_SESSION["contact"]["password"];
        $checkUser = "SELECT * FROM account WHERE userName = '" . $username . "' AND password = '" . $password . "'";
        $queryCheck = $con->query($checkUser);
        if ($queryCheck->num_rows == 0) {
            $emailErrorMessage = "<p class =\"error_mess\" style=\"color:#C00;\">Your username or password is incorrect.</p>";
            $valueExist = false;
        }
        if ($valueExist) {
            $isLogin = 0;
            $allowEdit = 1;
        } else {
            $error = $emailErrorMessage;
        }
    }
}

?>
<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<?php if ($allowEdit != 0): ?>
    <script type="text/javascript" src="/js/script.js"></script>
<?php echo $emptyField; ?>
    <script>
        function searchFilter(page_num) {
            page_num = page_num ? page_num : 0;
            var keywords = $('#keywords').val();
            var sortBy = $('#sortBy').val();
            $.ajax({
                type: 'POST',
                url: 'display.php',
                async: false,
                data: {
                    page: page_num,
                    itemName: keywords,
                    sortBy: sortBy
                },
                success: function (html) {
                    $('#responsecontainer').html(html);
                }
            });
        }
    </script>
<?php endif; ?>
<body>

<div id="login-field">
    <?php if ($isLogin != 0): ?>
        <?php if ($error) echo "<div class='txt-contact'>" . $error . "</div>"; ?>
        <form method="post" onsubmit="return CheckValidator('login-form')" id="login-form">
            <table id="login-table">
                <tr>
                    <td><label>Username: </label></td>
                    <td><input class="requiredf" name="username" type="text" id="username"
                               msg_error="Please enter your username"
                               value="<?php echo $_SESSION["contact"]["username"] ?>"></td>
                </tr>
                <tr>
                    <td><label>Password: </label></td>
                    <td><input class="requiredf" type="password" id="password" name="password"
                               msg_error="Please enter your password" value="<?php $_SESSION["contact"]["password"] ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" id="user-login" name="log-in">Log in</button>
                    </td>
                </tr>
            </table>
        </form>
        <div>
            <button onclick="location.href= 'register.php'">Register</button>
        </div>
    <?php else: ?>
        <p>Thank you for coming back <?php echo $username; ?></p>
    <?php endif; ?>
</div>
<h3 align="center">Manage Tool Details</h3>
<div id="message">
</div>
<?php if ($allowEdit != 0): ?>
    <div class="post-search-panel">
        <input type="text" id="keywords" placeholder="Type the name of the item you are looking for"
               onkeyup="searchFilter()"/>
        <select id="sortBy" onchange="searchFilter()">
            <option value="">Sort By</option>
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select>
    </div>
<?php endif; ?>
<div id="responsecontainer" align="center">
    <p>Please login to see the information.</p>
</div>


<div id="error">
</div>
<script type="text/javascript" src="/js/inputChecking.js"></script>

</body>
</html>