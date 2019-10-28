<html>
<head>
<?php
    $email=$_GET['q']; 
    echo "<title>$email</title>";
    include '../functions.php';
    $details=$cn->query("SELECT * FROM CUSTOMER WHERE EMAIL='$email'");
    $cust=$details->fetch_array();
    $fields=$cn->query("SELECT * FROM FIELDS WHERE Email='$email'");
    $fields=$fields->fetch_array();
?> 
<meta charset="utf-9">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../bootstrap-3.3.7/dist/css/bootstrap.min.css">
<script src="../jquery.min.js"></script>
<script src="../bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../w3.css"> 
</head>
<body>
    <a href="Customers.php" class="btn btn-info">
        <span class="glyphicon glyphicon-arrow-left"></span> Back
    </a>
    <h3>
    <form method="POST">
    <table class="table table-hover table-responsive" style="text-align:center">
        <?php
            echo "<tr><td><b>Email</b>:</td><td>$cust[0]</td></tr>";
            echo "<tr><td><b>User Name:</b></td><td>$cust[1]</td></tr>";
            echo "<tr><td><b>Phone:</b></td><td>$cust[2]</td></tr>";
            echo "<tr><td><b>Channel ID:</b></td><td>$cust[4]</td></tr>";
            echo "<tr><td><b>Write API:</b></td><td>$cust[5]</td></tr>";
            echo "<tr><td><b>Read API:</b></td><td>$cust[6]</td></tr>";
        ?>
        <tr>
            <td><b>Field 1:</b></td>
            <td><input type="text" name='field1' value=<?php echo $fields[1]?>></td>
            <td>Output: <input type="checkbox" name="f1"></td>
        </tr>
        <tr>
            <td><b>Field 2:</b></td>
            <td><input type="text" name='field2' value=<?php echo $fields[2]?>></td>
            <td>Output: <input type="checkbox" name="f2"></td>
        </tr>
        <tr>
            <td><b>Field 3:</b></td>
            <td><input type="text" name='field3' value=<?php echo $fields[3]?>></td>
            <td>Output: <input type="checkbox" name="f3"></td>
        </tr>
        <tr>
            <td><b>Field 4:</b></td>
            <td><input type="text" name='field4' value=<?php echo $fields[4]?>></td>
            <td>Output: <input type="checkbox" name="f4"></td>
        </tr>
        <tr>
            <td><b>Field 5:</b></td>
            <td><input type="text" name='field5' value=<?php echo $fields[5]?>></td>
            <td>Output: <input type="checkbox" name="f5"></td>
        </tr>
        <tr>
            <td><b>Field 6:</b></td>
            <td><input type="text" name='field6' value=<?php echo $fields[6]?>></td>
            <td>Output: <input type="checkbox" name="f6"></td>
        </tr>
        <tr>
            <td><b>Field 7:</b></td>
            <td><input type="text" name='field7' value=<?php echo $fields[7]?>></td>
            <td>Output: <input type="checkbox" name="f7"></td>
        </tr>
        <tr>
            <td><b>Field 8:</b></td>
            <td><input type="text" name='field8' value=<?php echo $fields[8]?>></td>
            <td>Output: <input type="checkbox" name="f8"></td>
        </tr>
        <tr>
            <td></td><td><input type="submit" class='btn btn-primary'></td>
        </tr>
    </table>
    </form>
<?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $r=$cn->query("UPDATE FIELDS SET Field1='$_POST[field1]',Field2='$_POST[field2]',Field3='$_POST[field3]',Field4='$_POST[field4]',Field5='$_POST[field5]',Field6='$_POST[field6]',Field7='$_POST[field7]',Field8='$_POST[field8]'");
        $a=[];
        for($i=1;$i<9;$i++){
            if(isset($_POST['f'.$i]))
                $a[$i]=1;
            else
                $a[$i]=0;
        }
        $r=$cn->query("UPDATE OUTCHECK SET F1=$a[1],F2=$a[2],F3=$a[3],F4=$a[4],F5=$a[5],F6=$a[6],F7=$a[7],F8=$a[8]");
    }
?>
</body>
</html>