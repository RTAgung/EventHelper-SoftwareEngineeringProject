<?php
include "connect.php";

if (isset($_POST['submit'])) {
	foreach ($_POST as $key => $value) {
		${$key} = $value;
	}
	$fullname = ucwords($fullname);

	$sql = "INSERT INTO participants values ('$email','$fullname','$contactnumber','$institution','$profession')";
	$data = mysqli_query($link, $sql);

	$sql = "UPDATE users SET VerifiedAccount = 1 WHERE Email = '$email'";
	$data = mysqli_query($link, $sql);

	header("location: profile.php");
}
 ?>