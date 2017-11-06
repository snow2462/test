
<?php

$con= new mysqli("localhost","root","root","test");
$con->set_charset('utf8');
if (!$con)
{
    die('Could not connect: ' . $con->error());
}
?>

