<?php
	include "../connect.php";
	session_start();
	include 'checksession.php';

	if (isset($_POST['submit'])) {
		$comId = $_GET['id'];

		$from2 = $_GET['f2'];
		$back = "";
		if ($from2 == "c") {
			$back = "com_core.php";
		} else if ($from2 == "s") {
			$back = "com_staff.php";
		}
		
		foreach ($_POST as $key => $value) {
			${$key} = $value;
		}

		if ($_GET['f'] == "a") {
			$sql = "UPDATE detail_committees SET DepartementId = '$departid', Job = '$job', Role = '$role' WHERE CommitteeId = $comId";
			$data = mysqli_query($link, $sql);
		} else if ($_GET['f'] == "p") {
			$sql = "UPDATE detail_committees SET DepartementId = '$departid', Role = '$role' WHERE CommitteeId = $comId";
			$data = mysqli_query($link, $sql);
		}
		header("location: $back");
	} else {
		header("location: com_edit.php");
	}
 ?>