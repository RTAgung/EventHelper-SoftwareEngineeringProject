<?php 
	session_start();
	if ($_GET['f'] == "so") {
		session_destroy();
		header("location: ../index.php");
	} else if ($_GET['f'] == "bh") {
		unset($_SESSION['eventId']);
		unset($_SESSION['committeeId']);
		unset($_SESSION['role']);
		header("location: ../index.php");
	}

 ?>