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

    <div class="bg-dark m-0 box-profile">
      <div class="container center">
        <img src="<?=$row->Photo?>" style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%;">
        <?php  
          $string = $row->Username; 
          $first_name = explode(" ", $string);
          $last_array = count($first_name) - 1;
        ?>
        <h1 class="display-4 mt-4"><?=$string?></h1>
      </div>
    </div>
  
  </header>

  <!-- ------------------------------------------------ CONTENT ----------------------------------------------- -->

  <main class="container-fluid p-5">
      <div class="row justify-content-md-center">
        <div class="col-8">
          <?php 
            $sql = "SELECT * FROM (users LEFT JOIN participants ON users.Email=participants.Email) WHERE users.Email = '$email'";
            $data = mysqli_query($link, $sql);
            $row = mysqli_fetch_object($data);

            if ($row->VerifiedAccount == 0) {
              echo "<h4>Not Verified Account</h4>";
            } else if ($row->VerifiedAccount == 1) {
              echo "<h4>Verified Account</h4>";
            }

            $birthday = strtotime($row->Birthday);
            $birthday = date("d M Y", $birthday);
         ?>
          <div class="px-4 border">
            <h2 class="text-dark mt-4">Profile</h2>
            <table class="table">
              <tr>
                <td>Username</td>
                <td><?=$row->Username?></td>
              </tr>
              <tr>
                <td>Email</td>
                <td><?=$email?></td>
              </tr>
              <tr>
                <td>Address</td>
                <td><?=$row->Address?></td>
              </tr>
              <tr>
                <td>Birthday</td>
                <td><?=$birthday?></td>
              </tr>
              <?php 
                if ($row->VerifiedAccount == 1) {
                  ?>
                  <tr>
                    <td>Fullname</td>
                    <td><?=$row->Fullname?></td>
                  </tr>
                  <tr>
                    <td>Contact Number</td>
                    <td><?=$row->ContactNumber?></td>
                  </tr>
                  <tr>
                    <td>Institution</td>
                    <td><?=$row->Institution?></td>
                  </tr>
                  <tr>
                    <td>Profession</td>
                    <td><?=$row->Profession?></td>
                  </tr>
                  <?php
                }
               ?>
            </table>
          </div>
          <div class="row my-4">
            <div class="col-9">
              <?php 
                if ($row->VerifiedAccount == 0) {
                  ?>
                  <label>Complete this form for account verification</label>
                  <a class="btn btn-success rounded-0" href="formverification.php" role="button">Form</a>
                  <?php
                }
               ?>
            </div>
            <div class="col-3">
              <a class="btn btn-success float-right rounded-0" href="profileedit.php" role="button">Edit</a>
            </div>
          </div>
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