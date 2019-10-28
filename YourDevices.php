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
      <li class="active"><a href="#">Your Devices</a></li>
      <li><a href="AboutYou.php">About You</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
       <li><a href="home2.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>
  
<div class="container">
  <?php
    $email=$_SESSION['uname'];
    $fields=$cn->query("SELECT * FROM FIELDS WHERE Email='$email'");
    $fields=$fields->fetch_array();
    $out=$cn->query("SELECT * FROM OUTCHECK WHERE Email='$email'");
    $out=$out->fetch_array();
    $c=$cn->query("SELECT * FROM CUSTOMER WHERE EMAIL='$email'");
    $c=$c->fetch_assoc();
    for($i=1;$i<9;$i++){
      if($fields[$i]!=""){
        if($out[$i]==1){
          
        }
        else{
          echo '<figure><iframe width="450" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/'.$c["channelid"].'/charts/'.$i.'?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&type=line&update=15"></iframe>';
          echo "<figcaption><b>$fields[$i]</b></figcaption></figure>";
        }
      }
    }
  ?>
</div>
</body>
</html>
