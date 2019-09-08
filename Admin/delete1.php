<?php
$cn=new mysqli("localhost","root","","IOT") or die("Connection failed");
$name=$_POST['name'];
echo $name;
if ($cn->query("DELETE FROM CUSTOMER WHERE EMAIL='$name'")) {

           echo "<strong>Customer has been removed successfully</strong>";
           header("location:AdminHome.php");
       }
else
	echo $cn->error;
?>