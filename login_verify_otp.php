<?php 
    // Logic to start session
    if(session_status() === PHP_SESSION_NONE){
        session_start();
        session_regenerate_id(true);
    }

    if(!isset($_SESSION["otp_verifidation_email"])){
        header("Location: ./login.php");
        exit;
    }

    require_once "./include_folder/db_connection.inc.php";

    if(isset($_POST["login_verify_submit_btn"])){
        $email = $_SESSION["otp_verifidation_email"];
        $select_querry = "SELECT verify_code, account_status FROM tbl WHERE user_email = '{$email}'";
        $result = mysqli_query($conn, $select_querry);
        $records = mysqli_fetch_assoc($result);
        
        if(mysqli_num_rows($result) == 1){

            // Logic to check account status is 0 (dactive) then then active the account else account status is 1(active) that means account is already activate
            if($records["account_status"] == 0){
                if($_POST["input_otp"] === $records["verify_code"]){
                    $update_querry = "UPDATE tbl SET account_status = 1";
                    mysqli_query($conn, $update_querry);
                    $_SESSION["login_user_email"] = $email;
                    unset($_SESSION["otp_verifidation_email"]);
                    header("Location: ./index.php");

                }else{
                    echo "Enter valid OTP !";
                }
            }else{
                echo "Account already varified !";
                // header("Location: ./index.php");
            }
            
        }else{
            echo "This email is not registred !";
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
            <section class="forget_pass_form">

                <div class="message_box col-12 col-xl-4 mx-auto mt-4">
                    <p>A OTP verification code send on your email id open your email id and verify otp</p>
                    
                </div>

                <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post" class=" mx-auto mt-5">
                    <h5 class="text-center text-primary">VERIFY OTP</h5>
                    
                    <div class="mb-3">
                        <label for="create_pass" class="form-label">ENTER OTP: </label>
                        <input type="text" class="form-control" name="input_otp"  autocomplete="off" />
                    </div>
                    <input type="submit" class="form-control btn btn-primary rounded-0" name="login_verify_submit_btn" value="VERIFY NOW" />
                    
                    <div class="resend_otp_box d-flex justify-content-between mt-4">
                    <small class="text-primary" style="font-size: 12px;"><b>HELP LINE NUMBER:</b> +91 9065608408</small>
                        <a href="#">RESEND OTP</a>
                    </div>
                    
                </form>
                
            </section><!--*** End of login_form-->

        </main><!--*** End of main-->
        
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
     
    </body>
</html>