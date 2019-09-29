<html lang="en">
<head>
  <title>Customer Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap-3.3.7/dist/css/bootstrap.min.css">
  <script src="jquery.min.js"></script>
  <script src="bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
  <?php include 'functions.php';session_start();?>
<!--?php
 $email=$_SESSION['uname'];
 $red=$cn->query("SELECT IP FROM DEVICES WHERE EMAIL='$email'");
 if($red->num_rows==0 && !isset($_GET["IP"])){
  echo "<script>alert('Please add a device');location.href='Devices.php'</script>"  ;
 } 
  if(isset($_GET["IP"])){
    $IP=$_GET["IP"];
    if($cn->query("INSERT INTO DEVICES VALUES('$email','$IP')"))
      echo "<script>alert('Device added sucessfully')</script>";
    else{
      echo "<script>alert('Selected device was not added')</script>";
      //echo $cn->error;
      header("location:Devices.php");
    }
  }
  if(isset($_GET['status'])){
    echo $_GET['status'];
   if($_GET['status']=="pic_bulboff.gif") 
    $status="ON";
  else
    $status="OFF";
  $cn->query("UPDATE BULB_STATUS SET STATUS='$status'");
  echo $cn->error;
  } 

?>
<script>$(function(){

  window.setInterval(function(){
    loadLatestResults();
  }, 3000);

  function loadLatestResults(){

    $.ajax({
      url : '1.php',
      cache : false,
      success : function(data){
        $('#1').html(data);
      }
    });
  }

});
</script-->

</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="home2.php">INTERNETHOME.COM</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="CustomerHome.php">Home</a></li>
      <li class="active"><a href="#">Your Devices</a></li>
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
     // $cn->close();
      ?>
  </h1>
  <p>A navigation bar is a navigation header that is placed at the top of the page.</p>
  <center id=1></center>
  <!--?php
    $status=$cn->query("SELECT STATUS FROM BULB_STATUS WHERE IP IN (SELECT IP FROM DEVICES WHERE EMAIL='$email')");
    $status=$status->fetch_array();
    if($status[0]=='ON')
      $pic="pic_bulbon.gif";
    else
      $pic="pic_bulboff.gif";
  ?>

<form action="YourDevices.php" method="GET">
  <center><button name="status" onclick="submit" value="<?php echo $pic ?>"><img id="myImage" src="<?php echo $pic ?>" width="100" height="180"></button></center>
</form-->

  
</div>

</body>
<!script>
<!-- function changeImage() {
    var image = document.getElementById('myImage');
    if (image.src.match("bulbon")) {
        image.src = "pic_bulboff.gif";
    } else {
        image.src = "pic_bulbon.gif";
    }
} -->
<!/script>
</html>
