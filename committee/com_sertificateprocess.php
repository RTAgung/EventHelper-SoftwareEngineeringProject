<?php
	include "../connect.php";
	session_start();
	include 'checksession.php';

	if (isset($_POST['submit'])) {
		$comId = $_GET['id'];
		$comUsername = $_POST['comusername'];
		$comEmail = $_POST['comemail'];
		$from = $_GET['f'];
		$back = "";
		if ($from == "c") {
			$back = "com_core.php";
		} else if ($from == "s") {
			$back = "com_staff.php";
		}
		
		$sql = "SELECT Name FROM events WHERE Id = $eventId";
		$data = mysqli_query($link, $sql);
		$row = mysqli_fetch_object($data);
		$eventName = $row->Name;

		if (!empty($_FILES['sertificate']['name'])) {
			$sertificate = 'document/committees/'.$eventId.'-'.$eventName.'-'.$comEmail.'.'.basename($_FILES['sertificate']['type']);
			$target = '../'.$sertificate;
			echo "$sertificate";
			move_uploaded_file($_FILES["sertificate"]["tmp_name"], $target);
			$sql = "UPDATE detail_committees SET Sertificate = '$sertificate' WHERE CommitteeId = $comId";
			$data = mysqli_query($link, $sql);
		}
		header("location: $back");
	}
 ?>