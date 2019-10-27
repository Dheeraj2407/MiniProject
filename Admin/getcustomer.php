<?php
    include "../functions.php";
    $search=$_GET['q'];
    $query="SELECT * FROM CUSTOMER WHERE EMAIL LIKE '$search%'";
    $result=$cn->query($query);
    if($result->num_rows>0){
        echo '<h3>Search results:</h3><br>
        <table id="search-list" class="w3-table-all w3-centered w3-hoverable w3-card-4">
        <tr class="w3-black">
            <th>Email</th>
            <th>User Name</th>
            <th>Phone</th>
            <th>Chanel Id</th>
        </tr>';
        while($row=$result->fetch_array()){
            echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[4]</td></tr>";
        }
        echo "</table>";
    }
    else
        echo "<h3 style='text-align:center'>Not found!</h3>"
?>