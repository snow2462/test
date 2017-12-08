<?php
include('/class/Pagination.php');
include("newConnection.php");

// determine the page number
$start = !empty($_POST['page']) ? $_POST['page'] : 0;
$limit = 10;
global $whereSQL;
global $orderSQL;
if (isset($_POST['itemName'])) {
    $whereSQL = $orderSQL = '';

    $keywords = $_POST['itemName'];

    $sortBy = $_POST['sortBy'];

    $whereSQL = "WHERE itemName LIKE '%" . $keywords . "%'";

    if ($sortBy != 'desc') {
        $orderSQL = " ORDER BY itemId " . $sortBy;
    } else {
        $orderSQL = " ORDER BY itemId DESC ";
    }
}
try{
  $stmt = $dbh->query("SELECT COUNT(*) AS itemId FROM list");
  $resultNum = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $exception)
{
    echo "An error occurred";
}

// get the number of rows
//$queryNum = $con->query("SELECT COUNT(*) as itemId FROM list");
//$resultNum = $queryNum->fetch_assoc();
$rowCount = $resultNum['itemId'];


// Initialize pagination class
$pageConfig = array(
    'baseURL' => 'display.php',
    'currentPage' => $start,
    'totalRows' => $rowCount,
    'perPage' => $limit,
    'link_func' => 'searchFilter',
    'contentDiv' => 'responsecontainer');
$pagination = new Pagination($pageConfig);

// get rows
$result = $dbh->query("SELECT * FROM list " . $whereSQL . $orderSQL . " LIMIT " . $start . " , " . $limit);
//$result = $con->query("SELECT * FROM list " . $whereSQL . $orderSQL . " LIMIT " . $start . " , " . $limit);
$maxID = $dbh->query("SELECT MAX(itemId) AS MAX FROM `list`");
//$maxID = $con->query("SELECT MAX(itemId) AS MAX FROM `list`");
$row = $maxID->fetchAll(PDO::FETCH_ASSOC);
$largestNumber = $row[0]["MAX"];
$largestNumber++;

if ($rowCount > 0) {
    echo "
<table border='1' id='user_data' >
<tr>
<td align=center><b>ID</b></td>
<td align=center> <b>Name</b></td>
<td align=center><b>Description</b></td>
<td align=center><b>Price</b></td>
<td align=center><b>Availabity</b></td>
<td align=center><b>Edit</b></td>
<td align=center><b>Delete</b></td>";


    while ($data = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td contenteditable class=\"update\" data-id=".$data['itemId']." data-column='itemId' align=center>".$data['itemId']."</td>";
        echo "<td contenteditable class=\"update\" data-id=".$data['itemId']." data-column='itemName' align=center>".$data['itemName']."</td>";
        echo "<td contenteditable class=\"update\" data-id=".$data['itemId']." data-column='description' >".$data['description']."</td>";
        echo "<td contenteditable class=\"update\" data-id=".$data['itemId']." data-column='price' align=center>".$data['price']."</td>";
        echo "<td contenteditable class=\"update\" data-id=".$data['itemId']." data-column='availability' align=center>".$data['availability']."</td>";
        echo "<td  data-id=".$data['itemId']." align=center >
<form action = \"\" method = \"post\">
<input type='submit' data-id=".$data['itemId']." name='edit' id='edit' class='edit' value=".$data['itemId'].">
</form></td>";
        echo "<td data-id=".$data['itemId']." align=center ><button data-id=".$data['itemId']." id='delete' value='Delete' class='delete'><i class=\"fa fa-trash\"></i></button></td>";
        echo "</tr>";

    }
    echo "
<tr>
<td><input type=\"text\" id=\"itemId\" value='" . $largestNumber . "' onkeypress=\"return checknumber(event,'itemId')\"></td>
<td><input type=\"text\" id=\"name\"></td>
<td><input type=\"text\" id=\"description\"></td>
<td><input type=\"text\" id=\"price\" onkeypress=\"return checknumber(event,'price')\"></td>
<td><input type=\"text\" id=\"availability\" onkeypress=\"return checknumber(event,'availability')\"></td>
<td align=center colspan='2'><button id=\"submit\" value=\"Add\"><i class=\"fa fa-plus\"></i></button></td>
</tr>";
    echo "</table>
";

    echo $pagination->createLinks();
}
?>
