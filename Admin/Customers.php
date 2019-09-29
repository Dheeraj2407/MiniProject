<html lang="en">
<head>
  <title>Administrator Home</title>
  <meta charset="utf-9">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../bootstrap-3.3.7/dist/css/bootstrap.min.css">
  <script src="../jquery.min.js"></script>
  <script src="../bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="../w3.css"> 
  
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="../home2.php">INTERNETHOME.COM</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="AdminHome.php"><!span class="glyphicon glyphicon-header"> Home </a></li>
      <li class="active"><a href="#"><!span class="glyphicon glyphicon-eye-open"> CustomerDetails </a></li>
      <li><a href="Logs.php"><!span class="glyphicon glyphicon-list-alt"> Logs </a></li>
      <li><a href="UpdateLogs.php"><!span class="glyphicon glyphicon-refresh"> UpdateLogs </a></li>
      
      
    </ul>
    <ul class="nav navbar-nav navbar-right">
       <li><a href="../home2.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>

<html>
<head>
<?php
session_start();
if(!isset($_SESSION['aname']))
  header("location:../home2.php");
$cn=mysqli_connect("localhost","root","","IOT");
    $contacts = mysqli_query($cn,"
        SELECT * FROM CUSTOMER ORDER BY UNAME") or die( mysqli_error($cn) );
    if( mysqli_num_rows($contacts) > 0 )?>
</head>
    <table id="Customer-list" class="w3-table-all w3-centered w3-hoverable w3-card-4">
            <tr class="w3-black">
                <th>Email</th>
                <th>User Name</th>
                <th>Phone</th>
            </tr>
       
        <?php while( $customer = mysqli_fetch_array( $contacts) ) : ?>
             <tr>
                <td><?php echo $customer[0]; ?></td> 
                
                <td><?php echo $customer[1]; ?></td>
                
                <td><?php echo $customer[2]; ?></td>               
            </tr>
        <?php endwhile; ?>
    </table>
