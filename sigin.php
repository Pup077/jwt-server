<?php
include_once './header.php';
include_once 'db.php';
require "./vendor/autoload.php";
date_default_timezone_set('Asia/Bangkok');
//dont forget to add header configurations for CORS
use \Firebase\JWT\JWT;
$email_address  = '';
$password       = '';

$dbService  = new DB_Connection();
$connection = $dbService->db_connect();

$api_data   = json_decode(file_get_contents("php://input"));

$email      = $api_data->email;
$password   = $api_data->password;

$table      = 'login';

$sql        = "SELECT user_id,first_name, last_name,password FROM " . $table . " WHERE email_address =:email  LIMIT 0,1"; //กำหนดค่าตัวแปลจากตรางฐานข้อมูล
//echo $sql;
$stmt = $connection->prepare($sql); //เตรียมค่าฐานข้อมูล
$stmt->bindParam(':email', $email); //เช็คค่าตัวแปล
$stmt->execute(); //นำค่าข้อมูลออกมา
$numOfRows = $stmt->rowCount(); //นับจำนวนฐานข้อมูล
 
if($numOfRows> 0){ //เช็ตข้อมูลในฐานข้อมูล แล้วfetch ข้อมูลออกมา
    $row        = $stmt->fetch(PDO::FETCH_ASSOC);
    $id         = $row['user_id'];
    $first_name = $row['first_name'];
    $last_name  = $row['last_name'];
    $pass       = $row['password'];

    if(password_verify($password, $pass)) //เทียบ password ที่เข้ารหัส
    {
        $secret_key         = "1234";
        $issuer_claim       = "localhost"; 
        $audience_claim     = "THE_AUDIENCE";
        $issuedat_claim     = time(); // time ปัจจุบัน
       // $notbefore_claim    = $issuedat_claim + 10; 
        $expire_claim       = $issuedat_claim + 3600;   //เวลาการอยู่ของตัวรหัส token

        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "exp" => $expire_claim,
            "data" => array(
                "id" => $id,
                "userEmail" => $email
        ));

        $jwtValue = JWT::encode($token, $secret_key); //เข้ารหัสของ tokerและ secret_key 
        echo json_encode( //แสดงค่า
            array(
                "message" => "success",
                "id" =>  $id,
                "token" => $jwtValue,
                "email_address" => $email,
                "expiry" => $expire_claim
            ),JSON_UNESCAPED_UNICODE); //แก้ปัญหาฟอร์ตเพี้ยน
    }
    
}
/*
    – iss (issuer)      : ระบุ Client
    – sub (subject)     : subject ของ token
    – aud (audience)    : ผู้รับ token
    – exp (expiration time) : เวลาหมดอายุของ token
    – nbf (not before)  : เป็นเวลาที่บอกว่า token จะเริ่มใช้งานได้เมื่อไหร่
    – iat (Issued-at time)   : ใช้เก็บเวลาที่ token นี้เกิดปัญหา
    – jti (JWT id)      : เอาไว้เก็บไอดีของ JWT แต่ละตัวนะครับ
    
    password encode : https://php-password-hash-online-tool.herokuapp.com/password_hash
*/
?>
