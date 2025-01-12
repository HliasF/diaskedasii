<?php

require 'config/function.php';

require_once 'vendor/autoload.php';

$setUsername = "admin@gmail.com";
$setPassword = "12345678";

$host = "smtp.gmail.com";
$port = "587";
$sslOrTls = "tls";
//ssl-465

$emailAddress = "admin@gmail.com";
$sendEmailAddress = "admin@gmail.com";
$subject = "You got new enquiry";


if(isset($_POST['contactSubmit']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $service = $_POST['service'];
    $message = $_POST['message'];

    $bodyContent = '<div>
        <h4>Name : '.$name.'</h4>
        <h4>Email : '.$email.'</h4>
        <h4>Phone Number: '.$phone.'</h4>
        <h4>Service : '.$service.'</h4>
        <h4>Comment/Message: '.$message.'</h4>
    </div>';

    try{

        // Create the Transport
        $transport = (new Swift_SmtpTransport($host, $port, $sslOrTls))
            ->setUsername($setUsername)
            ->setPassword($setPassword)
        ;

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        $message = (new Swift_Message($subject))
            ->setFrom([$emailAddress => 'Funda Services'])
            ->setTo([$sendEmailAddress])
            ->setBody($bodyContent, 'text/html')
        ;

        // Send the message
        $result = $mailer->send($message);
        if($result){
            redirect('contact-us.php', 'Thank you for contacting us. we will get back to you asap.');
        }else{
            redirect('contact-us.php', 'Something Went Wrong');
        }

    }catch(\Exception $e){
        redirect('contact-us.php', 'Something Went Wrong:' . $e->getMessage());
    }

}

?>