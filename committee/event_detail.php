<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link href="css/styles.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="../style.css">

  <title>EventHelper Inside</title>
</head>
<body class="sb-nav-fixed">
  <?php 
    include "../connect.php";
    session_start();
    include 'checksession.php';
    include '../checkeventfinished.php';
   ?>
  <!-- ------------------------------------------------ HEADER ------------------------------------------------ -->
  <header>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
      <a class="navbar-brand" href="index.php">EventHelper Inside</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          
        </ul>

        <?php 
          $sql = "SELECT * FROM users WHERE Email = '$email'";
          $data = mysqli_query($link, $sql);
          $row = mysqli_fetch_object($data);
          ?>
          <p class="text-warning px-3 m-0">
            Hello, <?=$row->Username?>
          </p>
          <a href="exit.php?f=so">
            <button class="btn btn-outline-success my-2 my-sm-0 mr-2 rounded-0" type="submit">Sign out</button>
          </a>
          <a href="exit.php?f=bh">
            <button class="btn btn-success my-2 my-sm-0 mr-2 rounded-0" type="submit">Back to Home</button>
          </a>
          <?php
         ?>
      </div>
    </nav>
  </header>

  <!-- ------------------------------------------------- BODY ------------------------------------------------- -->

  <div id="layoutSidenav">
    
  <!-- ----------------------------------------------- SIDENAV ------------------------------------------------ -->

    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <a class="nav-link " href="index.php">Dashboard</a>
            <a class="nav-link" href="participant.php">Participant</a>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCommittee" aria-expanded="false" aria-controls="collapseLayouts">
              Committee
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseCommittee" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="com_core.php">Core</a>
                <a class="nav-link" href="com_staff.php">Staff</a>
              </nav>
            </div>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEvent" aria-expanded="false" aria-controls="collapseLayouts">
              Event
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseEvent" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link active" href="event_detail.php">Detail</a>
                <a class="nav-link" href="event_rundown.php">Rundown</a>
                <a class="nav-link" href="event_income.php">Income</a>
                <a class="nav-link" href="event_expense.php">Expense</a>
              </nav>
            </div>
          </div>
        </div>
        <?php 
          $sqlDepart = "SELECT d.Name as DName, dc.Sertificate as Sertificate FROM detail_committees dc JOIN departements d ON dc.DepartementId = d.Id WHERE dc.CommitteeId = '$committeeId'";
          $dataDepart = mysqli_query($link, $sqlDepart);
          $rowDepart = mysqli_fetch_object($dataDepart);
          $sertificate = "";
          if ($rowDepart->Sertificate != "") {
            $sertificate = "../$rowDepart->Sertificate";
          }
         ?>
        <div class="sb-sidenav-footer p-0">
          <div class="sb-sidenav-dark pb-3 center">
            <a class="btn btn-sm btn-outline-success rounded-0" href="<?=$sertificate?>" role="button">Download Sertificate</a>
          </div>
        </div>
        <div class="sb-sidenav-footer">
          <div class="small">Departement :</div>
           <?=$rowDepart->DName?> (<i><?=$role?></i>)
        </div>
      </nav>
    </div>


  <!-- ------------------------------------------------ CONTENT ----------------------------------------------- -->

    <div id="layoutSidenav_content">
      
      <main class="container-fluid p-4">
        <?php 
          $sqlEvent = "SELECT * FROM events WHERE Id = $eventId";
          $dataEvent = mysqli_query($link, $sqlEvent);
          $rowEvent = mysqli_fetch_object($dataEvent);

          $dateStart = strtotime($rowEvent->StartDateTime);
          $dateEnd = strtotime($rowEvent->EndDateTime);
          $dateEvent = date("d M Y", $dateStart);
          $timeStart = date("H:i", $dateStart);
          $timeEnd = date("H:i", $dateEnd);
          $time = "$timeStart - $timeEnd";

          $sqlDetail = "SELECT * FROM detail_events WHERE EventId = $eventId";
          $dataDetail = mysqli_query($link, $sqlDetail);
          $rowDetail = mysqli_fetch_object($dataDetail);
         ?>

        <h1>Event Detail</h1>
        <div class="col-12 border p-4">
          <div class="row">
            <div class="col-4 offset-4">
              <h5 class="center"><?=$rowEvent->City?></h5>
            </div>
            <div class="col-1 offset-3">
              <?php 
                if ($role == "creator") {
                  ?>
                  <a class="btn btn-danger btn-sm btn-block rounded-0" href="event_delete.php" role="button" style="font-size: 10px;">
                    <i class="fa fa-trash mr-1"></i>Delete
                  </a>
                  <?php 
                }
               ?>
            </div>
            <div class="col-12 center mb-4">
              <h2><?=$rowEvent->Name?></h2>
              <img src="../<?=$rowEvent->Photo?>" class="photo-event" style="width: 80%; height: 380px; object-fit: all;">
            </div>
            <div class="col-6 center mb-4">
              <p class="m-0">Be Held</p><h3><?=$dateEvent?></h3><hr>
              <p class="m-0">Location</p><p><?=$rowEvent->Location?></p>
            </div>
            <div class="col-6 center mb-4">
              <p class="m-0">Status</p><h3><?=$rowEvent->Status?></h3><hr>
              <p class="m-0">Time</p>
              <p class="m-0"><?=$time?></p>
              <a class="btn btn-outline-success btn-sm rounded-0" href="event_rundown.php" role="button">Show Rundown</a>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <h4>Description</h4>
              <p><?php echo nl2br($rowEvent->Description); ?></p>
              <hr>
              <p class="m-0">organized by <?=$rowEvent->Company?></p>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-6 center">
              <p class="m-0">Quota</p><h4><?=$rowEvent->Quota?></h4>
            </div>
            <div class="col-6 center">
              <p class="m-0">Price</p><h4>Rp.<?=$rowEvent->Price?></h4>
            </div>
          </div>
          <div class="row mb-5">
            <div class="col-6 center">
              <p class="m-0">Total Income</p><h4>Rp.<?=$rowDetail->TotalIncome?></h4>
              <a class="btn btn-outline-success btn-sm rounded-0" href="event_income.php" role="button">Show More</a>
            </div>
            <div class="col-6 center">
              <p class="m-0">Total Expense</p><h4>Rp.<?=$rowDetail->TotalExpense?></h4>
              <a class="btn btn-outline-success btn-sm rounded-0" href="event_expense.php" role="button">Show More</a>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-12">
              <div class="row m-0">
                <h5 class="mr-4">Sponsorship</h5>
                <a class="btn btn-outline-success btn-sm rounded-0" href="event_sponsorship.php" role="button">Change</a>
              </div>
              <p class="ml-4 mb-4 mr-4 mt-2"><?=$rowDetail->Sponsorship?></p>
              <div class="row m-0">
                <h5 class="mr-4">Information</h5>
                <a class="btn btn-outline-success btn-sm rounded-0" href="event_information.php" role="button">Change</a>
              </div>
              <p class="ml-4 mb-4 mr-4 mt-2"><?=$rowDetail->Information?></p>
            </div>
          </div>
          <div class="row justify-content-md-center mt-5"> 
            <div class="col-1">
              <?php 
                $disabled = "";
                if ($role == "staff") {
                  $disabled = "disabled";
                }
               ?>
              <a class="btn btn-warning btn-block rounded-0 <?=$disabled?>" href="event_edit.php" role="button">Edit</a>
            </div>
            <div class="col-4 offset-3">
              <?php 
                $disabled = "";
                if ($rowEvent->Status != 'pending' || $role == "staff") {
                  $disabled = "disabled";
                }
               ?>
              <a class="btn btn-success btn-block rounded-0 <?=$disabled?>" href="event_publish.php" role="button">Publish</a>
              <?php if ($rowEvent->Status == 'pending'): ?>
                <label class="text-danger">*cannot back to pending</label>
              <?php endif ?>
            </div>
            <div class="col-1 offset-3">
              <?php 
                $disabled = "";
                if ($rowEvent->Status == 'finished' || $rowEvent->Status == 'canceled') {
                  $disabled = "disabled";
                }
                if ($role != "creator") {
                  $disabled = "disabled";
                }
               ?>
              <a class="btn btn-danger btn-block rounded-0 <?=$disabled?>" href="event_cancel.php" role="button">Cancel</a>
            </div>
          </div>
        </div>
      </main>

  <!-- ------------------------------------------------ FOOTER ------------------------------------------------ -->

      <footer class="py-4 bg-dark mt-auto">
        <div class="container-fluid">
          <div class=" align-items-center justify-content-between small">
            <div class="text-muted text-center">Copyright &copy; 2021 All Rights Reserved</div>
          </div>
        </div>
      </footer>
    </div>
  </div>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="assets/demo/chart-area-demo.js"></script>
  <script src="assets/demo/chart-bar-demo.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
  <script src="assets/demo/datatables-demo.js"></script>
</body>
</html>