<html>
    <head>
    <title>Login</title>
    </head>
    <body>
        <?php
	   error_reporting(0);
        $username = $_POST['username'];
        $password = $_POST['password'];
        session_start();
        if ($_SESSION['login']==true || ($_POST['username']=="User1" && $_POST['password']=="isikol@123") || ($_POST['username']=="User2" && $_POST['password']=="isikol@456") || ($_POST['username']=="User3" && $_POST['password']=="usr3@isikol")) {
            echo "Redirecting...";
            $_SESSION['login']=true;
	    $_SESSION['user']=$username;
	    echo "<script>location.href='index1_Edited.php';</script>";
	}
	else {
	    echo "<script>location.href='login.php';alert('Username/Password is wrong. Try again!');</script>";
        }
        ?>

    </body>
</html>
