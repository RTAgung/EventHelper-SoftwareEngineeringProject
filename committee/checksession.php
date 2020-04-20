<?php 
	if (!(isset($_SESSION['email']) && isset($_SESSION['eventId']) && isset($_SESSION['committeeId']) && isset($_SESSION['role']))) {
		header("location: ../index.php");
	} else {
		$email = $_SESSION['email'];
		$eventId = $_SESSION['eventId'];
		$committeeId = $_SESSION['committeeId'];
		$role = $_SESSION['role'];
	}
 ?>