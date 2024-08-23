<?php 
    

    // Logic to start session
    if(session_status() === PHP_SESSION_NONE){
        session_start();
        session_regenerate_id(true);
    }

    require_once("./include_folder/db_connection.inc.php");

    if(isset($_SESSION["login_user_email"]) || $_GET["verifcation_code"] == ""){
        header("Location: ./index.php");
        exit;
    }

    
    
    if(isset($_POST["rese_pass_submit_btn"])){

        
        
        $verification_code = mysqli_real_escape_string($conn, strip_tags(stripslashes($_GET["verifcation_code"])));
        $select_querry = "SELECT verify_code FROM tbl WHERE verify_code = '{$verification_code}'";
        $records = mysqli_query($conn, $select_querry);
        if(mysqli_num_rows($records) == 1){

            // Logic to check both password are same
            if($_POST["new_pass"] == $_POST["confirm_pass"]){
                $update_querry = "UPDATE tbl SET user_pass = '{$_POST["new_pass"]}'";
                $result = mysqli_query($conn, $update_querry);
                if($result){
                    echo "<center><strong style='color:green;'>PASSWORD CHANGE SUCCESSFULLY</strong> <p>Now you are ready for login </p> </center>";
                    echo '<meta http-equiv="refresh" content="2; url = http://localhost/phpProject/testing/login.php" />';
                    exit;
                }else{
                    echo "Something went wrong try after some time !";
                }
            }else{
                echo "Enter same password !";
            }
            
        }else{
            echo "Some thing went wrong. try again !";
            echo '<meta http-equiv="refresh" content="2; url = http://localhost/phpProject/testing/login.php" />';
        }

        
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset your password</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/style.css" />
    </head>
    <body>

        <main>
            
            <!-- ******************** Start login form section **************** -->
            <section class="forget_pass_form">
                <form method="post" class=" mx-auto mt-5">
                    <div class="mb-3">
                        <label for="password" class="form-label">Enter New Password: </label>
                        <input type="text" class="form-control" name="new_pass" id="email" autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="create_pass" class="form-label">Confirm Password: </label>
                        <input type="password" class="form-control" name="confirm_pass" id="create_pass"  autocomplete="off" />
                    </div>
                    <input type="submit" class="form-control btn btn-primary rounded-0" name="rese_pass_submit_btn" value="RESET NOW" />
                    
                </form>
                
            </section><!--*** End of login_form-->

        </main><!--*** End of main-->
        
        
    </body>
</html>