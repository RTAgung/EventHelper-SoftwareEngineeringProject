<?php
	include "../connect.php";
	session_start();
	include 'checksession.php';

	if (isset($_POST['submit'])) {
		$from = $_GET['f'];
		$back = "";
		if ($from == "c") {
			$back = "com_core.php";
		} else if ($from == "s") {
			$back = "com_staff.php";
		}


		$inviteEmail = $_POST['comemail'];
		$departementId = $_POST['departementid'];
		$comRole = $_POST['comrole'];

		$sql = "SELECT * FROM users WHERE Email = '$inviteEmail'";
		$data = mysqli_query($link, $sql);
		$num = mysqli_num_rows($data);
		if ($num > 0) {
			$sql = "SELECT * FROM committees WHERE Email = '$inviteEmail' AND EventId = $eventId";
			$data = mysqli_query($link, $sql);
			$num = mysqli_num_rows($data);

			if ($num == 0) {
				$sql = "INSERT INTO committees values ('','$inviteEmail',$eventId,'pending')";
				$data = mysqli_query($link, $sql);
				$sql = "SELECT Id FROM committees WHERE Email = '$inviteEmail' AND EventId = $eventId";
				$data = mysqli_query($link, $sql);
				$row = mysqli_fetch_object($data);

				$sql = "INSERT INTO detail_committees values ($row->Id,'$departementId','','$comRole','','')";
				$data = mysqli_query($link, $sql);

				header("location: $back");
			} else {
				header("location: com_invite.php?msg=fc&f=$from");
			}
		}
		else{
			header("location: com_invite.php?msg=fu&f=$from");
		}
	}
 ?>