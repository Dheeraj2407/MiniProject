<html>
<head>
  <title>INTERNETHOME</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'functions.php'?>
<?php
session_start();
if(isset($_SESSION['uname'])){
 $email=$_SESSION['uname'];
  $cn=$GLOBALS['cn'];
  //$login=$_SESSION['login'];
  if(!$cn->query("CALL LOGOUT('$email')"))
    echo "<script>alert(".$cn->error.")</script>";
 unset($_SESSION["uname"]);
}
if($_SERVER['REQUEST_METHOD']=="POST") {
  $submit=$_POST['submit'];
  //$cn->query("INSERT INTO LOGGERLOG VALUES('kum')");
  
  if(strcmp($submit,"login")==0){
  
   $uname=test_input($_POST['uname']);
   $psw1=test_input($_POST['psw1']);
   
   $_SESSION['uname']=$uname;
   $res1=$cn->query("SELECT * FROM CUSTOMER WHERE EMAIL='$uname' and password='$psw1'");
   if($res1->num_rows==1){
      login();
      echo "<script>location.href='CustomerHome.php'</script>";
   }
   else
     echo "<script>alert('username or password doesnot exist')</script>";
  }

  else if(strcmp($submit,"signup")==0){
   $email=test_input($_POST['email']);
   $name=test_input($_POST['name']);
   $pass=test_input($_POST['psw']);
   $phone=test_input($_POST['phone']);
   $admin=test_input($_POST['AdminID']);
   $account="";
   
   if (!mysqli_query($cn,"INSERT INTO CUSTOMER VALUES ('$email','$name','$phone','$pass','0','0','0')"))
   {
    echo "<script>alert('Email already exists')</script>";
   
   }
  else{
    /*Creating channel on thingspeak*/
    # Our new data
    $data = array(
      'api_key' => 'U29BKV0D037L56DJ',
      'name' => $email
    );
    # Create a connection
    $url = 'https://api.thingspeak.com/channels.json';
    $ch = curl_init($url);
    # Form data string
    $postString = http_build_query($data, '', '&');
    # Setting our options
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    # Get the response
    $response = curl_exec($ch);
    $json=json_decode($response);
    $id=$json->id;
    $api_keys=[];
    foreach($json->api_keys as $key=>$value){
        array_push($api_keys,$value->api_key);
    }
    $g=mysqli_query($cn,"UPDATE CUSTOMER set channelid='$id',read_api='$api_keys[1]',write_api='$api_keys[0]' where EMAIL='$email'");
    curl_close($ch);
    
    /*End*/
    if(isset($admin)){
     if($cn->query("INSERT INTO ADMIN VALUES('$email','$admin')")){
      $account=" admin account created"; 
     }
     else
      $account=" account created";
      echo "<script>alert('Signup successful')</script>";
   } 
  }
} 
  else if(strcmp($submit, "adminlogin")==0){
    $uname=test_input($_POST['uname']);
    $psw1=test_input($_POST['psw1']);
    $id=test_input($_POST['adminid']) ;  
    $_SESSION['uname']=$uname;
    $res1=$cn->query("SELECT * FROM CUSTOMER WHERE EMAIL='$uname' and password='$psw1'");
    $res2=$cn->query("SELECT * FROM ADMIN WHERE EMAIL='$uname' AND IDNUM='$id'");
    if($res1->num_rows==1 && $res2->num_rows==1){
      $_SESSION['aname']=$uname;
      echo "<script>location.href='Admin/AdminHome.php'</script>";
    }
    else
     echo "<script>alert('Admin authentication failed')</script>";
  }


}

?>

<style>
/* Full-width input fields */
input[type=text], input[type=password],input[type=Email] {
    width: 100%;
    padding: 15px;
    margin: 2px 0 7px 0;
    display: inline-block;
    border: none;
    background: #f1f1f1;
}

body {font-family: Arial, Helvetica, sans-serif;
background-color:#000;
background-image:url("security.jpg");
background-repeat:no-repeat;
background-attachment: fixed;
background-size:cover;
background-position:center;


}
* {box-sizing: border-box;}



/* Set a style for all buttons */
button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
    opacity: 0.9;
}
.green{
float:right;
background-color:none;
}

button:hover {
    opacity: 0.7;
}
.disabled{
  opacity:0.6;
  cursor: not-allowed;
}

