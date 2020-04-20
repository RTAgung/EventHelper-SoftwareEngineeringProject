<?php 
	include '../connect.php';
	session_start();
	include 'checksession.php';

	if (isset($_GET['id'])) {
		$ticketId = $_GET['id'];

		if (isset($_GET['r']) && $_GET['r'] == "1") {
			$sql = "UPDATE tickets SET Attendance = 0 WHERE Id = $ticketId";
			$data = mysqli_query($link, $sql);
		} else {
			$sql = "UPDATE tickets SET Attendance = 1 WHERE Id = $ticketId";
			$data = mysqli_query($link, $sql);
		}
	}
	header("location: participant.php");
 ?>