<?php
session_start();
error_reporting(0);
require("mail.php");
include_once("newConnection.php");
$process = new mail_form();
$allowEdit = 0;
$isLogin = 0;
$editImage = 0;
if (isset($_POST["log-in"])) {

    $valueExist = true;
    unset($_SESSION["contact"]);
    foreach ($_POST as $key => $value) {
        $_SESSION["contact"][$key] = $process->dataFilter($value);
    }

    $_POST = $_SESSION["contact"];
    $requireValue = array(
        'username' => 'Username',
        'password' => 'Password'
    );

    $requireValueCheck = $process->requireCheck($requireValue);
    if (!$requireValueCheck["empty_flag"]) {
        $username = $_SESSION["contact"]["username"];
        $password = $_SESSION["contact"]["password"];
        $checkUser = $dbh->prepare("SELECT * FROM account WHERE userName = :username AND password = :password");
        $checkUser->execute(array(
                ':username'=>$username,
                ':password'=>$password
        ));
        $queryCheck = $checkUser->rowCount();
        if ($queryCheck == 0) {
            $emailErrorMessage = "<p class =\"error_mess\" style=\"color:#C00;\">Your username or password is incorrect.</p>";
            $valueExist = false;
        }
        if ($valueExist) {
            $isLogin = 1;
            $allowEdit = 1;
            $userPicture = $dbh->prepare("SELECT image FROM account WHERE username=:username");
            $userPicture->bindValue(':username', $username, PDO::PARAM_STR);
            $userPicture->execute();
            $picture = $userPicture->fetch(PDO::FETCH_ASSOC);
        } else {
            $error = $emailErrorMessage;
        }
    }
}

