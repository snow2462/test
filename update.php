<?php
include("api.php");

    $value = $con->escape_string($_POST["value"]);
    $query = "UPDATE list SET ".$_POST["column_name"]."='".$value."' WHERE itemId = '".$_POST["id"]."'";
    if($con->query($query))
    {
        echo 'Data Updated';
    }

?>