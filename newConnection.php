<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 11/21/2017
 * Time: 10:08 AM
 */
$dbh = new PDO('mysql:host=localhost;dbname=test;charset=utf8;', 'root', 'root');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // THROW EXCEPTION
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES,  false); //Enables or disables emulation of prepared statements. Some drivers do not support native prepared statements or have limited support for them. Use this setting to force PDO to either always emulate prepared statements (if TRUE and emulated prepares are supported by the driver), or to try to use native prepared statements (if FALSE). It will always fall back to emulating the prepared statement if the driver cannot successfully prepare the current query. Requires bool.

//
//try{
//    $stmt = $dbh->query("SELECT * FROM list");
//    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//        echo $row['itemId'].' '.$row['itemName'].' '.$row['description'].' '.$row['price'].' '.$row['availability']. '<br/>';
//    }
//    $itemId = 5;
//    $stmt1 = $dbh->prepare("SELECT * FROM list WHERE itemId=?");
//    $stmt1->execute(array($itemId));
//
//    $rows = $stmt1->fetchAll(PDO::FETCH_ASSOC);
//    var_dump($rows);
//} catch(PDOException $ex){
//    echo "An error occurred";
//}
