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
            <a class="nav-link active" href="participant.php">Participant</a>
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
        <h1>Participant</h1>
        <div class="col-12 border p-4">
          <h2>Paid Off</h2>
          <hr>
          <div class="row small ml-1">
            <label class="mr-4">Note :</label>
            <div class="mr-2 bg-primary" style="width: 15px; height: 15px;"></div>
            <label class="mr-4">attendace (no)</label>
            <div class="mr-2" style="background: #0062cc; width: 15px; height: 15px;"></div>
            <label class="mr-4">attendace (yes) </label>
            <div class="mr-2 bg-info" style="width: 15px; height: 15px;"></div>
            <label class="mr-4">show receipt</label>
            <div class="mr-2 bg-success" style="width: 15px; height: 15px;"></div>
            <label class="mr-4">send reward</label>
            <div class="mr-2 bg-danger" style="width: 15px; height: 15px;"></div>
            <label class="mr-4">delete</label>
          </div>
          <?php 
            $sqlTicket = "SELECT * FROM tickets WHERE EventId = $eventId AND Payment = 'paid off'";
            $dataTicket = mysqli_query($link, $sqlTicket);
            $numPaid = mysqli_num_rows($dataTicket);
           ?>
          <label>Total : <?=$numPaid?></label>
          <table class="table table-sm table-hover">
            <thead class="thead-dark">
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Institution</th>
                <th>Profession</th>
                <th class="center">Reward</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $count = 0;
                while ($rowTicket = mysqli_fetch_object($dataTicket)) {
                  $count++;
                  $sqlParticipant = "SELECT * FROM participants WHERE Email = '$rowTicket->Email'";
                  $dataParticipant = mysqli_query($link,$sqlParticipant);
                  $rowParticipant = mysqli_fetch_object($dataParticipant);
                  ?>
                    <tr >
                      <td><?=$count?></td>
                      <td class="text-truncate"><?=$rowParticipant->Fullname?></td>
                      <td class="text-truncate"><?=$rowParticipant->Email?></td>
                      <td class="text-truncate"><?=$rowParticipant->ContactNumber?></td>
                      <td class="text-truncate"><?=$rowParticipant->Institution?></td>
                      <td class="text-truncate"><?=$rowParticipant->Profession?></td>
                      <td class="center"> 
                        <?php 
                          if ($rowTicket->Reward == "") {
                            echo "<i class='fa fa-circle'></i>";
                          } else {
                            echo "<i class='fa fa-check-circle'></i>";
                          }
                         ?>
                      </td>
                      <td class="p-0">
                        <a href="participantdelete.php?id=<?=$rowTicket->Id?>" class="btn btn-sm btn-danger rounded-0 float-right mx-1">
                          <i class="fa fa-trash"></i>
                        </a>
                        <a href="participantreward.php?id=<?=$rowTicket->Id?>&em=<?=$rowTicket->Email?>" class="btn btn-sm btn-success rounded-0 float-right mx-1">
                          <i class="fa fa-upload"></i>
                        </a>
                        <?php 
                          $receipt = "";
                          if ($rowTicket->Receipt != "") {
                            $receipt = "../$rowTicket->Receipt";
                          }
                         ?>
                        <a href="<?=$receipt?>" class="btn btn-sm btn-info rounded-0 float-right mx-1">
                          <i class="fa fa-file"></i>
                        </a>
                        <?php 
                          $active = "";
                          $revert = "";
                          if ($rowTicket->Attendance == 1) {
                            $active = "active";
                            $revert = "&&r=1";
                          } 
                         ?>
                        <a href="participantattendance.php?id=<?=$rowTicket->Id?><?=$revert?>" class="btn btn-sm btn-primary rounded-0 float-right mx-1 <?=$active?>">
                          <i class="fa fa-check"></i>
                        </a>
                      </td>
                    </tr>
                  <?php
                }
               ?>
            </tbody>
          </table>
          <hr style="height: 15px; margin: 50px 0px;">
          <h2>On Credit</h2>
          <hr>
          <div class="row small ml-1">
            <label class="mr-4">Note :</label>
            <div class="mr-2" style="background: #007bff; width: 15px; height: 15px;"></div>
            <label class="mr-4">confirmation</label>
            <div class="mr-2 bg-info" style="width: 15px; height: 15px;"></div>
            <label class="mr-4">show receipt</label>
            <div class="mr-2" style="background: #dc3545; width: 15px; height: 15px;"></div>
            <label class="mr-4">delete</label>
          </div>
          <?php 
            $sqlTicket = "SELECT * FROM tickets WHERE EventId = $eventId AND Payment = 'on credit'";
            $dataTicket = mysqli_query($link, $sqlTicket);
            $numPaid = mysqli_num_rows($dataTicket);
           ?>
          <label>Total : <?=$numPaid?></label>
          <table class="table table-sm table-hover">
            <thead class="thead-dark">
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Institution</th>
                <th>Profession</th>
                <th class="center">Receipt</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $count = 0;
                while ($rowTicket = mysqli_fetch_object($dataTicket)) {
                  $count++;
                  $sqlParticipant = "SELECT * FROM participants WHERE Email = '$rowTicket->Email'";
                  $dataParticipant = mysqli_query($link,$sqlParticipant);
                  $rowParticipant = mysqli_fetch_object($dataParticipant);
                  ?>
                    <tr >
                      <td><?=$count?></td>
                      <td class="text-truncate"><?=$rowParticipant->Fullname?></td>
                      <td class="text-truncate"><?=$rowParticipant->Email?></td>
                      <td class="text-truncate"><?=$rowParticipant->ContactNumber?></td>
                      <td class="text-truncate"><?=$rowParticipant->Institution?></td>
                      <td class="text-truncate"><?=$rowParticipant->Profession?></td>
                      <td class="center"> 
                        <?php 
                          if ($rowTicket->Receipt == "") {
                            echo "<i class='fa fa-circle'></i>";
                          } else {
                            echo "<i class='fa fa-check-circle'></i>";
                          }
                         ?>
                      </td>
                      <td class="p-0">
                        <a href="participantdelete.php?id=<?=$rowTicket->Id?>" class="btn btn-sm btn-danger rounded-0 float-right mx-1">
                          <i class="fa fa-trash"></i>
                        </a>
                        <?php 
                          $receipt = "";
                          if ($rowTicket->Receipt != "") {
                            $receipt = "../$rowTicket->Receipt";
                          }
                         ?>
                        <a href="<?=$receipt?>" class="btn btn-sm btn-info rounded-0 float-right mx-1">
                          <i class="fa fa-file"></i>
                        </a>
                        <a href="participantpayment.php?id=<?=$rowTicket->Id?>" class="btn btn-sm btn-primary rounded-0 float-right mx-1">
                          <i class="fa fa-check"></i>
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