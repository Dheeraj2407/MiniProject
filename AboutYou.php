<html lang="en">
<head>
  <title>About You</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap-3.3.7/dist/css/bootstrap.min.css">
  <script src="jquery.min.js"></script>
  <script src="bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
  <?php include 'functions.php'?>
   <?php 
    session_start();
    $email=$_SESSION['uname'];
    /*if($email=="")
      header("location:home2.php");*/
    $result=$cn->query("SELECT * FROM CUSTOMER WHERE EMAIL='$email'");
    $row=$result->fetch_array();
  ?>
  <style>
  body{
    background: url('about-you.jpg') no-repeat center fixed ;
    background-size:cover;
    z-index: -2;
  }
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
  float:right;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
.valid {
    color: green;
}

.valid:before {
    position: relative;
    left: -35px;
    content: "\2713";
}

/* Add a red text color and an "x" when the requirements are wrong */
.invalid {
    color: red;
}

.invalid:before {
    position: relative;
    left: -35px;
    content: "\2716";
}
</style>
</head>
<body onload="checkBox('edit');checkBox('change')">

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="home2.php">INTERNETHOME.COM</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="CustomerHome.php">Home</a></li>
      <li><a href="YourDevices.php">Your Devices</a></li>
      <li class="active"><a href="#">About You</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
       <li><a href="home2.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>
  
<div class="container">
  
  <h3 ondblclick="del()" title="Double click to delete account" style="cursor: pointer;">It's all about you</h3>
  
  
  <form action="update.php" method="POST">
   <label class="switch">
   <input type="checkbox" id="edit" name='edit' onclick="checkBox('edit')" value="edit">
   <span class="slider round"></span>
   </label>
   <span style="font-size: 25px;float: right;clear: left;padding-right: 10px">Edit</span>



  <table style="font-size: 20px;margin: 10px;padding:10px">

    <tr>
      <td>Email:</td>
      <td><input type="email" name="email" id="email" value="<?php echo $email ?>" class="form-control" disabled="true" required></td>
    </tr>

    <tr>
      <td>Name:</td>
      <td><input type="text" name="name" id="name" value="<?php echo $row['UNAME'];?>" class="form-control" required></td>
    </tr>
    
    <tr>
      <td>Phone:</td>
      <td><input type="text" name="phone" id="phone" value="<?php echo $row['PHONE'];?>" class="form-control" pattern="(?=.*[0-9]).{10,}" required></td>
    </tr>
  
  <br><br>
  <label class="switch">
  <input type="checkbox" id="change" name='change' onclick="checkBox('change')" value="change">
  <span class="slider round"></span>
  </label>
  <span style="font-size: 25px;float: right;clear: left;padding-right: 10px">Change Password</span>
  
  
   <tr>
     <td>Old Password:</td>
     <td><input type="password" name="pass" id="pass" class="form-control" required></td>     
   </tr>
   <tr>
     <td>New Password:</td>
     <td><input type="password" name="npass" id="npass" class="form-control" (?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required></td>
   </tr>
   <tr>
     <td>Confirm Password:</td>
     <td><input type="password" name="cpass" id="cpass" class="form-control" (?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required></td>
   </tr>
   <tr>
     <td></td>
     <td><button name="update" type="submit" class="btn btn-success">Update</button></td>
   </tr>
 </table>
</form>

<p class="invalid" id="message" style="display: none"><b>Correct password</b></p>
  <p class="invalid" id="psw_message" style="display: none"><b>Passwords match</b></p>

  <div id="message1" style="display: none">
       <h3>Password must contain the following:</h3>
       <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
       <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
       <p id="number" class="invalid">A <b>number</b></p>
       <p id="length" class="invalid">Minimum <b>8 characters</b></p>
</div>


</div>
<script type="text/javascript">
  
var p1,p2,p3;
  function checkBox($id){
    
    if($id=="edit"){
      p1=document.getElementById('name');
      p2=document.getElementById('phone');
      p3=document.getElementById('phone');
    }
    else{
      p1=document.getElementById('pass');
      p2=document.getElementById('npass');
      p3=document.getElementById('cpass');
    }
    if(document.getElementById($id).checked){
      p1.disabled=p2.disabled=p3.disabled=false;
      //alert("enabled");
    }
    else{
      p1.disabled=p2.disabled=p3.disabled=true;
      //alert("disabled");
    }
  }


  
  var password=document.getElementById('psw_message');
  var message=document.getElementById('message');
  var letter = document.getElementById("letter");
  var capital = document.getElementById("capital");
  var number = document.getElementById("number");
  var length = document.getElementById("length");
  var myInput,retype,myInput1;

  myInput=document.getElementById('npass');
  myInput1=document.getElementById('pass');
  retype=document.getElementById('cpass');

  retype.onfocus = function() {
    document.getElementById("psw_message").style.display = "block";
  }

  retype.onblur = function() {
    document.getElementById("psw_message").style.display = "none";
  }

  retype.onkeyup = function() {
   if(document.getElementById('npass').value.localeCompare(retype.value)==0) {
     password.classList.remove("invalid");
     password.classList.add("valid");
   }
   else {
     password.classList.remove("valid");
     password.classList.add("invalid");
   }
  }




  myInput1.onfocus=function(){
    document.getElementById("message").style.display = "block";
  }

  myInput1.onblur=function(){
    document.getElementById("message").style.display = "none";
  }
  


  myInput1.onkeyup=function(){
    var pass="<?php echo $row['PASSWORD']?>";
    if(myInput1.value.localeCompare(pass)==0){
      message.classList.remove("invalid");
      message.classList.add("valid");
    }
    else{
      message.classList.remove("valid");
      message.classList.add("invalid");
    }
  }

  myInput.onfocus = function() {
    document.getElementById("message1").style.display = "block";
  }
  myInput.onblur = function() {
    document.getElementById("message1").style.display = "none";
  } 

  
  // When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } 
  else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } 
  else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } 
  else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  }
  else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
  
 }
 function del(){
  if(confirm("Do you want to delete your account?")){
    location.href="delete.php";
  }
}
 
</script>
</body>
</html>
