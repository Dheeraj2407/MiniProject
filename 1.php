<html>
<head>
</head>
<body>
<h2>	
<?php
 session_start();
 $email=$_SESSION['uname'];
 $IP=$_SERVER['REMOTE_ADDR'];
 $cn=new mysqli("localhost","root","","IOT") or die("Connection failed");
 $result=$cn->query("SELECT s.IP,s.Temparature,s.Humidity,max(Time) as Time FROM sensor s,devices d WHERE EMAIL='$email' AND s.ip=d.ip ");
 echo $cn->error;
 $result=$result->fetch_array();
 echo "Humidity:".$result['Humidity']."gm/cm3<br>Temperature:".$result['Temparature']."F<br>Time:".$result['Time'];
?>
</h2>
</body> 
</html>