if (isset($_POST["edit"])) {
    if (isset($_POST["edit"])) {
        $_SESSION['id'] = $_POST;
        echo "<scrip> window.location.href = 'edit.php' </scrip>";
        Header("Location: edit.php");
        exit;
    }
}
if (isset($_POST["image-change"])) {
    $allowEdit = 1;
    $isLogin = 1;
    $editImage = 1;
}
if(isset($_POST['confirm-image'])){
    $allowEdit = 1;
    $isLogin = 1;
    $editImage = 0;
    $username = $_SESSION['contact']['username'];
    $imgFile = $_FILES["user-image"]["name"];
    $tmp_dir = $_FILES["user-image"]["tmp_name"];
    $imgSize = $_FILES["user-image"]["size"];
    $upload_dir = getcwd();
    $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
    $userPic = rand(1000,100000).".".$imgExt;
    $upload_dir = $upload_dir."/upload/$userPic";
    copy($tmp_dir, $upload_dir);
//    move_uploaded_file($tmp_dir,$upload_dir.$userPic);
    $image_info= "upload/$userPic";
    $insertImage = $dbh->prepare("UPDATE account SET image = :image WHERE username = :username");
    $insertImage->execute(array(
            ':image' => $image_info,
            ':username' => $username
    ));
    $userPicture = $dbh->prepare("SELECT image FROM account WHERE username=:username");
    $userPicture->bindValue(':username', $username, PDO::PARAM_STR);
    $userPicture->execute();
    $picture = $userPicture->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<?php if ($allowEdit != 0): ?>
    <script type="text/javascript" src="/js/script.js"></script>
    <script>
        function searchFilter(page_num) {
            page_num = page_num ? page_num : 0;
            var keywords = $('#keywords').val();
            var sortBy = $('#sortBy').val();
            $.ajax({
                type: 'POST',
                url: 'display.php',
                async: false,
                data: {
                    page: page_num,
                    itemName: keywords,
                    sortBy: sortBy
                },
                success: function (html) {
                    $('#responsecontainer').html(html);
                }
            });
        }
    </script>
<?php endif; ?>
<body>

<div id="login-field">
    <?php if ($isLogin != 1): ?>
        <?php if ($error) echo "<div class='txt-contact'>" . $error . "</div>"; ?>
        <form method="post" onsubmit="return CheckValidator('login-form')" id="login-form">
            <table id="login-table">
                <tr>
                    <td><label>Username: </label></td>
                    <td><input class="requiredf" name="username" type="text" id="username"
                               msg_error="Please enter your username"
                               value="<?php echo $_SESSION["contact"]["username"] ?>"></td>
                </tr>
                <tr>
                    <td><label>Password: </label></td>
                    <td><input class="requiredf" type="password" id="password" name="password"
                               msg_error="Please enter your password" value="<?php $_SESSION["contact"]["password"] ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" id="user-login" name="log-in">Log in</button>
                    </td>
                </tr>
            </table>
        </form>
        <div>
            <button onclick="location.href= 'register.php'">Register</button>
        </div>
    <?php else: ?>
        <?php if($editImage == 0):?>
            <p>Thank you for coming back <?php echo $username; ?></p>
            <img src='<?php echo $picture['image']?>' width="200" height="200" />
            <form method="post" onsubmit=" return CheckValidator()">
                <button type="submit" name="image-change">Edit Image</button>
            </form>
        <?php else:?>
            <p>Please choose your new Image <?php echo $username?></p>
            <form method="post" enctype="multipart/form-data" onsubmit=" return CheckValidator()">
                <input type="file" accept="image/" name="user-image"/>
                <button type='submit' name="confirm-image" id='confirm-image'>Confirm selection</button>
            </form>
        <?php endif;?>
        <p><a href=".">Logout</a></p>
    <?php endif; ?>
</div>
<h3 align="center">Manage Tool Details</h3>
<div id="message">
</div>
<?php if ($allowEdit != 0): ?>
    <div class="post-search-panel">
        <input type="text" id="keywords" placeholder="Type the name of the item you are looking for"
               onkeyup="searchFilter()"/>
        <select id="sortBy" onchange="searchFilter()">
            <option value="">Sort By</option>
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select>
    </div>
<?php endif; ?>
<div id="responsecontainer" align="center">
    <p>Please login to see the information.</p>
</div>


<div id="error">
</div>
<div>

<?php
//set_time_limit(1000); // Set execution length in seconds
//include("libs/PHPCrawler.class.php");
//
//// Extend the provided base class and override the handler functions
//class NanoCrawler extends PHPCrawler
//{
//    // Process the document contents in $DocInfo->source here
//    function handleDocumentInfo($DocInfo)
//    {
//        echo "Page requested: ".$DocInfo->url." (".$DocInfo->http_status_code.")\n";
//        echo "Referer-page: ".$DocInfo->referer_url."\n";
//        if ($DocInfo->received == true) {
//            echo "Content received: ".$DocInfo->bytes_received." bytes\n";
//        } else {
//            echo "Content not received\n";
//        }
//        echo "Links found: ".count($DocInfo->links_found_url_descriptors)."\n\n";
//
//        flush();
//    }
//
//    // Process the headers like http_status_code, content_type, content_length,
//    // content_encoding, transfer_encoding, cookies, source_url
//    function handleHeaderInfo($header) {
//        print_r($header);
//    }
//}
//
//// Instantiate the new custom crawler class we defined
//$crawler = new NanoCrawler();
//
//// Set rules and params
//$crawler->setURL("vnexpress.net");
//$crawler->addContentTypeReceiveRule("#text/html#");
//
//// Ignore links to pictures, dont even request pictures
//$crawler->addURLFilterRule("#\.(jpg|jpeg|gif|png)$# i");
//
//// Store and send cookie-data like a browser does
//$crawler->enableCookieHandling(true);
//
//// Set the traffic-limit to 10 MB  (in bytes)
//$crawler->setTrafficLimit(1000 * 1024 * 10);
//
//// Set user agent. It's not polite to lie about your user agent.
//// If you are creating a bot or crawler it is good to set the user agent as
//// something unique that includes a way to contact like website.
//// This allows people to report any problems or block your user agent
//// if it causing problems. There are other situations where a website
//// will reject anything but a familiar user agent. Sometimes just putting
//// "firefox" as a user agent will bypass filters.
//$crawler->setUserAgentString("Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36");
//
//// Delay between requests in seconds
//$crawler->setRequestDelay(0);
//
//// Max number of pages to crawl
//$crawler->setPageLimit(5, true);
//
//// Skip items listed in robots.txt (or not)
//$crawler->obeyRobotsTxt(false);
//
//// Follow redirects
//$crawler->setFollowMode(1);
//
//// Run it. May take a while.
//$crawler->go();
//
//// Output crawl report
//$report = $crawler->getProcessReport();
//echo "Summary:\n";
//echo "Links followed: " . $report->links_followed . "\n";
//echo "Documents received: " . $report->files_received . "\n";
//echo "Bytes received: " . $report->bytes_received . " bytes\n";
//echo "Process runtime: " . $report->process_runtime . " sec\n";
//echo "Memory peak usage: " . (($report->memory_peak_usage / 1024) / 1024) . " MB\n";?>
</div>
<script type="text/javascript" src="/js/inputChecking.js"></script>

</body>
</html>