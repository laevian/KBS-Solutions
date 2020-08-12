<?php
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "Error; you need to submit the form!";
}
$name = $_POST['fname']." ".$_POST['lname'];
$visitor_email = $_POST['email'];
$visitor_company = $_POST['company'];
$visitor_phone = $_POST['phone'];
$message = $_POST['message'];

//Validate first
if(empty($name)||empty($visitor_email)||empty($message))
{
    echo "Name, email, and message are mandatory fields.";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Bad email value.";
    exit;
}

$email_from = 'info@kbsdelivers.com';
$email_subject = "New Form submission";
$email_body = "You have received a new message from the user $name.\n".
"Company:\n $visitor_company".
		"Phone Number:\n $visitor_phone".
		"Here is the message:\n $message".

$to = "info@kbsdelivers.com";
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
header('Location: thank-you.html');


// Function to validate against any email injection attempts
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
