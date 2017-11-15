<?php session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<body>
<h3>Edit item</h3>
<?php if ($_SESSION["contact"]["state"] == 'edit'): ?>
<div id="display">
    <p style="text-align: center">The item <?php echo $_SESSION["contact"]["name"]?> has been updated.</p>
</div>
<?php elseif($_SESSION["contact"]["state"] = 'delete'):?>
    <div id="display">
        <p style="text-align: center">The item <?php echo $_SESSION["contact"]["name"]?> has been deleted.</p>
    </div>
<?php endif;?>
<p style="text-align: center"><a  href="../">Click here to return</a></p>
</body>
</html>