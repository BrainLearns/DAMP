header('Content-Disposition: inline');
<?php session_start();
?>
<!doctype html>
<html>
<head>
    <title>Login</title>
    <style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
  width: 20%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #2980B9;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 20%;
}


button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #00a78e;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  width: 10%;
  border-radius: 10%;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>
</head>
<body>
<br><br>
<div class="imgcontainer">
    <img src="img/isical.jpg" alt="Avatar" class="avatar">
  </div>
	<h1 style="text-align: center;color: #00a78e;">DAMP</h1>
  <form name=frmLogin action="trylog.php" method = "post">
  <div class="container">
    <table style="width:100%;text-align:center;">
    <tr>
    	<td><label for="uname"><b>Username</b></label></td>
    </tr>
    <tr>
    	<td><input type="text" placeholder="Enter Username" name="username" required></td>
    </tr>
    <tr>
    	<td><label for="psw"><b>Password</b></label></td>
    </tr>
    <tr>
    	<td><input type="password" placeholder="Enter Password" name="password" required></td>
    </tr>

    <tr>
    	<td><button type="submit" style="text-align: center;background-color: #00a78e;" onClick="document.frmLogin.submit();">Login</button></td>
    </tr>
    </table>
  </form>
</body>
</html>
