<?php 
	include '../connect.php';
	session_start();
	include 'checksession.php';

	$sql = "DELETE FROM events WHERE Id = $eventId";
	$data = mysqli_query($link, $sql);

	unset($_SESSION['eventId']);
	unset($_SESSION['committeeId']);
	unset($_SESSION['role']);
	header("location: ../index.php");
 ?>