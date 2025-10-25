<?php
session_start();
if (isset($_POST['vercode'])) {
  if ((empty($_SESSION["vercode"])) || ($_SESSION["vercode"] != $_POST['vercode'])) {
    die("<script>alert('Invalid Verification Code'); history.back();</script>");
  }
}

require 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Base files
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Define some constants
define("RECIPIENT_NAME", "Sanjay Kumar Software Consultant");
define("RECIPIENT_EMAIL", "veloxnservices@gmail.com");


// Read the form values
$success = false;
$userName = isset($_POST['full_name']) ? preg_replace("/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['full_name']) : "";
$senderEmail = isset($_POST['email']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['email']) : "";
$userPhone = isset($_POST['phone_number']) ? preg_replace("/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['phone_number']) : "";
$userSubject = isset($_POST['subjectV']) ? preg_replace("/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['subjectV']) : "";
$userPage = isset($_POST['userPage']) ? preg_replace("/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['userPage']) : "";
$message = isset($_POST['message']) ? preg_replace("/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['message']) : "";
$subjectV = $_POST['subjectV'];

// If all values exist, send the email


$ip_address=$_SERVER['REMOTE_ADDR'];
/*Get user ip address details with geoplugin.net*/
$geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip_address;
$addrDetailsArr = unserialize(file_get_contents($geopluginURL));
/*Get City name by return array*/
$city = $addrDetailsArr['geoplugin_city'];
/*Get Country name by return array*/
$country = $addrDetailsArr['geoplugin_countryName'];
/*Comment out these line to see all the posible details*/
/*echo '<pre>';
print_r($addrDetailsArr);
die();*/
if(!$city){
   $city='Not Define';
}if(!$country){
   $country='Not Define';
}
//$country="SanjayTC";
$userLocation = $city .', '. $country;
//$userPage = $_SERVER['REQUEST_URI'];
  if ($country=='India') {
if ($userName && $senderEmail && $userPhone && $message) {

    // PHPMailer classes into the global namespace

    // create object of PHPMailer class with boolean parameter which sets/unsets exception.
	$sql = "INSERT INTO req_query_table(full_name,phone_number,email,message,Location,subject,vpage_url)VALUES ('$userName','$userPhone','$senderEmail','$message','$userLocation','$userSubject','$userPage')";
	
	if ($conn->query($sql) === TRUE) {
   if ($subjectV == 'HomePage') {
    $Message = "&type=text&message=Thanks+for+contacting+Sanjay+Software+Consultant.+Regarding+your+queries.+We+will+get+back+to+you+soon,+you+can+post+more+queries+here....";
  }else {
    $Message = "&type=text&message=Thanks+for+contacting+Sanjay+Software+Consultant.+We+will+get+back+to+you+soon,+you+can+post+more+queries+here....";
  }

	
  $url = 'https://chatbot.veloxn.com/api/send?number=91' . $userPhone . $Message . '&instance_id=67DFEDB423C34&access_token=67dfed7721270';
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $result = curl_exec($ch);
  curl_close($ch);
  if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
  }
}
  
    $mail = new PHPMailer(true);

    // Template start

    $AdminMessage = '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
</head>

<body>
    <table
        style="
        width: 600px;
        margin: auto;
        border: solid 1px #f0f0f0;
        border-spacing: 0;
      ">
        <tr>
            <td colspan="2">
                <div style="width: 25%; margin: 0px auto">
                    <img src="img/thank_u.png" alt=""
                        style="width: 150px; padding: 0px 15px" />
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <p style="font-family: sans-serif; padding: 0px 15px">
                    Hello <b>Admin</b>,
                </p>
                <p
                    style="
              font-family: sans-serif;
              line-height: 26px;
              padding: 0px 15px;
            ">
                    Greetings! Wanted to inform you about a new enquiry. Please
                    note the client requirements below for your convenience:
                </p>
                <p
                    style="
              font-family: sans-serif;
              line-height: 26px;
              padding: 0px 15px;
            ">
                    Should assistance be needed, please do not hesitate to reach out.
                </p>
                <ul>
                    <li
                        style="
                font-family: sans-serif;
                line-height: 26px;
                padding: 0px 15px;
              ">
                        Full name :
                        <span>
                            ' . $userName . '
                        </span>
                    </li>
                    <li
                        style="
                font-family: sans-serif;
                line-height: 26px;
                padding: 0px 15px;
              ">
                        Email address:
                        <span>
                            ' . $senderEmail . '
                        </span>
                    </li>
                    <li
                        style="
                font-family: sans-serif;
                line-height: 26px;
                padding: 0px 15px;
              ">
                        Phone number:
                        <span>
                            ' . $userPhone . '
                        </span>
                    </li>
            <li
              style="
                font-family: sans-serif;
                line-height: 26px;
                padding: 0px 15px;
              "
            >
              Message:
              <span>
                ' . $message . '
              </span>
            </li>
                </ul>
                <p
                    style="
              font-family: sans-serif;
              line-height: 26px;
              padding: 0px 15px;
            ">
                    We would greatly appreciate it if you could follow up on this lead
                    promptly and professionally.
                </p>
            </td>
        </tr>
      
    </table>
</body>

</html>';

    $userMessage = '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
</head>

<body>
    <table
        style="
        width: 600px;
        margin: auto;
        border: solid 1px #f0f0f0;
        border-spacing: 0;
      ">
        <tr>
            <td colspan="2">
                <div style="width: 25%; margin: 0px auto;">
                    <img src="img/thank_u.png" alt=""
                        style="width:150px;  padding: 0px 15px;" />
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <img src="img/thank_u.png' . '" alt=""
                    style="width: 600px; padding: 0px 15px" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <p style="font-family: sans-serif; padding: 0px 15px">
                    Dear
                    <b>
                        ' . $userName . '
                    </b>,
                </p>
                <p
                    style="
              font-family: sans-serif;
              line-height: 26px;
              padding: 0px 15px;
            ">
                    Thank you for reaching out to us.
                </p>
                <p
                    style="
              font-family: sans-serif;
              line-height: 26px;
              padding: 0px 15px;
            ">
                    Our dedicated team of experts will review your request and get back
                    to you within few minutes.
                </p>
                <p
                    style="
              font-family: sans-serif;
              line-height: 26px;
              padding: 0px 15px;
            ">
                    Till then, explore our other services.
                </p>

                <p
                    style="
              font-family: sans-serif;
              line-height: 26px;
              padding: 0px 15px;
            ">
                    <b>With Sanjay Kumar Software Consultant</b>
                </p>
            </td>
        </tr>
      
    </table>
</body>

</html>';

    // Template end 


    try {
        $mail->SMTPDebug = 0;  //SMTP debug
        $mail->isSMTP(); // using SMTP protocol
        $mail->Host = '103.133.214.192'; // SMTP host as gmail
        $mail->SMTPAuth = true;  // enable smtp authentication
        $mail->Username = 'email@sanjaysoftware.in';  // sender gmail host
        $mail->Password = 'sa.pp@PWD'; // sender gmail host password
        $mail->SMTPSecure = 'tls';  // for encrypted connection
        $mail->isHTML(true);
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => false
            )
        );
        $mail->Port = 587;   // port for SMTP

        $mail->setFrom('email@sanjaysoftware.in', "Sanjay Kumar Software Consultant"); // sender's email and name
        //$mail->addAddress('veloxnsales@gmail.com');
        // receiver's email and name

        if ('Admin' == 'Admin') {
            $mail->addAddress('email@sanjaysoftware.in', "Admin");
			//$mail->addBcc('koshaorganic1@gmail.com', "Admin");
            $mail->Subject = 'Admin';
            $mail->Body = $AdminMessage;
            $mail->send();
        }

        if ('User' == 'User') {
            $mail->addAddress($senderEmail, $userName);
            $mail->Subject = 'Welcome '.$userName;
            $mail->Body = $userMessage;
            $mail->send();
        }


        // echo 'Message has been sent';
    } catch (Exception $e) { // handle error.
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }

    // $recipient = RECIPIENT_NAME . " <" . RECIPIENT_EMAIL . ">";

    // $headers = "From: " . $userName . "";
    // $msgBody = " Name: " . $userName . " Email: " . $senderEmail . " Phone: " . $userPhone . " Subject: " . $userSubject . " Message: " . $message . "";
    // $success = mail($recipient, $headers, $msgBody);

    //Set Location After Successsfull Submission
    header('Location: https://sanjaysoftware.in/thank-you.html');
} else {
    //Set Location After Unsuccesssfull Submission
    header('Location: https://sanjaysoftware.in/not-sent.html');
}
  }else {
    //Set Location After Unsuccesssfull Submission
	$sql = "INSERT INTO req_query_outofindia_outofindia(full_name,phone_number,email,message,Location,subject,vpage_url)VALUES ('$userName','$userPhone','$senderEmail','$message','$userLocation','$userSubject','$userPage')";
    header('Location: https://sanjaysoftware.in/thank-you.html');
}

?>