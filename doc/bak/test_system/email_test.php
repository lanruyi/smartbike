<?php

require 'class.phpmailer.php';

$mail = new PHPMailer;

$mail->IsSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.ym.163.com';  // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'feng.wang@airborne-es.com';                            // SMTP username
$mail->Password = '123123q';                           // SMTP password
//$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'feng.wang@airborne-es.com';
$mail->FromName = '研发部-王峰';
//$mail->AddAddress('josh@example.net', 'Josh Adams');  // Add a recipient
$mail->AddAddress('andrace@qq.com');               // Name is optional
//$mail->AddReplyTo('info@example.com', 'Information');
$mail->AddCC('cc@example.com');
$mail->AddBCC('bcc@example.com');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->AddAttachment('');         // Add attachments
$mail->AddAttachment('');    // Optional name
$mail->IsHTML(true);                                  // Set email format to HTML

$mail->Subject = '测试邮件';
$mail->Body = '这是一个测试';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if (!$mail->Send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
    exit;
}

echo 'Message has been sent';
