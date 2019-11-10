<?php
    $email=$_GET['email'];
    $field=$_GET['field'];
    $value=$_GET['value'];
    echo $value;
    $v=file_get_contents("http://cvmaison.000webhostapp.com/write_field.php?email=$email&field=$field&value=$value");
    #$x=file_get_contents("http://cvmaison.000webhostapp.com/write_field.php");
    echo $v;
?>