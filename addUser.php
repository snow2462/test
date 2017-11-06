<?php
include ('api.php');

if(isset($_POST['done'])){
    $name = $con->escape_string($_POST['name']);
    $userName = $con->escape_string($_POST['username']);
    $email = $con->escape_string($_POST['email']);
    $password = $con->escape_string($_POST['password']);

    $result = $con->query("INSERT INTO account (`username`, `password`, `name`, `email`) 
                            VALUES ('{$userName}' , '{$password}' ,  '{$name}' , '{$email}')");

    if($result)
    {
        echo "<p>Thank you for registering. An email will be sent to you in the next 24 hour. To complete registration please click on the confirm link in your email. </p>";
    }
    else
    {
        echo "<p>Something is wrong with the system. Please try again later.</p>";
    }


}