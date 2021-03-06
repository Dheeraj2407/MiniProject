<html lang="en">
<head>
  <title>Administrator Home</title>
  <meta charset="utf-9">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../bootstrap-3.3.7/dist/css/bootstrap.min.css">
  <script src="../jquery.min.js"></script>
  <script src="../bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="../w3.css"> 
  
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="../home2.php">INTERNETHOME.COM</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="AdminHome.php"><!span class="glyphicon glyphicon-header"> Home </a></li>
      <li class="active"><a href="#"><!span class="glyphicon glyphicon-eye-open"> CustomerDetails </a></li>
      <li><a href="Logs.php"><!span class="glyphicon glyphicon-list-alt"> Logs </a></li>
      <li><a href="UpdateLogs.php"><!span class="glyphicon glyphicon-refresh"> UpdateLogs </a></li>
      
      
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><input type="search" placeholder="Search customers..." id="search_cust" class="navbar-form" value=""></li>
      <li><a href="../home2.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>

<?php
  session_start();
  $search_text=" * ";
  if(!isset($_SESSION['aname']))
    header("location:../home2.php");
  $cn=mysqli_connect("localhost","root","","IOT");
  $contacts = mysqli_query($cn,"SELECT * FROM CUSTOMER ORDER BY UNAME") or die( mysqli_error($cn) );
  if( mysqli_num_rows($contacts) > 0 )
?>
  <p id="table"></p>
   <table id="Customer-list" class="w3-table-all w3-centered w3-hoverable w3-card-4">
            <tr class="w3-black">
                <th>Email</th>
                <th>User Name</th>
                <th>Phone</th>
                <th>Channel Id</th>
                <th>Write API</th>
                <th>Read API</th>
            </tr>
       
        <?php while( $customer = mysqli_fetch_array( $contacts) ) : 
             echo "<tr ondblclick=window.location='adddevice.php?q=$customer[0]'>";?>
                <td><?php echo $customer[0]; ?></td> 
                
                <td><?php echo $customer[1]; ?></td>
                
                <td><?php echo $customer[2]; ?></td>
                <td><?php echo $customer[4]; ?></td>               
                <td><?php echo $customer[5]; ?></td>               
                <td><?php echo $customer[6]; ?></td>               
            </tr>
        <?php endwhile; ?>
    </table>
<script>
  var s=document.getElementById("search_cust");
  var tab=document.getElementById("table");
  var l=document.getElementById("Customer-list");
  tab.appendChild(l);
  function loadTable(){
    var x=new XMLHttpRequest();
    x.onreadystatechange=function(){
      if(this.readyState==4 && this.status==200)
        tab.innerHTML=this.responseText;
    };
    x.open("GET","getcustomer.php?q="+s.value,true);
    x.send();
  }
  s.onkeyup=function(){
    if(s.value!==""){
      tab.removeChild(l);
      loadTable();
    }
    else{
      tab.innerHTML="";
      tab.appendChild(l);
    }
  }
</script>
</body>
</html>
