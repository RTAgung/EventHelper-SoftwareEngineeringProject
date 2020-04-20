<?php 
	include "connect.php";
	session_start();
	
	$eventId = $_GET["id"];
	$email = $_SESSION["email"];

	$sql = "SELECT * FROM users WHERE Email = '$email'";
	$data = mysqli_query($link, $sql);
	$row = mysqli_fetch_object($data);

	if ($row->VerifiedAccount == 1) {
		$sql = "INSERT INTO tickets VALUES ('','$email','$eventId','on credit',0,'','')";
		$data = mysqli_query($link, $sql);
		$sql2 = "SELECT * FROM tickets WHERE (EventId = $eventId AND Email = '$email')";
		$data2 = mysqli_query($link, $sql2);
		$row2 = mysqli_fetch_object($data2);
		

		include 'checkparticipant.php';
		header("location: ticket.php?id=$row2->Id");
	} else {
		header("location: eventdetail.php?id=$eventId&msg=f");
	}
	include 'checksession.php';
 ?>