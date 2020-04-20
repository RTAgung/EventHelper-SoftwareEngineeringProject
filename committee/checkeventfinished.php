<?php 
	date_default_timezone_set('Asia/Jakarta');
	$dateNow = date("Y-m-d H:i:s");

	$sql = "SELECT * FROM events";
	$data = mysqli_query($link,$sql);
	while ($row = mysqli_fetch_object($data)) {
		$dateEvent = $row->StartDateTime;
		if ($dateNow >= $dateEvent ) {
			$sqlUp = "UPDATE events SET Status = 'finished' WHERE Id = $row->Id";
			$dataUp = mysqli_query($link, $sqlUp);
		}
	}
 ?>