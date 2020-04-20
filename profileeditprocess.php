<?php
include "connect.php";

if (isset($_POST['submit'])) {
	foreach ($_POST as $key => $value) {
		${$key} = $value;
	}

	if (isset($fullname)) {
		$fullname = ucwords($fullname);
		$sql = "UPDATE users SET Username = '$username', Address = '$address', Birthday = '$birthday' WHERE Email = '$email'";
		$data = mysqli_query($link, $sql);
		$sql = "UPDATE participants SET Fullname = '$fullname', ContactNumber = '$contactnumber', Institution = '$institution', Profession = '$profession' WHERE Email = '$email'";
		$data = mysqli_query($link, $sql);
	} else {
		$sql = "UPDATE users SET Username = '$username', Address = '$address', Birthday = '$birthday' WHERE Email = '$email'";
		$data = mysqli_query($link, $sql);
	}
	header("location: profile.php");
}
 ?>

 