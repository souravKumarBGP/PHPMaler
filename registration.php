<?php 
    // Logic to start session
    if(session_status() === PHP_SESSION_NONE){
        session_start();
        session_regenerate_id(true);
    }

    if(isset($_SESSION["login_user_email"])){
        header("Location: ./index.php");
        exit;
    }

    // Logic to start server side codding with only SMPTMaler not validation
    require_once("./include_folder/db_connection.inc.php"); #include database connection fine
    
    $success_message_status = "none";
    
    if(isset($_POST["reg_submit_btn"])){
        extract($_POST);
        $inser_querry = "INSERT INTO tbl (user_full_name, user_gender, user_email, user_pass) VALUES ('{$user_full_name}', '{$user_gender}', '{$user_email}', '{$user_pass}')";

        $result = mysqli_query($conn, $inser_querry);
        if(mysqli_affected_rows($conn) == 1){
            $success_message_status = "block";
        }
        
    }



?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/style.css" />
    </head>

    <body>

        <?php require_once("./include_folder/navigation_manue.inc.php") ?>
                
        <main>
            
            <!-- ******************** Start login form section **************** -->
            <section class="reg_form">

                <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post" class="mx-auto mt-4">

                    <div class="success_error_message bg-success text-light font-bold p-2 mb-2"  style="display:  <?php echo $success_message_status?>" >
                        <p class="mb-0 py-1"><b>Registration successfully </b> <a href="./login.php" class="text-warning float-end">LOGIN</a> </p>
                    </div>
                    
                    <h5 class="text-center text-primary">REGISTRATION FORM</h5>
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name: </label>
                        <input type="text" class="form-control" name="user_full_name" id="full_name" placeholder="ex:- Soruav Kumar" value="Soruav Rupani" autofocus />
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender: </label>
                        <input type="text" class="form-control" name="user_gender" id="gender" placeholder="ex:- male" value="Male" />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Id: </label>
                        <input type="text" class="form-control" name="user_email" id="email" placeholder="ex:- s@gmail.com" value="rupani@gmail.com" />
                    </div>
                    <div class="mb-3">
                        <label for="create_pass" class="form-label">Create New Password: </label>
                        <input type="text" class="form-control" name="user_pass" id="create_pass"  autocomplete="off"  />
                    </div>
                    <input type="submit" class="form-control btn btn-primary rounded-0" name="reg_submit_btn" value="SIGNUP NOW" />

                    
                </form>
            </section><!--*** End of login_form-->
        
        </main><!--*** End of main-->
        
        <script>
            // Logic to hide error message every 2 second
            let error_message = document.querySelector(".success_error_message");
            setTimeout(() => {
                error_message.style.display = "none";
            }, 2500);
            
        </script>
        
        
    </body>
</html>