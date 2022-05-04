<?php
//------------- check JWT ---------------
require "vendor/autoload.php";
use \Firebase\JWT\JWT;
date_default_timezone_set('Asia/Bangkok'); //ตั้งเวลา

//---------------------------------------
/**
 * Get header Authorization
 * */
function getAuthorizationHeader() //
{
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        //print_r($requestHeaders);
        if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
    return $headers;
}
/**
 * get access token from header
 * */
function getBearerToken() 
{
    $headers = getAuthorizationHeader();
// HEADER: Get the access token from the header
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

$secret_key = "1234"; 
$jwt = null;
$jwt = getBearerToken();

if ($jwt) {
    try {

        $decoded = JWT::decode($jwt, $secret_key, array('HS256')); //กริทึมการเข้ารหัส 

    } catch (Exception $e) {

        http_response_code(401); //ส่งค่าไปบอกในฝั่ง catch เมื่อข้อมูลไม่ตรงกันบอกerror ไม่รับอนุญาติให้เข้าถึง

        echo json_encode(array("message" => "Access denied.", "error" => $e->getMessage()));
        exit();
    }

}
