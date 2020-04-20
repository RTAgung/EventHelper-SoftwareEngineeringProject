<?php
	include "../connect.php";
	session_start();
	include 'checksession.php';

	if (isset($_POST['submit'])) {
		foreach ($_POST as $key => $value) {
			${$key} = $value;
		}

		$sql = "INSERT INTO detail_expenses VALUES ('',$eventId,'$object',$quantity,$price,'$information')";
		$data = mysqli_query($link, $sql);
	}
	
	header("location: event_expense.php");
 ?>