/* Extra styles for the cancel button */
.cancelbtn1 {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

/* Center the image and position the closel1 button */
.imgcontainer1 {
    text-align: center;
    margin: 24px 0 12px 0;
    position: relative;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.container1 {
    padding: 16px;
}

span.psw1 {
    float: right;
    padding-top: 16px;
}

/* The modal1 (background) */
.modal1 {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 50px;
}

/* modal1 Content/Box */
.modal1-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 30%; /* Could be more or less, depending on screen size */
}

/* The closel1 Button (x) */
.closel1 {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;
}

.closel1:hover,
.closel1:focus {
    color: red;
    cursor: pointer;
}

/* Add Zoom Animation */
.animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
    from {-webkit-transform: scale(0)} 
    to {-webkit-transform: scale(1)}
}
    
@keyframes animatezoom {
    from {transform: scale(0)} 
    to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw1 {
       display: block;
       float: none;
    }
    .cancelbtn1 {
       width: 100%;
    }
}
/* Extra styles for the cancel button */
.cancelbtn {
    padding: 14px 20px;
    background-color: #f44336;
}

/* Float cancel and signup buttons and add an equal width */
.cancelbtn, .signupbtn {
  float: left;
  width: 50%;
}

/* Add padding to container elements */
.container {
    padding: 16px;
}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 50px;
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 30%; /* Could be more or less, depending on screen size */
}

/* Style the horizontal ruler */
hr {
    border: 1px solid #f1f1f1;
    margin-bottom: 25px;
}
 
/* The Close Button (x) */
.close {
    position: absolute;
    right: 35px;
    top: 15px;
    font-size: 40px;
    font-weight: bold;
    color: #f1f1f1;
}

.close:hover,
.close:focus {
    color: #f44336;
    cursor: pointer;
}

/* Clear floats */
.clearfix::after {
    content: "";
    clear: both;
    display: table;
}

/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
    .cancelbtn, .signupbtn {
       width: 100%;
    }
}
/*For password checking*/
/* The message box is shown when the user clicks on the password field */
#message {
    display:none;
    background: #f1f1f1;
    color: #000;
    position: relative;
    padding: 20px;
    margin-top: 10px;
}

#message p {
    padding: 10px 35px;
    font-size: 18px;
}

/* The message box is shown when the user clicks on the retype-password field */
#psw_message {
    display:none;
    background: #f1f1f1;
    color: #000;
    position: relative;
    padding: 20px;
    margin-top: 10px;
}

#psw_message p {
    padding: 10px 35px;
    font-size: 18px;
}

/* Add a green text color and a checkmark when the requirements are right */
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
.glow {
  font-size: 80px;
  color: #fff;
  text-align: center;
  -webkit-animation: glow 3s ease-in-out infinite alternate;
  -moz-animation: glow 3s ease-in-out infinite alternate;
  animation: glow 3s ease-in-out infinite alternate;
}

@-webkit-keyframes glow {
  from {
     text-shadow: 0 0 10px #000, 0 0 20px #000, 0 0 30px #fff, 0 0 40px #fff, 0 0 50px #fff, 0 0 60px #fff, 0 0 70px #fff;
  }
  to {
    text-shadow: 0 0 20px #000, 0 0 30px #000, 0 0 40px #fff, 0 0 50px #fff, 0 0 60px #fff, 0 0 70px #fff, 0 0 80px #fff;
  }
}
#phrase {
	
	font-variant: small-caps;
	text-size:10vw;
	font-family:"Times New Roman";
}


/*Sidenav*/

.overlay {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0, 0.9);
  overflow-x: hidden;
  transition: 0.5s;
}

.overlay-content {
  position: relative;
  top: 25%;
  width: 100%;
  text-align: center;
  margin-top: 30px;
}

