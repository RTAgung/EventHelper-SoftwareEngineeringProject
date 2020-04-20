<?php
	include "../connect.php";
	session_start();
	include 'checksession.php';

	if (isset($_POST['submit'])) {
		foreach ($_POST as $key => $value) {
			${$key} = $value;
		}

		$sql = "UPDATE events SET Name = '$name', Description = '$description', City = '$city', Location = '$location', StartDateTime = '$startdatetime', EndDateTime = '$enddatetime', Company = '$company', Quota = $quota, Price = $price WHERE Id = $eventId";
		$data = mysqli_query($link, $sql);
	}
	
	header("location: event_detail.php");
 ?>