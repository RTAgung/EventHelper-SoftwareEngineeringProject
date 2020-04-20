<?php 
	include '../connect.php';
	session_start();
	include 'checksession.php';

	$sql = "UPDATE events SET Status = 'canceled' WHERE Id = $eventId";
	$data = mysqli_query($link, $sql);
	
	header("location: event_detail.php");
 ?>