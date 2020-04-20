<?php 
    $email = $_SESSION['email'];
    $sqlTicket = "SELECT * FROM tickets WHERE Email = '$email'";
    $dataTicket = mysqli_query($link, $sqlTicket);

    while ($rowTicket = mysqli_fetch_object($dataTicket)) {
    	$sqlCom = "UPDATE committees SET Status = 'rejected' WHERE Email = '$email' AND EventId = $rowTicket->EventId";
    	$dataCom = mysqli_query($link, $sqlCom);
    }
 ?>