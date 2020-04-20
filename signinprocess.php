<?php
include "connect.php";
session_start();

if (isset($_POST['submit'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];

	$sql = "SELECT * FROM users WHERE Email = '$email' AND Password = '$password'";
	$data = mysqli_query($link, $sql);
	$num = mysqli_num_rows($data);
	
	if ($num > 0) {
		$_SESSION["email"] = $email;
		header("location: index.php");
	}
	else{
		header("location: signin.php?msg=f");
	}
}
 ?>