<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="style.css">

  <title>EventHelper</title>
</head>
<body>
  <?php 
    include "connect.php";
    session_start();
    include 'checksession.php';
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
          <li class="nav-item ">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item active">
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
        <h1 class="display-4">My Event</h1> 
      </div>
    </div>
  
  </header>

  <!-- ------------------------------------------------ CONTENT ----------------------------------------------- -->

  <main class="container-fluid p-5">
    <?php 
    $sql = "SELECT c.Id as CId, c.Status as CStatus, e.Name as EName, e.Photo as EPhoto, e.Id as EId, e.StartDateTime EDate, e.Status as EStatus, dc.Role as DCRole, d.Name as DName FROM ((committees c JOIN events e ON c.EventId = e.Id) JOIN (detail_committees dc JOIN departements d ON dc.DepartementId = d.Id) ON c.Id = dc.CommitteeId) WHERE c.Email = '$email' AND c.Status = 'pending'";
    $data = mysqli_query($link, $sql);
    $num = mysqli_num_rows($data);

    if ($num > 0) {
      ?>
      <h1 class="mt-5">Request</h1>
      <hr>
      <table class="table table-hover">
        <thead class="thead-dark">
          <tr>
            <th class="align-middle"></th>
            <th class="align-middle">Event</th>
            <th class="align-middle">Departement / <i>Role</i></th>
            <th class="align-middle">Date</th>
            <th class="align-middle">From</th>
            <th class="align-middle"></th>
          </tr>
        </thead>
        <tbody>
          <?php 
          while ($row = mysqli_fetch_object($data)) {
              $date = strtotime($row->EDate);
              $sDate = date("d M Y", $date);

              $sqlCreator = "SELECT c.Email as FromEmail FROM committees c JOIN detail_committees dc ON c.Id = dc.CommitteeId WHERE c.EventId = $row->EId AND dc.Role = 'creator'";
              $dataCreator = mysqli_query($link,$sqlCreator);
              $rowCreator = mysqli_fetch_object($dataCreator);
              ?>
                <tr>
                  <td><img src="<?=$row->EPhoto?>" style="float: left; object-fit: cover" width="80px"></td>
                  <td class="align-middle text-truncate"><?=$row->EName?></td>
                  <td class="align-middle"><?=$row->DName?> / <i><?=$row->DCRole?></i></td>
                  <td class="align-middle"><?=$sDate?></td>
                  <td class="align-middle"><?=$rowCreator->FromEmail?></td>
                  <td class="align-middle">
                      <a href="requestprocess.php?id=<?=$row->CId?>&resp=1" class="btn btn-success float-right ml-1">Accept</a>
                      <a href="requestprocess.php?id=<?=$row->CId?>&resp=0" class="btn btn-danger float-right ml-1">Reject</a>
                      <a href="eventdetail.php?id=<?=$row->EId?>" class="btn btn-outline-dark float-right ml-1">Show Event</a>
                  </td>
                </tr>
            <?php
          }
           ?>
        </tbody>
      </table>
      <?php
    }
     ?>
    <h1 class="mt-5">Participant</h1>
    <hr>
    <table class="table table-hover">
      <thead class="thead-dark">
        <tr>
          <th class="align-middle"></th>
          <th class="align-middle">Event</th>
          <th class="align-middle">City</th>
          <th class="align-middle">Date</th>
          <th class="align-middle">Status</th>
          <th class="align-middle"></th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $sql = "SELECT * FROM tickets LEFT JOIN events ON tickets.EventId = events.Id WHERE tickets.Email = '$email' AND NOT events.Status = 'pending' ORDER BY events.StartDateTime AND events.Status DESC";
        $data = mysqli_query($link, $sql);
        
        while ($row = mysqli_fetch_object($data)) {
            $date = strtotime($row->StartDateTime);
            $sDate = date("d M Y", $date);

            $sqlTicket = "SELECT Id FROM tickets WHERE EventId = $row->EventId";
            $dataTicket = mysqli_query($link,$sqlTicket);
            $rowTicket = mysqli_fetch_object($dataTicket);
            ?>
              <tr>
                <td><img src="<?=$row->Photo?>" style="float: left; object-fit: cover" width="80px"></td>
                <td class="align-middle text-truncate"><?=$row->Name?></td>
                <td class="align-middle"><?=$row->City?></td>
                <td class="align-middle"><?=$sDate?></td>
                <td class="align-middle"><?=$row->Status?></td>
                <td class="align-middle">
                    <a href="ticket.php?id=<?=$rowTicket->Id?>" class="btn btn-dark float-right ml-1">Ticket</a>
                    <a href="eventdetail.php?id=<?=$row->EventId?>" class="btn btn-outline-dark float-right ml-1">Detail</a>
                </td>
              </tr>
          <?php
        }
         ?>
      </tbody>
    </table>
    <?php 
      $num = mysqli_num_rows($data);
      if ($num == 0) {
        echo "<h4 class='text-center text-black-50'>NONE</h4>";
      }
    ?>
    
    <h1 class="mt-5">Committee</h1>
    <hr>
    <table class="table table-hover">
      <thead class="thead-dark">
        <tr>
          <th class="align-middle"></th>
          <th class="align-middle">Event</th>
          <th class="align-middle">Departement / <i>Role</i></th>
          <th class="align-middle">Date</th>
          <th class="align-middle">Status</th>
          <th class="align-middle"></th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $sql = "SELECT * FROM committees c LEFT JOIN events e ON c.EventId = e.Id WHERE c.Email = '$email' AND c.Status = 'accepted' ORDER BY e.StartDateTime AND e.Status DESC";
        $data = mysqli_query($link, $sql);
        
        while ($row = mysqli_fetch_object($data)) {
            $date = strtotime($row->StartDateTime);
            $sDate = date("d M Y", $date);

            $sqlDepart = "SELECT d.Name as DepartName, dc.Role as DCRole, c.Id as CId FROM (committees c JOIN detail_committees dc ON c.Id = dc.CommitteeId) JOIN departements d ON d.Id = dc.DepartementId WHERE c.EventId = $row->EventId AND c.Email = '$email'";
            $dataDepart = mysqli_query($link,$sqlDepart);
            $rowDepart = mysqli_fetch_object($dataDepart);
            ?>
              <tr>
                <td><img src="<?=$row->Photo?>" style="float: left; object-fit: cover" width="80px"></td>
                <td class="align-middle text-truncate"><?=$row->Name?></td>
                <td class="align-middle"><?=$rowDepart->DepartName?> / <i><?=$rowDepart->DCRole?></i></td>
                <td class="align-middle"><?=$sDate?></td>
                <td class="align-middle"><?=$row->Status?></td>
                <td class="align-middle">
                    <a href="transitioncommittee.php?vid=<?=$row->EventId?>&cid=<?=$rowDepart->CId?>&role=<?=$rowDepart->DCRole?>" class="btn btn-dark float-right ml-1">Organize</a>
                </td>
              </tr>
          <?php
        }
         ?>
      </tbody>
    </table>
    <?php 
      $num = mysqli_num_rows($data);
      if ($num == 0) {
        echo "<h4 class='text-center text-black-50'>NONE</h4>";
      }
    ?>
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