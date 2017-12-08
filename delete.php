<?php
//include("api.php");
require_once ("newConnection.php");
$itemId = $_POST['id'];


try {
    $stmt = $dbh->prepare("DELETE FROM list WHERE itemId = :itemId");
    $stmt->execute(array(':itemId' => $itemId));
    echo 'Item '.$itemId." has been deleted";
} catch(PDOException $ex)
{
    echo "Error deleting item ".$itemId;
}
//$query = "DELETE FROM list WHERE itemId = ".$itemId;
//
//if ($con->query($query)) {
//    echo 'Data Deleted';
//}
