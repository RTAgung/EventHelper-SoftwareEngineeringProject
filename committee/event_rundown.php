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
            <a class="nav-link " href="participant.php">Participant</a>
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
                <a class="nav-link" href="event_detail.php">Detail</a>
                <a class="nav-link active" href="event_rundown.php">Rundown</a>
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
        <h1>Rundown</h1>
        <div class="col-12 border p-4">
          <h2>Activities</h2>
          <hr>
          <div class="row small ml-1">
            <label class="mr-4">Note :</label>
            <div class="mr-2 bg-success" style="width: 15px; height: 15px;"></div>
            <label class="mr-4">edit</label>
            <div class="mr-2 bg-danger" style="width: 15px; height: 15px;"></div>
            <label class="mr-4">delete</label>
          </div>
          <?php 
            $sqlRundown = "SELECT * FROM detail_rundown WHERE EventId = $eventId";
            $dataRundown = mysqli_query($link, $sqlRundown);

            $sqlEvent = "SELECT * FROM events WHERE Id = $eventId";
            $dataEvent = mysqli_query($link, $sqlEvent);
            $rowEvent = mysqli_fetch_object($dataEvent);

            $dateStart = strtotime($rowEvent->StartDateTime);
            $dateEnd = strtotime($rowEvent->EndDateTime);
            $dateEvent = date("d M Y", $dateStart);
            $timeStart = date("H:i", $dateStart);
            $timeEnd = date("H:i", $dateEnd);
            $time = "$timeStart - $timeEnd";
           ?>
          <div class="row mb-3">
            <div class="col-4">
              <h4>Time : <?=$time?></h4>
            </div>
            <div class="col-2 offset-6">
              <a class="btn btn-success btn-block rounded-0" href="event_rundownadd.php" role="button">Add Activity</a>
            </div>
          </div>
          <table class="table table-hover">
            <thead class="thead-dark">
              <tr>
                <th>#</th>
                <th>Activity</th>
                <th>Start</th>
                <th>End</th>
                <th>Performer</th>
                <th>Info</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $count = 0;
                while ($rowRundown = mysqli_fetch_object($dataRundown)) {
                  $count++;
                  ?>
                    <tr >
                      <td><?=$count?></td>
                      <td class="text-truncate"><?=$rowRundown->Activity?></td>
                      <td class="text-truncate"><?=$rowRundown->StartTime?></td>
                      <td class="text-truncate"><?=$rowRundown->EndTime?></td>
                      <td class="text-truncate"><?=$rowRundown->Performer?></td>
                      <td><?=$rowRundown->Information?></td>
                      <td class="">
                        <a href="event_rundowndelete.php?id=<?=$rowRundown->Id?>" class="btn btn-sm btn-danger rounded-0 float-right mx-1">
                          <i class="fa fa-trash"></i>
                        </a>
                        <a href="event_rundownedit.php?id=<?=$rowRundown->Id?>" class="btn btn-sm btn-success rounded-0 float-right mx-1">
                          <i class="fa fa-cog"></i>
                        </a>
                      </td>
                    </tr>
                  <?php
                }
               ?>
            </tbody>
          </table>
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