<?php

/**
 *  @title : HomepageC.php
 *  
 *  @author : Matthis HOULES
 *  @author : Guillaume RISCH
 *  
 *  
 */


 // include PHPMailer
require_once(__DIR__.'/./PHPMailer/src/PHPMailer.php');
require_once(__DIR__.'/./PHPMailer/src/SMTP.php');
require_once(__DIR__.'/./PHPMailer/src/Exception.php');


class Mail {

    protected $mail;


    /**
     *  @name : __construct
     *
     *  @param : void
     * 
     *  @return : void
     * 
     *  @brief : Mail constructor, (configure PHPMailer)
     */
    function __construct() {

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        $mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'etuamouv@gmail.com';                     // SMTP username
        $mail->Password   = '';                               // SMTP password
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $mail->setFrom('etuamouv@gmail.com', 'AMOUV Covoiturage');


        $this->mail = $mail;
    } // function __construct()



    /**
     *  @name : sendMail
     *  
     *  @param : $sendInformation : array : mail and name destination
     *  @param $subject : string : subject mail
     *  @param : $message : string : message mail
     * 
     *  @return : boolean : true if mail send, false instead
     * 
     *  @brief : 
     * 
     *  
     */
    public function sendMail($sendInformation = [], $subject, $message) {
        $mailtoSend = $this->mail;

        $mailtoSend->addAddress('matthis.houles@gmail.com', 'Matthis HOULES');     // Add a recipient
        $mailtoSend->isHTML(true);                                  // Set email format to HTML
        $mailtoSend->Subject = 'Here is the subject';
        $mailtoSend->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mailtoSend->AltBody = 'This is the body in plain text for non-HTML mail clients';

        try {
            $mailtoSend->send();
        }
        catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

}




?>