<?php 
    // Logic to start session
    if(session_status() === PHP_SESSION_NONE){
        session_start();
        session_regenerate_id(true);
    }
    if(!isset($_SESSION["login_user_email"])){
        header("Location: ./login.php");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/style.css" />
    </head>
    <body>
        <?php require_once"./include_folder/navigation_manue.inc.php" ?>
        <h1 class="mt-5 text-center text-primary">Wealcome to Home page</h1>
    </body>
</html>