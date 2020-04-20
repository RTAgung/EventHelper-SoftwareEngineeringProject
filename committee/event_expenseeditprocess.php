<?php
	include "../connect.php";
	session_start();
	include 'checksession.php';

	if (isset($_POST['submit'])) {
		foreach ($_POST as $key => $value) {
			${$key} = $value;
		}
		$id = $_GET['id'];

		$sql = "UPDATE detail_expenses SET Object = '$object', Quantity = $quantity, Price = $price, Information = '$information' WHERE Id = $id";
		$data = mysqli_query($link, $sql);
	}
	
	header("location: event_expense.php");
 ?>