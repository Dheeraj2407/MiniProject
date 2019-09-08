<?php include 'functions.php'?>
<?php
 session_start();
 $email=$_SESSION['uname'];
 $cn->query("DELETE FROM CUSTOMER WHERE EMAIL='$email'");
 echo "<script>alert('Account deleted successfully');location.href='home2.php'</script>";
?> 