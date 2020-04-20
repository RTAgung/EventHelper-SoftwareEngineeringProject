<?php 
	include '../connect.php';
	session_start();
	include 'checksession.php';

	if (isset($_POST['submit'])) {
		$sponsorship = $_POST['sponsorship'];

		$sql = "UPDATE detail_events SET Sponsorship = '$sponsorship' WHERE EventId = $eventId";
		$data = mysqli_query($link, $sql);
	}
	
	header("location: event_detail.php");
 ?>