<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/js/script.js"></script>
<script>
    function searchFilter(page_num) {
        page_num = page_num?page_num:0;
        var keywords = $('#keywords').val();
        var sortBy = $('#sortBy').val();
        $.ajax({
            type: 'POST',
            url: 'display.php',
            async: false,
            data:{
                page: page_num,
                itemName: keywords,
                sortBy: sortBy},
            success: function (html) {
                $('#responsecontainer').html(html);
            }
        });
    }
</script>
<body>

<div id="login-field">
    <form method="post" onsubmit="return CheckValidator('login-form')" id="login-form">
    <table id="login-table">
        <tr>
            <td><label>Username: </label></td>
            <td><input class="requiredf" type="text" id="username" msg_error="Please enter your username"></td>
        </tr>
        <tr>
            <td><label>Password: </label></td>
            <td><input class="requiredf" type="password" id="password" name="password" msg_error="Please enter your password"></td>
        </tr>
        <tr>
            <td><button type="submit" id="user-login">Log in</button></td>
        </tr>
    </table>
    </form>
    <div>
    <button onclick="location.href= 'register.php'" >Register</button>
    </div>
</div>
<h3 align="center">Manage Tool Details</h3>
<div id="message">
</div>
<div class="post-search-panel">
    <input type="text" id="keywords" placeholder="Type the name of the item you are looking for" onkeyup="searchFilter()"/>
    <select id="sortBy" onchange="searchFilter()">
        <option value="">Sort By</option>
        <option value="asc">Ascending</option>
        <option value="desc">Descending</option>
    </select>
</div>
<div id="responsecontainer" align="center">

</div>



<div id="error">
</div>
<script type="text/javascript" src="/js/inputChecking.js"></script>

</body>
</html>