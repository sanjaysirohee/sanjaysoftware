<?php
/*
if(empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  http_response_code(500);
  exit();
}

$name = strip_tags(htmlspecialchars($_POST['name']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$m_subject = strip_tags(htmlspecialchars($_POST['subject']));
$message = strip_tags(htmlspecialchars($_POST['message']));

$to = "hello@sanjaysoftware.in"; // Change this email to your //
$subject = "$m_subject:  $name";
$body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\n\nEmail: $email\n\nSubject: $m_subject\n\n Message: $message";
$header = "From: $email";
$header .= "Reply-To: $email";	
mail("hello@sanjaysoftware.in", $subject, $body, $header); 

if(!mail($to, $subject, $body, $header))
 http_response_code(500);
*/


if(isset($_POST['submit'])){
    $to = "hello@sanjaysoftware.in"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $full_name = $_POST['name'];
    //$query_title = $_POST['subject'];
    $phone_number = $_POST['phone_number'];
    $subject = "A new Contact sanjaysoftware.in";
    $subject2 = "Your Contact Information Sent.";
	
	$location = file_get_contents('http://freegeoip.net/json/'.$_SERVER['REMOTE_ADDR']);
           $json = json_decode($location, true);
		   extract($json);
	$user_location="$country_code.$country_name.,.$region_name.,.$city";
 
			 $ip = $_SERVER['REMOTE_ADDR'];
	$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
    if($query && $query['status'] == 'success')
    {
        $Locationaddress = $query['city'] . ", " . $query['zip']. ", " . $query['country'];
    } else {
   $Locationaddress = "Unable to get location but IP address is - " . $ip;
	}
  
    //$message = $full_name . ", Phone - " . $phone_number . " wrote the following:" . "\n\n" . $_POST['message']. "\n\n The User Location: " . $Locationaddress;
	$message = $full_name . ", Phone - " . $phone_number . " wrote the following:" . "\n\n" . $_POST['message'] . "\n\n The User Location: " . $Locationaddress;
    $message2 = "Here is a copy of your message " . $full_name . "\n\n" . $_POST['message'];

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
    mail($to,$subject,$message,$headers);
    mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
    echo "Mail Sent. Thank you " . $full_name . ", we will contact you shortly.";
    // You can also use header('Location: thank_you.php'); to redirect to another page.
    // You cannot use header and echo together. It's one or the other.
	header('refresh:5; url=index.html/#about');
	echo 'You\'ll be redirected in about 5 secs. If not, click <a href="index.html/#contact">here</a>.';
    }
	
?>
