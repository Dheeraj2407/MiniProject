<?php include 'functions.php'?>
<?php
    session_start();
    $email=$_SESSION['uname'];
    $channelid=$cn->query("SELECT channelid FROM CUSTOMER WHERE EMAIL='$email'");
    $channelid=$channelid->fetch_array()[0];
    /*Creating channel on thingspeak*/
    # Our new data
    $data = array(
        'api_key' => 'U29BKV0D037L56DJ'
    );
    # Create a connection
    $url = 'https://api.thingspeak.com/channels/'.$channelid.'.json';
    echo $url;
    $ch = curl_init($url);
    # Form data string
    $postString = http_build_query($data, '', '&');
    # Setting our options
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
    # Get the response
    $response = curl_exec($ch);
    $json=json_decode($response);
    var_dump($json);
    curl_close($ch);
      
      /*End*/
    $cn->query("DELETE FROM CUSTOMER WHERE EMAIL='$email'");
    echo "<script>alert('Account deleted successfully');location.href='home2.php'</script>";
?> 