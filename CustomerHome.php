<html lang="en">
<head>
  <title>Customer Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap-3.3.7/dist/css/bootstrap.min.css">
  <script src="jquery.min.js"></script>
  <script src="bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
  <?php include 'functions.php';session_start();?>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="home2.php">INTERNETHOME.COM</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="YourDevices.php">Your Devices</a></li>
      <li><a href="AboutYou.php">About You</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
       <li><a href="home2.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>
  
<div class="container">
  <h1>Welcome <?php
      $email=$_SESSION['uname'];
      /*if($email=="")
       header("location:home2.php");*/
      $result=$cn->query("SELECT * FROM CUSTOMER WHERE EMAIL='$email'");
      $row=$result->fetch_assoc();
      echo $row['UNAME'];
      //logout();
      ?>
  </h1>
  <p><embed src="PDF/Usermanual.pdf" width="100%" height="100%"></p>
</div>
</body>
</html>
