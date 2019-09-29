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
      <li><a href="CustomerHome.php">Home</a></li>
      <li class="active"><a href="#">Devices</a></li>
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
      $email=$_SESSION['aname'];
      /*if($email=="")
       header("location:home2.php");*/
      $result=$cn->query("SELECT * FROM CUSTOMER WHERE EMAIL='$email'");
      $row=$result->fetch_assoc();
      echo $row['UNAME'];
      //$cn->close();
      ?>
  </h1>
	<p>Here is the list of items that you can sync with us.</p>
  
</body>
</html>
