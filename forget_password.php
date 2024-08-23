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

    if(isset($_POST["rese_submit_btn"])){
        extract($_POST);
        
        $select_querry = "SELECT user_full_name, user_email, user_pass FROM tbl WHERE user_email = '{$user_email}'";
        $result = mysqli_query($conn, $select_querry);
        if(mysqli_num_rows($result) == 1){
            $records = mysqli_fetch_assoc($result);
            
            $verification_code = bin2hex(random_bytes(32));
            
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
                $mail->Subject = 'RESET PASSWORD VARIFICATION';
                $mail->Body    = "<p>For security reasons, please do not share this link with anyone. To reset your password, click the link below:</p> <p><a href='http://localhost/phpProject/testing/reset_password_processing.php?verifcation_code=$verification_code' style='color: rgb(0, 123, 255); text-decoration: none; font-weight: bold;'>Reset Your Password</a></p> <p>After resetting your password, you will be automatically redirected to the login page to access your account.</p> ";
            
                if($mail->send()){

                    $update_querry = "UPDATE tbl SET verify_code = '{$verification_code}'";
                    mysqli_query($conn, $update_querry);
                    echo "<center style='margin-top: 40px; font-family: Arial;'><p><b>RESET PASSWORD LINK SENT TO YOUR EMAIL ID: <strong>{$records['user_email']}</strong></p></b> <p>Please check your email and click on the <strong>RESET YOUR PASSWORD</strong> link.</p>  <p>After resetting your password, you will be automatically redirected to the login page to access your account.</p> ";
                    die;
                    
                }

            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            
        }else{
            echo "Incorrect emale !";
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
                <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post" class=" mx-auto mt-5">
                    <h5 class="text-center text-primary">FORGET PASSWORD FORM</h5>
                    <div class="mb-3">
                        <label for="email" class="form-label">Enter Email Id: </label>
                        <input type="text" class="form-control" name="user_email" id="email" placeholder="ex:- s@gmail.com">
                    </div>
                    
                    <input type="submit" class="form-control btn btn-primary rounded-0" name="rese_submit_btn" value="SUBMIT" />
                    
                </form>
                
            </section><!--*** End of login_form-->

        </main><!--*** End of main-->
        
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
     
    </body>
</html>