<html lang="en">
<head>
  <title>Customer Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap-3.3.7/dist/css/bootstrap.min.css">
  <script src="jquery.min.js"></script>
  <script src="bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
  <style type="text/css">
    .flip-box {
  background-color: transparent;
  width: 300px;
  height: 200px;
  border: 1px solid #f1f1f1;
  perspective: 1000px;
}

.flip-box-inner {
  position: relative;
  width: 100%;
  height: 100%;
  text-align: center;
  transition: transform 0.8s;
  transform-style: preserve-3d;
}

.flip-box:hover .flip-box-inner {
  transform: rotateY(180deg);
}

.flip-box-front, .flip-box-back {
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
}

.flip-box-front {
  background-color: #bbb;
  color: black;
}

.flip-box-back {
  background-color: #555;
  color: white;
  transform: rotateY(180deg);
}
  </style>

  <?php include 'functions.php';session_start();?>
  </head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
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
  <br><br>
  <h1>Welcome <?php
      $email=$_SESSION['uname'];
      /*if($email=="")
       header("location:home2.php");*/
      $result=$cn->query("SELECT * FROM CUSTOMER WHERE EMAIL='$email'");
      $row=$result->fetch_assoc();
      echo $row['UNAME'];
      //$cn->close();
      ?>
  </h1>
  <center><p><font size=25>Here is the list of items that you can sync with us.</font></p>
  <div class="flip-box">
  <div class="flip-box-inner">
    <div class="flip-box-front">
      <img src="arduino.png" alt="Basic Starter" style="width:300px;height:200px">
    </div>
    <div class="flip-box-back">
      <h2>Basic Starter</h2>
      <p>
        Contains Arduino with DHT11 and Light support.You can get weather of your home and control lights.
        <?php
          $result=$cn->query("SELECT * FROM DEVICES WHERE EMAIL='$email'");
          if($result->num_rows>0)
            echo "<button class='btn-primary disabled'>Added</button>";
          else
            echo "<button class='btn btn-info btn-lg' data-toggle='modal' data-target='#myModal'>+Add</button>"
        ?>
      </p>
    </div>
  </div>
</div>

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    <form action="YourDevices.php" method="GET">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Enter the IP address of ur board.</h4>
        </div>
        <div class="modal-body">
          <p><input type="text" name="IP" placeholder="192.168.43.197"></p>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default">
        </div>
      </div>
      </form>
    </div>
  </div>
</center>
</div>

</body>
</html>
