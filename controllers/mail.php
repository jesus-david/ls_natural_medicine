<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
// require_once '../views/vendor/phpmailer/phpmailer/src/';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../../views/vendor/autoload.php';

class Email
{

    public static function sendMail($destino, $nombre, $asunto, $template)
    {

        //
        $mail = new PHPMailer(true);
        $mail->SMTPOptions = array(
		    'ssl' => array(
		    	'verify_peer' => false,
		    	'verify_peer_name' => false,
		    	'allow_self_signed' => true
		    )
	    ); 

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      
            $mail->isSMTP();                                          
            $mail->CharSet = "UTF-8";
            $mail->Host       = 'smtp.gmail.com';                    
            $mail->Port       = 587;   
            $mail->SMTPSecure =  "tls"; //PHPMailer::ENCRYPTION_STARTTLS;
            $mail->SMTPAuth   = true;      

            $mail->Username   = "mailerapp19@gmail.com";                     // SMTP username
            $mail->Password   = "####";                              // SMTP password
          
            //Recipients
            $mail->setFrom("mailerapp19@gmail.com", "LS NATURAL MEDICINE");
            $mail->addAddress($destino, $nombre);                    // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body    = $template;

            $mail->send();

            return array("status" => true);
        } catch (Exception $e) {

            $error = "tMessage could not be sent. Mailer Error: {$mail->ErrorInfo}";
            
            return $error;
        }

    }

    
    public static function getCode()
    {

        $patron = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

        $codigo = str_shuffle($patron);
        
        return $codigo;
        
    }

}