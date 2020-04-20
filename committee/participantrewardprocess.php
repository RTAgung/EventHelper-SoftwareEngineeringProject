<?php
	include "../connect.php";
	session_start();
	include 'checksession.php';

	if (isset($_POST['submit'])) {
		$TId = $_POST['ticketid'];
		$TEmail = $_POST['ticketemail'];
		
		$sql = "SELECT Name FROM events WHERE Id = $eventId";
		$data = mysqli_query($link, $sql);
		$row = mysqli_fetch_object($data);
		$EName = $row->Name;

		if (!empty($_FILES['reward']['name'])) {
			$reward = 'document/participants/reward/'.$TId.'-'.$eventId.'-'.$EName.'-'.$TEmail.'.'.basename($_FILES['reward']['type']);
			$target = '../'.$reward;
			echo "$reward";
			move_uploaded_file($_FILES["reward"]["tmp_name"], $target);
			$sql = "UPDATE tickets SET Reward = '$reward' WHERE Id = $TId";
			$data = mysqli_query($link, $sql);
		}
		header("location: participant.php");
	}
 ?>