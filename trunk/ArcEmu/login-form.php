<?php session_start(); ?>

<!-- Style for error message box -->
<style type="text/css">
.msgbox{border:solid 1px #CC0000; padding:4px; background:#F3AAAE; margin-bottom:20px;}
</style>

<!-- Show error message if login fails -->
<?php include('lib/common-functions.php')?>

<!-- Show error message if login fails -->
<?php if(isset($_GET['error'])){?>
    <div class="msgbox">Error! Verify your data!</div>
<?php } ?>

<!-- Login Basic Form -->
<form name="login" action="lib/login.php" method="post">
    <label>Email</label>
    <input name="email" type="text" size="14" />
    <label>Password</label>
    <input name="psw" type="text" size="14" />
    <input type="submit" name="button" id="button" value="Login" />
</form>

<?php if(isset($_SESSION['userid'])){ ?>
<a href="lib/logout.php">Logout</a>
<?php } ?>

