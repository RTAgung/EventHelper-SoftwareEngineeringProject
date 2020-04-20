<?php 
	include '../connect.php';
	session_start();
	include 'checksession.php';

	if (isset($_GET['id'])) {
		$comId = $_GET['id'];
		$from = $_GET['f'];
		$back = "";
		if ($from == "c") {
			$back = "com_core.php";
		} else if ($from == "s") {
			$back = "com_staff.php";
		}

		$sql = "DELETE FROM committees WHERE Id = $comId";
		$data = mysqli_query($link, $sql);
	}
	header("location: $back");
 ?>