<?php 
	include "connect.php";
    session_start();
	if (isset($_POST['submit'])) {
		$email = $_SESSION['email'];

		date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		foreach ($_POST as $key => $value) {
			${$key} = $value;
		}
		$photo = "photo/events/default.svg";
		$status = "pending";

		$sql = "INSERT INTO events VALUES ('','$name','$description','$photo','$city','$location','$startdatetime','$enddatetime','$company',$quota,$price,'$status')";
		$data = mysqli_query($link, $sql);
		$sql = "SELECT Id FROM events WHERE Name = '$name' AND Description = '$description' AND Photo = '$photo' AND City = '$city' AND Location = '$location' AND StartDateTime = '$startdatetime' AND EndDateTime = '$enddatetime' AND Company = '$company' AND Quota = $quota AND Price = $price AND Status = '$status'";
		$data = mysqli_query($link, $sql);
		$row = mysqli_fetch_object($data);

		$eventId = $row->Id;

		$sql = "INSERT INTO committees VALUES ('','$email','$eventId','accepted')";
		$data = mysqli_query($link, $sql);
		$sql = "SELECT Id FROM committees WHERE Email = '$email' AND EventId = $eventId";
		$data = mysqli_query($link, $sql);
		$row = mysqli_fetch_object($data);

		$committeeId = $row->Id;
		$departId = "KEPA";

		$sql = "INSERT INTO detail_committees VALUES ($committeeId,'$departId','','creator','$date', '')";
		$data = mysqli_query($link, $sql);

		$sql = "INSERT INTO detail_events  VALUES ('',$eventId,0,0,'','')";
		$data = mysqli_query($link, $sql);

		$_SESSION['eventId'] = $eventId;
		$_SESSION['committeeId'] = $committeeId;
		$_SESSION['role'] = 'creator';
		header("location: committee/index.php");
	}
 ?>