<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="style.css">
  <style type="text/css">
    .photo-event{
      width: 100%;
      height: 400px;
      object-fit: all;
    }
  </style>
  <title>EventHelper</title>
</head>
<body>
  <?php 
    include "connect.php";
    session_start();
    include 'checkparticipant.php';
    include 'checkeventfinished.php';
   ?>
  <!-- ------------------------------------------------ HEADER ------------------------------------------------ -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="index.php">EventHelper</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="myevent.php">My Event</a>
          </li>
        </ul>

        <?php 
          if (!empty($_SESSION["email"])) {
            $email = $_SESSION["email"];
            $sql = "SELECT * FROM users WHERE Email = '$email'";
            $data = mysqli_query($link, $sql);
            $row = mysqli_fetch_object($data);
            ?>
            <a href="profile.php" class="text-warning px-3" id="link">
              Hello, <?=$row->Username?>
            </a>
            <a href="signoutprocess.php">
              <button class="btn btn-outline-success my-2 my-sm-0 mr-1 rounded-0" type="submit">Sign out</button>
            </a>
            <?php
          }
          else{
            ?>
            <a href="signin.php">
              <button class="btn btn-outline-success my-2 my-sm-0 mr-1 rounded-0" type="submit">Sign in</button>
            </a>
            <?php
          }
         ?>

      </div>
    </nav>

    <div class="bg-dark m-0 box-header">
      <div class="container center">
        <h1 class="display-4">Your Ticket</h1> 
      </div>
    </div>
  
  </header>

  <!-- ------------------------------------------------ CONTENT ----------------------------------------------- -->

  <main class="container-fluid p-5">
    <div class="row justify-content-md-center">
      <div class="col-8 border">
        <?php 
          $ticketId = $_GET['id'];
          $sqlTicket = "SELECT * FROM tickets WHERE Id = $ticketId";
          $dataTicket = mysqli_query($link, $sqlTicket);
          $rowTicket = mysqli_fetch_object($dataTicket);

          $email = $rowTicket->Email;
          $eventId = $rowTicket->EventId;

          $sqlEvent = "SELECT * FROM events WHERE Id = $eventId";
          $dataEvent = mysqli_query($link, $sqlEvent);
          $rowEvent = mysqli_fetch_object($dataEvent);

          $sqlParticipant = "SELECT * FROM participants WHERE Email = '$email'";
          $dataParticipant = mysqli_query($link, $sqlParticipant);
          $rowParticipant = mysqli_fetch_object($dataParticipant);

          $dateStart = strtotime($rowEvent->StartDateTime);
          $dateEnd = strtotime($rowEvent->EndDateTime);
          $date = date("d M Y", $dateStart);
          $timeStart = date("H:i", $dateStart);
          $timeEnd = date("H:i", $dateEnd);
          $time = "$timeStart - $timeEnd";
         ?>
        <div class="m-5" align="center">
          <img src="<?=$rowEvent->Photo?>" class="photo-event">
        </div>
        <table class="table">
          <tr>
            <td colspan="2"><p class="m-0 center">Ticket ID</p><h2 class="center"><?=$rowTicket->Id?></h2></td>
          </tr>
          <tr>
            <td colspan="2"><h2 class="center"><?=$rowEvent->Name?></h2></td>
          </tr>
          <tr>
            <td>City</td>
            <td><?=$rowEvent->City?></td>
          </tr>
          <tr>
            <td>Location</td>
            <td><?=$rowEvent->Location?></td>
          </tr>
          <tr>
            <td>Date</td>
            <td><?=$date?></td>
          </tr>
          <tr>
            <td>Time</td>
            <td><?=$time?></td>
          </tr>
          <tr>
            <td colspan="2"><h2 class="center">My Data</h2></td>
          </tr>
          <tr>
            <td>Email</td>
            <td><?=$email?></td>
          </tr>
          <tr>
            <td>Fullname</td>
            <td><?=$rowParticipant->Fullname?></td>
          </tr>
          <tr>
            <td>Contact Number</td>
            <td><?=$rowParticipant->ContactNumber?></td>
          </tr>
          <tr>
            <td>Institution</td>
            <td><?=$rowParticipant->Institution?></td>
          </tr>
          <tr>
            <td>Profession</td>
            <td><?=$rowParticipant->Profession?></td>
          </tr>
          <?php 
            if (isset($_POST['submit'])) {
              $TId = $_GET['id'];
              
              $sql = "SELECT * FROM Tickets t JOIN Events e ON t.EventId = e.Id WHERE t.Id = $TId";
              $data = mysqli_query($link, $sql);
              $row = mysqli_fetch_object($data);
              $EName = $row->Name;

              if (!empty($_FILES['receipt']['name'])) {
                $receipt = 'document/participants/receipt/'.$TId.'-'.$row->EventId.'-'.$EName.'-'.$email.'.'.basename($_FILES['receipt']['type']);
                $target = $receipt;
                // echo "$receipt";
                move_uploaded_file($_FILES["receipt"]["tmp_name"], $target);
                $sql = "UPDATE tickets SET Receipt = '$receipt' WHERE Id = $TId";
                $data = mysqli_query($link, $sql);
              }
              header("location: ticket.php?id=$TId");
            }
           ?>
          <?php 
            if ($rowTicket->Payment == "on credit") {
              ?>
              <tr class="bg-danger">
                <td colspan="2" class="text-center">
                  <h4 class="center">You Haven't Paid Yet, Please Confirm Payment</h4>
                  <button type="button" class="btn btn-outline-light rounded-0" data-toggle="modal" data-target=".bd-example-modal-sm">Send Receipt</button>
                  <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content px-5 pt-5">
                        <form method="post" action="ticket.php?id=<?=$rowTicket->Id?>" enctype="multipart/form-data">
                          <label>File Receipt</label>
                          <div class="form-group">
                            <input type="file" name="receipt">
                          </div>
                          <div class="form-group py-1">
                            <button type="submit" class="mt-1 mb-3 btn btn-success btn-block rounded-0" name="submit">Send</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <?php
            } else {
              ?>
              <tr class="bg-success">
                <td colspan="2"><h4 class="center">You Paid Off</h4><p class="center mb-0">please be on time</p></td>
              </tr>
              <?php
            }
           ?>
        </table>
      </div>
    </div>
      <div class="row justify-content-md-center">
        <div class="center py-4">
          <p class="m-2">you can get reward/sertificate here</p>
          <?php 
            $disabled = "";
            if ($rowTicket->Attendance == 0) {
              $disabled = "disabled";
            }
           ?>
          <a href="<?=$rowTicket->Reward?>" class="mb-3 btn btn-success rounded-0 <?=$disabled?>">Download Reward</a>
        </div>
      </div>
  </main>

  <!-- ------------------------------------------------ FOOTER ------------------------------------------------ -->

  <footer class="bg-dark py-4">
    <div class="text-center text-muted">Copyright &copy; 2021 All Rights Reserved</div>
  </footer>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>