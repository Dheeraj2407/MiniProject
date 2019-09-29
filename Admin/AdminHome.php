<html lang="en">
<head>
  <title>Administrator Home</title>
  <meta charset="utf-9">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../bootstrap-3.3.7/dist/css/bootstrap.min.css">
  <script src="../jquery.min.js"></script>
  <script src="../bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="../home2.php">INTERNETHOME.COM</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#"><!span class="glyphicon glyphicon-header"> Home </a></li>
      <li><a href="Customers.php"><!span class="glyphicon glyphicon-eye-open"> CustomerDetails </a></li>
      <li><a href="Logs.php"><!span class="glyphicon glyphicon-list-alt"> Logs </a></li>
      <li><a href="UpdateLogs.php"><!span class="glyphicon glyphicon-refresh"> UpdateLogs </a></li>
      
      
    </ul>
    <ul class="nav navbar-nav navbar-right">
       <li><a href="../home2.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>
  
<div class="container">
  <h1>Welcome <?php
  $cn=mysqli_connect("localhost","root","","IOT");
  session_start();
      $email=$_SESSION['aname'];
      /*if($email=="")
       header("location:home2.php");*/
      $result=$cn->query("SELECT * FROM CUSTOMER WHERE EMAIL='$email'");
      $row=$result->fetch_assoc();
      echo $row['UNAME'];
      //logout();
      ?></h1>
  
</div>
</body>
</html>
