<?php
$mhost="localhost";
$muser="root";
$mpass="";
$mdb="IOT";
$cn=new mysqli($mhost,$muser,$mpass,$mdb) or die("Connection failed");
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
function login(){
	$email=$_SESSION['uname'];
	$cn=$GLOBALS['cn'];
	//echo "<script>alert('$cn->error')</script>";
    if(!$cn->query("INSERT INTO LOGS (EMAIL) VALUES('$email')"))
		echo "<script>alert(".$cn->error.")</script>";
	else{
		$result=$cn->query("SELECT LOGIN FROM LOGS WHERE EMAIL='$email' AND LOGOUT=NULL");
		$row=$result->fetch_assoc();
		//
	}
}
/*function logout(){
	
}*/
?>
