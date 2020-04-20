<?php
	include "../connect.php";
	session_start();
	include 'checksession.php';

	if (isset($_POST['submit'])) {
		foreach ($_POST as $key => $value) {
			${$key} = $value;
		}
		$runId = $_GET['id'];

		$sql = "UPDATE detail_rundown SET Activity = '$activity', StartTime = '$starttime', EndTime = '$endtime', Performer = '$performer', Information = '$information' WHERE Id = $runId";
		$data = mysqli_query($link, $sql);
	}
	
	header("location: event_rundown.php");
 ?>