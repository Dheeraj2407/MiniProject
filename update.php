<?php include 'functions.php'?>
<?php
 if($_SERVER['REQUEST_METHOD']=="POST"){
	session_start();
	$email=$_SESSION['uname']; 
		
 	if(isset($_POST['edit'])){
 	 $name=test_input($_POST['name']);
 	 $phone=test_input($_POST['phone']);
 	 $cn->query("UPDATE CUSTOMER SET UNAME='$name',PHONE=$phone WHERE EMAIL='$email'");
 	 
    }
    if(isset($_POST['change'])){
    	$pass=$_POST['pass'];
    	$npass=$_POST['npass'];
    	$result=$cn->query("SELECT PASSWORD FROM CUSTOMER WHERE EMAIL='$email'");
    	$row=$result->fetch_assoc();
    	if(strcmp($pass,$row['PASSWORD'])!=0){
    		echo "<script>alert('Wrong password');location.href='AboutYou.php'</script>";
    	}
    	else
    		$cn->query("UPDATE CUSTOMER SET PASSWORD='$npass' WHERE EMAIL='$email'");
    }
 	echo "<script>alert('Your details are updated');location.href='CustomerHome.php'</script>";
 	//$result=$cn->query("SELECT * FROM CUSTOMER WHERE EMAIL='$email'");


 }
?>