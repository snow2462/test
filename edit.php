<?php
include_once("api.php");
session_start();
error_reporting(0);
$itemId = $_SESSION["id"];
$query = "SELECT * FROM list WHERE itemId = " . $itemId["edit"];
$result = $con->query($query);
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
        <form method="post">
        <table border="1">
            <tr>
                <td align=center><b>ID</b></td>
                <td align=center> <b>Name</b></td>
                <td align=center><b>Description</b></td>
                <td align=center><b>Price</b></td>
                <td align=center><b>Availabity</b></td>
            </tr>
            <tr>
                <td contenteditable><?php echo $_SESSION["contact"]["id"] ?></td>
                <td contenteditable><?php echo $_SESSION["contact"]["name"] ?></td>
                <td contenteditable><?php echo $_SESSION["contact"]["description"] ?></td>
                <td contenteditable><?php echo $_SESSION["contact"]["price"] ?></td>
                <td contenteditable><?php echo $_SESSION["contact"]["availability"] ?></td>
            </tr>
            <tr><td colspan="5"><input type="submit" value="confirm" /></td></tr>
        </table>
        </form>
    <?php } ?>
</div>
</body>
</html>