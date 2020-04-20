<?php 
	include "connect.php";
    session_start();
    date_default_timezone_set('Asia/Jakarta');

    $committeeId = $_GET['id'];
	$respond = $_GET['resp'];

	if ($respond == 1) {
		$date = date('Y-m-d');

		$sql = "UPDATE committees SET Status = 'accepted' WHERE Id = $committeeId";
		$data = mysqli_query($link, $sql);
		$sql = "UPDATE detail_committees SET HireDate = '$date' WHERE CommitteeId = $committeeId";
		$data = mysqli_query($link, $sql);
		$sql = "SELECT EventId FROM committees WHERE Id = $committeeId";
		$data = mysqli_query($link, $sql);
		$row = mysqli_fetch_object($data);
		$eventId = $row->EventId;
		$sql = "SELECT Role FROM detail_committees WHERE committeeId = $committeeId";
		$data = mysqli_query($link, $sql);
		$row = mysqli_fetch_object($data);

		$_SESSION['eventId'] = $eventId;
		$_SESSION['committeeId'] = $committeeId;
		$_SESSION['role'] = $row->Role;
		
		header("location: committee/index.php");
	} else if ($respond == 0) {
		$sql = "UPDATE committees SET Status = 'rejected' WHERE Id = $committeeId";
		$data = mysqli_query($link, $sql);
		header("location: myevent.php");
	}
 ?>