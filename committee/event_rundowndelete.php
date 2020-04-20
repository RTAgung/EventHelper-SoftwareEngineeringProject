<?php 
	include '../connect.php';
	session_start();
	include 'checksession.php';

	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		
		$sql = "DELETE FROM detail_rundown WHERE Id = $id";
		$data = mysqli_query($link, $sql);
	}
	header("location: event_rundown.php");
 ?>