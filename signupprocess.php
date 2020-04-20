<?php
include "connect.php";

if (isset($_POST['submit'])) {
	foreach ($_POST as $key => $value) {
		${$key} = $value;
	}
	$photo = "photo/users/default.svg";

	$sql = "SELECT * FROM users WHERE Email = '$email'";
	$data = mysqli_query($link, $sql);
	$num = mysqli_num_rows($data);
	if ($num > 0) {
		header("location: signup.php?msg=f");
	}
	else{
		$sql = "INSERT INTO users values ('$email','$username','$password','$photo','$address','$birthday', default)";
		$data = mysqli_query($link, $sql);
		header("location: signupsuccess.php");
	}
}
 ?>