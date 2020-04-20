<?php 
	if (!isset($_SESSION['email'])) {
		header("location: attentionsignin.php");
	}
 ?>