<?php 
    // Logic to start session
    if(session_status() === PHP_SESSION_NONE){
        session_start();
        session_regenerate_id(true);
    }

    require_once("./include_folder/db_connection.inc.php");
    $update_querry = "UPDATE tbl SET verify_code = null,  account_status = 0";
    mysqli_query($conn, $update_querry);
    
    session_unset();
    session_destroy();
    header("Location: ./login.php");
    exit;
?>