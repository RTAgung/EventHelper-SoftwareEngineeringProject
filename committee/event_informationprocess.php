<?php 
	include '../connect.php';
	session_start();
	include 'checksession.php';

	if (isset($_POST['submit'])) {
		$information = $_POST['information'];

		$sql = "UPDATE detail_events SET Information = '$information' WHERE EventId = $eventId";
		$data = mysqli_query($link, $sql);
	}
	
	header("location: event_detail.php");
 ?>