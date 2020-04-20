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
<body class="bg-dark">
  <?php 
    include "connect.php";
    session_start();
    include "checksession.php"
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
  
  </header>

  <!-- ------------------------------------------------ CONTENT ----------------------------------------------- -->

  <main class="container-fluid p-5 text-white">
    <div class="row justify-content-md-center">
      <div class="col-7 bg-dark2 p-5">
        <h1 class="text-center mb-4">CREATE EVENT</h1>
        <label class="text-warning mb-4 mt-3">* This form can be edited after it is created</label>
        <form method="post" action="createeventprocess.php">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control bg-transparent text-white rounded-0" name="name" placeholder="Name" required>
          </div>
          <div class="form-group">
            <label>City</label>
            <input type="text" class="form-control bg-transparent text-white rounded-0" name="city" placeholder="City" required>
          </div>
          <div class="form-group">
            <label>Location</label>
            <input type="text" class="form-control bg-transparent text-white rounded-0" name="location" placeholder="Location" required>
          </div>
          <div class="form-group">
            <label>Start Date and Time</label>
            <input type="datetime-local" class="form-control bg-transparent text-white rounded-0" name="startdatetime" placeholder="Start Date and Time" required>
          </div>
          <div class="form-group">
            <label>End Date and Time</label>
            <input type="datetime-local" class="form-control bg-transparent text-white rounded-0" name="enddatetime"  placeholder="End Date and Time" required>
          </div>
          <div class="form-group">
            <label>Company</label>
            <input type="text" class="form-control bg-transparent text-white rounded-0" name="company" placeholder="Company" required>
          </div>
          <div class="form-group">
            <label>Quota</label>
            <input type="number" class="form-control bg-transparent text-white rounded-0" name="quota" placeholder="Quota" required>
          </div>
          <div class="form-group">
            <label>Price</label>
            <input type="number" class="form-control bg-transparent text-white rounded-0" name="price" placeholder="Price" required>
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control bg-transparent text-white rounded-0" id="exampleFormControlTextarea1" name="description" rows="3" required>This is default description</textarea>
          </div>
          <div class="form-group py-1">
            <button type="submit" class="mt-4 btn btn-success btn-block rounded-0" name="submit">Create</button>
          </div>
        </form>
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