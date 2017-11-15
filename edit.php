<?php
session_start();
error_reporting(0);
include_once("api.php");
require("mail.php");
$process = new mail_form();
include_once ("api.php");
$itemId = $_SESSION["id"];
$query = "SELECT * FROM list WHERE itemId = " . $itemId["edit"];
$result = $con->query($query);
 if(isset($_POST["edit"]))
 {

     foreach ($_POST as $key => $value) {
         $_SESSION["contact"][$key] = $process->dataFilter($value);
     }
     $_POST = $_SESSION["contact"];
     $requireValue = array(
         "id"=>"ID",
         "name"=> "Name",
         "description" => "Description",
         "price" => "Price",
         "availability" => "Availability");
     $requireValueCheck = $process->requireCheck($requireValue);

    if(!$requireValueCheck["empty_flag"])
    {
        $name = $_POST["name"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $availability = $_POST["availability"];
        $id = $_POST["id"];
        $valueExist = true;
        $query = "UPDATE list SET 
                  itemName = '" .$name. "',
                  description = '".$description."',
                  price = '".$price."',
                  availability = '".$availability."'
                  WHERE itemId = '" .$id."'";
        $queryCheck = $con->query($query);
        if(!$queryCheck){
            $emailErrorMessage = "<p class =\"error_mess\" style=\"color:#C00;\">Something went wrong.</p>";
            $valueExist = false;
        }
        if($valueExist)
        {
            $_SESSION["contact"]["state"] = 'edit';
            echo "<scrip> window.location.href = 'CompleteEdit.php' </scrip>";
            Header("Location: CompleteEdit.php");
            exit;
        }
        else{
            $error = $emailErrorMessage;
        }
    }
    else
    {
        $error = $requireValueCheck["errm"];
    }
 }
 elseif($_POST["delete"]){
     $id = $_POST["id"];
     $valueExist = true;
     $query = "DELETE FROM list WHERE itemId = '" .$id."'";
     $queryCheck = $con->query($query);
     if(!$queryCheck){
         $emailErrorMessage = "<p class =\"error_mess\" style=\"color:#C00;\">Failed to delete item.</p>";
         $valueExist = false;
     }
     if($valueExist)
     {
         $_SESSION["contact"]["state"] = 'delete';
         echo "<scrip> window.location.href = 'CompleteEdit.php' </scrip>";
         Header("Location: CompleteEdit.php");
         exit;
     }
     else{
         $error = $emailErrorMessage;
     }
 }
?>
<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<body>
<h3>Edit item</h3>
<div id="display">
    <?php while ($data = $result->fetch_row()) { ?>
        <?php
        $_SESSION["contact"]["id"] = $data[0];
        $_SESSION["contact"]["name"] = $data[1];
        $_SESSION["contact"]["description"] = $data[2];
        $_SESSION["contact"]["price"] = $data[3];
        $_SESSION["contact"]["availability"] = $data[4];

        ?>
        <?php if ($error) echo "<div class='txt-contact'>" . $error . "</div>"; ?>
        <form method="post">
        <table width="100%" border="1">
            <tr>
                <td width="10%" align=center><b>ID</b></td>
                <td><input value="<?php echo $_SESSION["contact"]["id"] ?>" name="id"  /></td>
            </tr>
            <tr>
                <td width="10%"align=center> <b>Name</b></td>
                <td><input value="<?php echo $_SESSION["contact"]["name"] ?>" name="name" /></td>
            </tr>
            <tr>
                <td width="10%"align=center><b>Description</b></td>
                <td><textarea style="width: 100%;" name="description"><?php echo $_SESSION["contact"]["description"] ?></textarea></td>
            </tr>
            <tr>
                <td width="10%"align=center><b>Price</b></td>
                <td><input value="<?php echo $_SESSION["contact"]["price"] ?>" name="price"/></td>
            </tr>
            <tr>
                <td width="10%"align=center><b>Availabity</b></td>
                <td><input value="<?php echo $_SESSION["contact"]["availability"] ?>" name="availability"/></td>
            </tr>
            <tr>
                <td ><input type="submit" name="edit" value="Edit" /></td>
                <td ><input type="submit" name="delete" value="Delete" /></td>
            </tr>
        </table>
        </form>
    <?php } ?>
</div>
</body>
</html>