<?php
include("api.php");

$itemId = $_POST['id'];

$query = "DELETE FROM list WHERE itemId = ".$itemId;

if ($con->query($query)) {
    echo 'Data Deleted';
}
