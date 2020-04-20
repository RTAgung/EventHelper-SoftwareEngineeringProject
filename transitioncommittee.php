<?php 
	session_start();
	$_SESSION['eventId'] = $_GET['vid'];
	$_SESSION['committeeId'] = $_GET['cid'];
	$_SESSION['role'] = $_GET['role'];

	header("location: committee/index.php");
 ?>