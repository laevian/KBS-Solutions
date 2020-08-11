<?php
if(!isset($_POST['submit']))
{
  echo "Error- form not submitted.";
}

$name = $_POST['fname']." ".$_POST['lname'];
$email = $_POST['email'];
$company = $_POST['company'];
$phone = $_POST['phone'];
$message = $_POST['message'];

if(empty($name)||empty($email)||empty($message))
{
  echo "Name, email, and message are required fields."
  exit;
}

if(IsInjected($visitor_email))
{
    echo "Bad email value!";
    exit;
}

$email_from = 'info@kbsdelivers.com';
$email_subject = "New Contact Form Submission";
$email_body = "You have received a new message from the user $name.\n".
              "Email address: $email\n".
              "Company: $company\n".
              "Phone number: $phone \n".
              "Message body:\n $message".

$to = 'info@kbsdelivers.com';
$headers = "From: $email_from \r\n";

mail($to,$email_subject,$email_body,$headers);

header('Location: ../index.html');

function IsInjected($str)
{
    $injections = array('(\n+)',
           '(\r+)',
           '(\t+)',
           '(%0A+)',
           '(%0D+)',
           '(%08+)',
           '(%09+)'
           );

    $inject = join('|', $injections);
    $inject = "/$inject/i";

    if(preg_match($inject,$str))
    {
      return true;
    }
    else
    {
      return false;
    }
}

?>
