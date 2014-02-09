<?php

require_once('..\PHPMailer_5.2.4\class.phpmailer.php');

$mail = new PHPMailer(true);

//Send mail using gmail
//if($send_using_gmail){
    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->SMTPAuth = true; // enable SMTP authentication
    $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
    $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
    $mail->Port = 465; // set the SMTP port for the GMAIL server
    $mail->Username = "nirbhaya.app@gmail.com"; // GMAIL username
    $mail->Password = "nirbhaya123"; // GMAIL password
//}

$email = "anunayasri@gmail.com";
$name = "NirbhayaApp";
$email_from = "fake_email@gmail.com";
$name_from = "Nirbhaya_app";
$attach_path = "C:\\xampp\htdocs\bachao\img1.jpg";

echo "attach_path : ".$attach_path."debug(";

//Typical mail data
$mail->AddAddress($email, $name);
$mail->SetFrom($email_from, $name_from);
$mail->Subject = "My Subject";
$mail->Body = "Mail contents";

$mail->AddAttachment($attach_path);

try{
    $mail->Send();
    echo "Success!";
} catch(Exception $e){
    //Something went bad
    echo "Fail :(";
}
?>