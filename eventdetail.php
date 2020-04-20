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
      height: 500px;
      object-fit: all;
    }
  </style>
  <title>EventHelper</title>
</head>
<body>
  <?php 
    include "connect.php";
    session_start();
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
        <h1 class="display-4">Event Detail</h1> 
      </div>
    </div>
  
  </header>

  <!-- ------------------------------------------------ CONTENT ----------------------------------------------- -->

  <main class="container-fluid p-5">
    <div class="row justify-content-md-center">
      <div class="col-10 border">
        <?php 
          $eventId = $_GET['id'];
          $sql = "SELECT * FROM events WHERE Id = '$eventId'";
          $data = mysqli_query($link, $sql);
          $row = mysqli_fetch_object($data);

          $dateStart = strtotime($row->StartDateTime);
          $dateEnd = strtotime($row->EndDateTime);
          $date = date("d M Y", $dateStart);
          $timeStart = date("H:i", $dateStart);
          $timeEnd = date("H:i", $dateEnd);
          $time = "$timeStart - $timeEnd";

          $sql2 = "SELECT * FROM tickets WHERE EventId = '$eventId'";
          $data2 = mysqli_query($link, $sql2);
          $registered = mysqli_num_rows($data2);
          $remaining = $row->Quota - $registered;
         ?>
        <div class="m-5" align="center">
          <img src="<?=$row->Photo?>" class="photo-event">
        </div>

        <table class="table">
          <tr>
            <td colspan="2"><h2 class="center"><?=$row->Name?></h2></td>
          </tr>
          <tr>
            <td>City</td>
            <td><?=$row->City?></td>
          </tr>
          <tr>
            <td>Location</td>
            <td><?=$row->Location?></td>
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
            <td colspan="2">
              <h5>Description</h5>
              <p><?php echo nl2br($row->Description); ?></p>
            </td>
          </tr>
          <tr>
            <td colspan="2">organixzed by <?=$row->Company?></td>
          </tr>
        </table>
      </div>
    </div>
    <?php
      if (isset($_SESSION['email'])) {
        $sqlCommittee = "SELECT * FROM committees WHERE Email = '$email' AND EventId = $eventId AND Status = 'accepted'";
        $dataCommittee = mysqli_query($link, $sqlCommittee);
        $numOfCommittee = mysqli_num_rows($dataCommittee);

        $disabled = "";
        if ($numOfCommittee > 0) {
          $disabled = "disabled";
          echo "<p style='margin-left: 8%;'>*you are a committee</p>";
        }

        $sql2 = "SELECT * FROM tickets WHERE Email = '$email' AND EventId = $eventId";
        $data2 = mysqli_query($link, $sql2);
        $num = mysqli_num_rows($data2);

        if ($num > 0) {
          $sql2 = "SELECT * FROM tickets WHERE Email = '$email' AND EventId = $eventId";
          $data2 = mysqli_query($link, $sql2);
          $row2 = mysqli_fetch_object($data2);
          echo "<p style='margin-left: 8%;'>*you have registered</p>";
        }

        if ($row->Status == "finished" || $row->Status == "canceled") {
          $disabled = "disabled";
        }
      } else {
        $num = 0;
        $disabled = "";
      }
     ?>
    <div class="center py-4">
      <h5>Rp.<?=$row->Price?></h5>
      <p class="text-sm">remaining quota : <?=$remaining?></p>
      <?php 
      if ($num > 0) {
        ?>
        <a href="ticket.php?id=<?=$row2->Id?>" class="mb-3 btn btn-success rounded-0">SHOW TICKET</a>
        <?php  
      } else {
        ?>
        <a href="eventjoin.php?id=<?=$row->Id?>" class="mb-3 btn btn-success rounded-0 <?=$disabled?>">JOIN EVENT</a>
        <?php 
      }
      if (isset($_GET['msg'])) {
        if ($_GET['msg'] == 'f') {
          ?>
          <br>
          <label class="text-danger">join failed, your account is not verified</label>
          <?php
        }
      }
      ?>
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