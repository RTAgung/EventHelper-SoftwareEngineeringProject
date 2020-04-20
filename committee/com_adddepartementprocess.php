<?php
	include "../connect.php";
	session_start();
	include 'checksession.php';

	if (isset($_POST['submit']) && isset($_GET['f'])) {
		$departId = $_POST['departid'];
		$departId = strtoupper($departId);
		$departName = $_POST['departname'];
		$departName = ucwords($departName); 

		$sql = "SELECT * FROM departements WHERE Id = '$departId' OR Name = '$departName'";
		$data = mysqli_query($link, $sql);
		$num = mysqli_num_rows($data);
		if ($num == 0) {
			$sql = "INSERT INTO departements values ('$departId','$departName')";
			$data = mysqli_query($link, $sql);

			if ($_GET['f'] == "c") {
				header("location: com_invite.php?f=c");
			} else if ($_GET['f'] == "s") {
				header("location: com_invite.php?f=s");
			}
		}
		else{
			header("location: com_adddepartement.php?msg=f");
		}
	} else {
		header("location: com_adddepartement.php");
	}
 ?>