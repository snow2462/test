<?php
session_start();
error_reporting(0);
if(!isset($_SESSION["contact"]) || empty($_SESSION["contact"]))
{
    echo "<script>window.location.href='register.php';</script>";
    Header( "Location: register.php" );
}
require("mail.php");
$process = new mail_form();
include_once ("api.php");
if(isset($_POST['submit']))
{
    $_POST = $_SESSION["contact"];
    $requireValue = array(
        "memberName"=>"Name",
        "memberUsername"=> "Username",
        "password" => "Password",
        "memberEmail" => "Email");

    $requireValueCheck = $process->requireCheck($requireValue);
    if(!$requireValueCheck["empty_flag"])
    {
        $username = $_SESSION["contact"]["memberUsername"];
        $password = $_SESSION["contact"]["password"];
        $name = $_SESSION["contact"]["memberName"];
        $email = $_SESSION["contact"]["memberEmail"];
        $maxID = $con->query("SELECT MAX(memberId) AS MAX FROM `account`");
        $row = $maxID->fetch_array();
        $largestNumber = $row['MAX'];
        $largestNumber++;
        $valueExist = true;
        $query = "INSERT INTO account (`memberId`, `username`, `password`, `name`, `email`) 
            VALUES ('{$largestNumber}', '{$username}', '{$password}', '{$name}', '{$email}')";
        $con->query($query);
        if($valueExist)
        {
            echo "<scrip> window.location.href = 'complete.php#registerForm' </scrip>";
            Header("Location: complete.php#registerForm");
            exit;
        }
        else{
            $error = $emailErrorMessage;
        }
    }
    else
    {
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
<body>
<h3>Sign Up</h3>
<div id="confirm_message">
<p>Please confirm your information below.</p>
</div>

<div id="registerForm">
    <form method="post">
        <table border='1' id='user_data' >
            <tr>
                <td>Name: </td>
                <td><?php echo $_SESSION["contact"]["memberName"]?></td>
            </tr>
            <tr>
                <td>Username: </td>
                <td><?php echo $_SESSION["contact"]["memberUsername"]?></td>
            </tr>
            <tr>
                <td>Password: </td>
                <td><?php echo $_SESSION["contact"]["password"]?></td>
            </tr>

            <tr>
                <td>Email: </td>
                <td><?php echo $_SESSION["contact"]["memberEmail"]?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center"><button  type='submit' name="submit" id='registerButton'><i class="fa fa-registered"></i> Confirm</button></td>
            </tr>

        </table>
    </form>
</div>
</body>
</html>