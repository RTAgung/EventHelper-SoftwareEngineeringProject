<?php 
	include '../connect.php';
	session_start();
	include 'checksession.php';

	if (isset($_GET['id'])) {
		$ticketId = $_GET['id'];

		$sql = "UPDATE tickets SET Payment = 'paid off' WHERE Id = $ticketId";
		$data = mysqli_query($link, $sql);
	}
	header("location: participant.php");
 ?>