<?php 
    $host_name = "localhost"; #Domain name of your website
    $user_name = "root"; #user name of your website
    $password  = ""; 
    $db_name   = "testing"; 

    $conn = mysqli_connect($host_name, $user_name, $password, $db_name);
    if(mysqli_connect_error()){
        echo "Connection failed!";
        exit;
    }

?>