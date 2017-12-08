<?php
include("api.php");
include('newConnection.php');
if (isset($_POST['done'])) {
    $id = $_POST['id'];
    $name = $_POST['itemName'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $availability = $_POST['availability'];
    $checkItem = $dbh->prepare("SELECT * FROM list WHERE itemName = :itemName");
    $checkItem->execute(array(':itemName' => $name));
    if ($checkItem->rowCount() > 0) {
        echo "Item has already existed in database";
    } else {
        $addItem = $dbh->prepare("INSERT INTO list(`itemId`, `itemName`, `description`, `price`, `availability`) VALUES(:itemId,:itemName,:description,:price,:availability)");
        $addItem->execute(array(
            ':itemId' => $id,
            ':itemName' => $name,
            ':description' => $description,
            ':price' => $price,
            ':availability' => $availability));
        echo 'The item ' .$name . ' has been inserted to database';
    }
}


