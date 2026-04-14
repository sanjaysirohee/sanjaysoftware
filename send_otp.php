<?php
session_start();

$vercode = $_GET['vercode'] ?? '';

if(empty($vercode) || !isset($_SESSION["vercode"]) || $_SESSION["vercode"] != $vercode){
    echo "INVALID_CAPTCHA";
    exit;
}

$phone = $_GET['phone'] ?? '';

if(empty($phone)){
    echo "PHONE_MISSING";
    exit;
}
$countrycode=$_GET['countryCode'];

$otp = rand(1000,9999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_time'] = time();
$otp_message = "Here is your OTP: $otp";

$whatsappMessage = "&type=text&message=" . urlencode($otp_message);

$url = "https://chatbot.veloxn.com/api/send?number=".$countrycode . $phone . $whatsappMessage . "&instance_id=698C821A79867&access_token=69174aa47b39f";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ch);
curl_close($ch);

if($response){
    echo "OTP_SENT";
} else {
    echo "ERROR";
}

exit;
