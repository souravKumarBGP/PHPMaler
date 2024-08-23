<?php   

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Logic to start session
    if(session_status() === PHP_SESSION_NONE){
        session_start();
        session_regenerate_id(true);
    }

    if(isset($_SESSION["login_user_email"])){
        header("Location: ./index.php");
        exit;
    }

    require_once("./include_folder/db_connection.inc.php");
    $success_message_status = "none";

    if(isset($_POST["login_submit_btn"])){
        extract($_POST);
        $select_querry = "SELECT user_full_name, user_email, user_pass FROM tbl WHERE user_email = '{$login_email}'";
        $result = mysqli_query($conn, $select_querry);
        if(mysqli_num_rows($result) == 1){
            $records = mysqli_fetch_assoc($result);
            
            // Logic to check password
            if($records["user_pass"] == $login_pass){
                $verification_otp = rand(111111, 999999);
                
                //Load Composer's autoloader
                require 'PHPMailer/Exception.php';
                require 'PHPMailer/PHPMailer.php';
                require 'PHPMailer/SMTP.php';

                // //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    
                    //Server settings
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                     
                    $mail->SMTPAuth   = true;                                   
                    $mail->Username   = 'svvk9094@gmail.com';                     
                    $mail->Password   = 'hdpdcpyjcfxfqvmx';                               
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
                    $mail->Port       = 465;                                    
                
                    //Recipients
                    $mail->setFrom('svvk9094@gmail.com', 'SOURAV RUPANI');
                    $mail->addAddress($records['user_email'], $records['user_full_name']);     
                    $mail->addReplyTo('svvk9094@gmail.com', 'SOURAV RUPANI');
                
                    //Content                
                    $mail->isHTML(true);                                  
                    $mail->Subject = 'LOGIN OTP VERIFICATION CODE';
                    $mail->Body    = "Dont share your OTP with third person<br/><b>YOUR OTP IS<b>: $verification_otp <br/>This OTP valid only 1 minitus";
                
                    if($mail->send()){

                        $update_querry = "UPDATE tbl SET verify_code = {$verification_otp}";
                        mysqli_query($conn, $update_querry);
                        $_SESSION["otp_verifidation_email"] = $records["user_email"];
                        header("Location: ./login_verify_otp.php");
                        exit;
                    }


                    // echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                

            }else{
                echo "Enter valid password !";
            }
            
        }else{
            echo "This email is not registred. Please registred your email before login";
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
            <section class="login_form">
                <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post" class="mx-auto mt-5">

                    <div class="success_error_message bg-success text-light font-bold p-2 mb-2"  style="display:  <?php echo $success_message_status?>" >
                        <p class="mb-0 py-1">Login successfull </p>
                    </div>
                    
                    <h5 class="text-center text-primary">LOGIN FORM</h5>
                    <div class="mb-3">
                        <label for="email" class="form-label">Enter Email Id: </label>
                        <input type="text" class="form-control" name="login_email" id="email" placeholder="ex:- s@gmail.com" value="souravkumarbgp1010@gmail.com" />
                    </div>
                    <div class="mb-3">
                        <label for="create_pass" class="form-label">Enter Password: </label>
                        <input type="text" class="form-control" name="login_pass" id="create_pass"  autocomplete="off" autofocus value="souravkumarbg" />
                    </div>
                    <input type="submit" class="form-control btn btn-primary rounded-0" name="login_submit_btn" value="LOGIN NOW" />
                    <a class="text-primary mt-3 d-block" id="forget_pass_btn" style="padding: 5px 0; cursor: pointer;" href="./forget_password.php">Forget Password</a>
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