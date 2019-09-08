<?php
$mhost="localhost";
$muser="root";
$mpass="";
$mdb="IOT";
$cn=new mysqli($mhost,$muser,$mpass,$mdb) or die("Connection failed");
$Humidity=$_GET['Humidity'];
$Temparature=$_GET['Temparature'];
$IP=$_SERVER['REMOTE_ADDR'];
$sql= "INSERT INTO sensor(IP,Humidity,Temparature) VALUES ('$IP','$Humidity','$Temparature');";
mysqli_query($cn,$sql);
//header($_SERVER["SERVER_PROTOCOL"]."404")
$result=mysqli_query($cn,"SELECT STATUS FROM BULB_STATUS WHERE IP='$IP'");
$row=mysqli_fetch_array($result);
echo $row[0];
?>