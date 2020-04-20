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
          <li class="nav-item active">
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
        <h1 class="display-4">Event List</h1> 
      </div>
    </div>
  
  </header>

  <!-- ------------------------------------------------ CONTENT ----------------------------------------------- -->

  <main>
    <div class="container-fluid p-5">
      <div class="row justify-content-md-center">
        <div class="col-2 center">
          <p>Create Event</p>
          <a class="btn btn-success btn-block rounded-0" href="createevent.php" role="button">Create</a>
        </div>
      </div>
      <h1 class="mt-4">Upcoming Event</h2>
      <hr>
      <table class="table table-hover">
        <thead class="thead-dark">
          <tr>
            <th class="align-middle"></th>
            <th class="align-middle">Event</th>
            <th class="align-middle">City</th>
            <th class="align-middle">Date</th>
            <th class="align-middle">Price</th>
            <th class="align-middle"></th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $sql = "SELECT * FROM events";
          $data = mysqli_query($link,$sql);
          while ($row = mysqli_fetch_object($data)) {
            if ($row->Status == "upcoming") {
              $date = strtotime($row->StartDateTime);
              $sDate = date("d M Y", $date);
              ?>
                <tr>
                  <td><img src="<?=$row->Photo?>" style="float: left; object-fit: cover" width="80px"></td>
                  <td class="align-middle text-truncate"><?=$row->Name?></td>
                  <td class="align-middle"><?=$row->City?></td>
                  <td class="align-middle"><?=$sDate?></td>
                  <td class="align-middle">Rp.<?=$row->Price?></td>
                  <td class="align-middle">
                      <a href="eventdetail.php?id=<?=$row->Id?>" class="btn btn-dark float-right ml-1">Detail</a>
                  </td>
                </tr>
            <?php
            }
          }
           ?>
        </tbody>
      </table>
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