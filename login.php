<?php
// ini_set("display_errors", 1);
// error_reporting(E_ALL);
// error reporting(0);
session_start();
// print_r($_SESSION);
// exit();
$errMsg=''; // initialize message to display on HTML form
if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $_POST['username']=htmlspecialchars($_POST['username']);
    $_POST['password']=htmlspecialchars($_POST['password']);
    #check database for legit username/password combo
    	require 'config/database.php';
    	$database = new Database();
    	$pdo = $database->getConnection();
    	$sql = "SELECT password_salt, password_hash FROM persons" 
    	 . " WHERE email=? "
    	 . " LIMIT 1; "
    	 ;
    	$query=$pdo->prepare($sql);
    	$query->execute(Array($_POST['username']));
    	$row = $query->fetch(PDO::FETCH_ASSOC);
    	$salt = $row['password_salt'];
    	$passSalt = MD5($_POST['password'] . $salt);
    	$sql = "SELECT * FROM persons" 
    	 . " WHERE email=? "
    	 . " AND password_hash=? "
    	 . " LIMIT 1; "
    	 ;
    	$query=$pdo->prepare($sql);
    	$query->execute(Array($_POST['username'], $passSalt));
    	$result = $query->fetch(PDO::FETCH_ASSOC);
    	
    	
    	#if user typed legit username/password combo, set $_SESSION
    	if ($result) {
    		$_SESSION['username']=$result['email'];
    		$_SESSION['role']=$result['role'];
    		$_SESSION['id']=$result['id'];
    		header('Location:index.php');

    	} else {
    		$errMsg='Login failure: wrong username or password';
    	}
    }

?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Crud Applet with Login</title>
<meta charset="utf-8" />
</head>

<body>
<h1>Crud Applet with Login</h1>
<a href="https://github.com/anthonycgalea/CIS355-CRUDLApplet">GitHub Source Code</a>
<h2>Login</h2>

<form action="" method="post">
    <input type="text" class="form-control"
name="username" placeholder="admin@admin.com"
required autofocus /><br />
    <input type="text" class="form-control"
name="password" placeholder="admin" />
<button class="btn btn-lg btn-primary btn-block"
type="submit" name="login">Login</button>
</form>

</body>

</html>