.overlay a {
  padding: 8px;
  text-decoration: none;
  font-size: 36px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.overlay a:hover, .overlay a:focus {
  color: #f1f1f1;
}

.overlay .closebtn {
  position: absolute;
  top: 20px;
  right: 45px;
  font-size: 60px;
}

@media screen and (max-height: 450px) {
  .overlay a {font-size: 20px}
  .overlay .closebtn {
  font-size: 40px;
  top: 15px;
  right: 35px;
  }
}


</style>
</head>
<body>
<button class="green" onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Login</button>
<button class="green" onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Sign Up</button>

<div id="phrase" class="glow"><span style="cursor:pointer" onclick="openNav()">Connector Votre Maison &reg;</span></div>


<br>
<canvas id="canvas" width="400" height="400"></canvas>



<div id="id03" class="modal1">
  
  <form class="modal1-content animate" action="home2.php" method="POST">
    <div class="imgcontainer1">
      <span onclick="document.getElementById('id03').style.display='none'" class="closel1" title="closel1 modal1">&times;</span>
      <img src="img_avatar2.png" alt="Avatar" class="avatar">
    </div>

    <div class="container1">
      
      <input type="Email" placeholder="Email" name="uname" required>

     
      <input type="password" placeholder="Password"  name="psw1">
      <input type="text" placeholder="AdminId" name="adminid">
      <button type="submit" name="submit" value="adminlogin">Login</button>
      
    </div>

    <div class="container1" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id03').style.display='none'" class="cancelbtn1">Cancel</button>
    </div>
  </form>
</div>

<div id="id02" class="modal1">
  
  <form class="modal1-content animate" action="home2.php" method="POST">
    <div class="imgcontainer1">
      <span onclick="document.getElementById('id02').style.display='none'" class="closel1" title="closel1 modal1">&times;</span>
      <img src="img_avatar2.png" alt="Avatar" class="avatar">
    </div>

    <div class="container1">
      
      <input type="Email" placeholder="Email" name="uname" class="form-control" required>

     
      <input type="password" placeholder="Password" class="form-control" name="psw1">
   
      <button type="submit" name="submit" value="login">Login</button>
      
    </div>

    <div class="container1" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn1">Cancel</button>
      <!--span class="psw1">Forgot <a href="#">password?</a></span-->
    </div>
  </form>
</div>

<!--Sidenav-->
<div id="myNav" class="overlay">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div class="overlay-content">
  <a href="#" onclick="closeNav();document.getElementById('id03').style.display='block'">Admin Login</a>
    <a href="#">About</a>
    <a href="#">Contact</a>
  </div>
</div>




<div id="id01" class="modal">
  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
  <form class="modal-content animate" action="home2.php" method="POST">
    <div class="container">
      <h1>Sign Up</h1>
      <p>Please fill in this form to create an account.</p>
      <hr>
      <input type="Email" placeholder="Email" name="email" required>
      
      
      <input type="text" placeholder="Name" name="name" required>

      
      <input type="text" placeholder="Phone number" name="phone" pattern="(?=.*[0-9]).{10,}" required>

       
    <input type="password" id="psw" placeholder="Password" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
    <div id="message">
       <h3>Password must contain the following:</h3>
       <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
       <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
       <p id="number" class="invalid">A <b>number</b></p>
       <p id="length" class="invalid">Minimum <b>8 characters</b></p>
    </div>    

      
      <input type="password" id="psw-repeat" placeholder="Confirm Password" name="psw-repeat" required>
      <div id="psw_message">
       <p id="password" class="invalid"><b>Passwords match</b></p>
    </div>
      <div id="admin" style="display: none">
      <input type="text" placeholder="AdminId" name="AdminID">
      </div>
    
    <input type="checkbox" id="admincheck" onclick="admin('admincheck','admin')"><b>Admin Signup(only for admins)</b>
	  
      <div class="clearfix">
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        <button type="submit" name="submit" id="signup" class="signupbtn disabled" value="signup" disabled="true">Sign Up</button>
      </div>
    
  </form>
</div>
<script>
// Get the modal1
var modal1 = document.getElementById('id01');

// When the user clicks anywhere outside of the modal1, closel1 it
window.onclick = function(event) {
    if (event.target == modal1) {
        modal1.style.display = "none";
    }
}
// Get the modal
var modal = document.getElementById('id02');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal1) {
        modal1.style.display = "none";
    }
//password checking
var myInput = document.getElementById("psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");
var retype = document.getElementById("psw-repeat");
var signup=document.getElementById("signup");
//When th user clicks on the retype-password field, show the message box
retype.onfocus = function() {
    document.getElementById("psw_message").style.display = "block";
}

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
    document.getElementById("message").style.display = "block";
    window.scrollBy(0,100);
}

// When the user clicks outside of the retype-password field, hide the message box
retype.onblur = function() {
    document.getElementById("psw_message").style.display = "none";
    if(myInput.value.localeCompare(retype.value)==0) {
     signup.classList.remove("disabled");
     signup.disabled=false;
    }
    else {
     signup.classList.add("disabled");
     signup.disabled=true;
    }

}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
    document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the retype-password field
retype.onkeyup = function() {
  if(myInput.value.localeCompare(retype.value)==0 && myInput.value!='') {
    password.classList.remove("invalid");
    password.classList.add("valid");
    signup.classList.remove("disabled");
    signup.disabled=false;
  }
  else {
    password.classList.remove("valid");
    password.classList.add("invalid");
    signup.classList.add("disabled");
    signup.disabled=true;
  }
}
// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
  
 }
}

function admin($check,$input) {
  if(document.getElementById($check).checked)
    document.getElementById($input).style.display="block";
  else
    document.getElementById($input).style.display="none";
}
/*Sidenav*/
function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}
</script>

</body>
</html>

