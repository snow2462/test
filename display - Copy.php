<?php
include("api.php");
// determine the page number
$page = 1;
if (!empty($_GET['page'])) {
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    if ($page == false) {
        $page = 1;
    }
}

// set number of displayed items
$item = 10;

$offset = ($page - 1) * $item;
$result = "SELECT * FROM list LIMIT " . $offset . "," . $item;
$getRow = $con->query($result);
$sql = "SELECT itemId FROM list";
$result2 = $con->query($sql);

if ($result2 == false) {
    throw new Exception('Query failed with: ' . $con->error());
} else {
    $row_count = mysqli_num_rows($result2);
    mysqli_free_result($result2);
}

$page_count = 0;
if($row_count == 0)
{
    echo "There is no data in database";
}
else {
    $page_count = (int)ceil($row_count / $item);
    if($page > $page_count)
    {
        $page = 1;
    }
}

$maxID = $con->query("SELECT MAX(itemId) AS MAX FROM `list`");
$row = $maxID->fetch_array();
$largestNumber = $row['MAX'];
$largestNumber++;

echo "
<table border='1' id='user_data' >
<tr>
<td align=center><b>ID</b></td>
<td align=center> <b>Name</b></td>
<td align=center><b>Description</b></td>
<td align=center><b>Price</b></td>
<td align=center><b>Availabity</b></td>
<td align=center><b>Delete</b></td>";


while ($data = $getRow->fetch_row()) {
    echo "<tr>";
    echo "<td contenteditable class=\"update\" data-id=$data[0] data-column='itemId' align=center>$data[0]</td>";
    echo "<td contenteditable class=\"update\" data-id=$data[0] data-column='itemName' align=center>$data[1]</td>";
    echo "<td contenteditable class=\"update\" data-id=$data[0] data-column='description' >$data[2]</td>";
    echo "<td contenteditable class=\"update\" data-id=$data[0] data-column='price' align=center>$data[3]</td>";
    echo "<td contenteditable class=\"update\" data-id=$data[0] data-column='availability' align=center>$data[4]</td>";
    echo "<td contenteditable class=\"update\" data-id=$data[0] align=center ><button data-id=$data[0] id='delete' value='Delete' class='delete'><i class=\"fa fa-trash\"></i></button></td>";
    echo "</tr>";

}
echo "
<tr>
<td><input type=\"text\" id=\"itemId\" value='" . $largestNumber . "' onkeypress=\"return checknumber(event,'itemId')\"></td>
<td><input type=\"text\" id=\"name\"></td>
<td><input type=\"text\" id=\"description\"></td>
<td><input type=\"text\" id=\"price\" onkeypress=\"return checknumber(event,'price')\"></td>
<td><input type=\"text\" id=\"availability\" onkeypress=\"return checknumber(event,'availability')\"></td>
<td align=center><button id=\"submit\" value=\"Add\"><i class=\"fa fa-plus\"></i></button></td>
</tr>";
echo "</table>";

for($i =1; $i<= $page_count; $i++)
{
    if($i == $page)
    {

        echo 'Page ' . $i;
    }
    else{
        if($page > 1) {
            echo '<a href="\">Page 1 </a>';
        }
        else{
            ?>
            <?php
            echo '<a href="javascript:void(0);" onclick="">Page ' . $i . '</a>';
        }
    }
}
?>
