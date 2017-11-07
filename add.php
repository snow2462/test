<?php
include("api.php");

if (isset($_POST['done'])) {
    $id = $con->escape_string($_POST['id']);
    $name = $con->escape_string($_POST['itemName']);
    $description = $con->escape_string($_POST['description']);
    $price = $con->escape_string($_POST['price']);
    $availability = $con->escape_string($_POST['availability']);
    $checkItem = "SELECT * FROM list WHERE itemName = '" . $name . "'";
    $queryCheck = $con->query($checkItem);
    if ($queryCheck->num_rows > 0) {
        echo "Item has already existed in database";
    } else {
        $con->query("INSERT IGNORE INTO list (`itemId`, `itemName`, `description`, `price`, `availability`)
                            VALUES('{$id}','{$name}', '{$description}', '{$price}', '{$availability}')");
        echo 'The item ' .$name . ' has been inserted to database';
    }
}


