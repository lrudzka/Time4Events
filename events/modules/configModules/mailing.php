<?php

    require_once '../configModules/PHPMailer.php';
    require_once '../configModules/SMTP.php';
    
            
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    

    
     
    function sendEmail($recipient, $content, $subject)
{
    //wysyłka maila
    $mail = new PHPMailer(true);  
    
    
    // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = '************';                          // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = '************';                 // SMTP username
        $mail->Password = '************';                           // SMTP password
        $mail->SMTPSecure = '***********';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to
        $mail->CharSet = 'utf8';

        //Recipients
        $mail->setFrom('noreply@mycoding.eu', 'EVENTownia');
        //  $mail->addAddress($recipient, $recipient);     // Add a recipient
        
        for ($i=0; $i<count($recipient); $i++)
        {
            $mail->addAddress($recipient[$i]);
        }    
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
                
    } catch (Exception $e) {
        $_SESSION['mailingError'] = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
    } 
}       
            
    
            
  
    