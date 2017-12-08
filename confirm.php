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
include("newConnection.php");
if(isset($_POST['submit']))
{
    $_POST = $_SESSION["contact"];
    $requireValue = array(
        "memberName"=>"Name",
        "memberUsername"=> "Username",
        "password" => "Password",
        "memberEmail" => "Email",
        'gender' => 'Gender',
        'checkbox' => 'option'
    );

    $requireValueCheck = $process->requireCheck($requireValue);
    if(!$requireValueCheck["empty_flag"])
    {
        $username = $_SESSION["contact"]["memberUsername"];
        $password = $_SESSION["contact"]["password"];
        $name = $_SESSION["contact"]["memberName"];
        $email = $_SESSION["contact"]["memberEmail"];
        $gender = $_SESSION["contact"]["gender"];
        $option = $_SESSION["contact"]["checkbox"];
        $image = $_SESSION["contact"]["uploadImage"];
        $hash = md5(rand(0,1000));
        $activate = 0;
        $maxID = $dbh->query("SELECT MAX(memberId) AS MAX FROM `account`");
        $row = $maxID->fetchAll(PDO::FETCH_ASSOC);
        $largestNumber = $row[0]['MAX'];
        $largestNumber++;
        $valueExist = true;
        $query = $dbh->prepare("INSERT INTO account (`memberId`, `username`, `password`, `name`, `email`, `gender`, `option`, `hash`, `activate`, `image`)
            VALUES (:largestNumber, :username, :password, :memberName, :email, :gender, :memberOption, :hash, :activate, :image)");
        $query->execute(array(
                ':largestNumber' => $largestNumber,
                ':username' => $username,
                ':password' => $password,
                ':memberName' => $name,
                ':email' => $email,
                ':gender' => $gender,
                ':memberOption' => $option,
                ':hash' => $hash,
                ':activate' => $activate,
                ':image' => $_SESSION["contact"]["uploadImage"]
        ));
        if($valueExist)
        {
            unset($_POST);
            unset($_SESSION["contact"]);
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
                <td>Gender: </td>
                <td><?php echo $_SESSION["contact"]["gender"]?></td>
            </tr>
            <tr>
                <td>Option: </td>
                <td><?php echo $_SESSION["contact"]["checkbox"]?></td>
            </tr>
            <tr>
                <td>Image: </td>
                <td><img src=<?php echo $_SESSION["contact"]["user-image"]?> width="300" height="100" /></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center"><button  type='submit' name="submit" id='registerButton'><i class="fa fa-registered"></i> Confirm</button></td>
            </tr>

        </table>
    </form>
</div>
</body>
</html>