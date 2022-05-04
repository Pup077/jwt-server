<?php
include_once './header.php'; //รับค่าจาก header
include_once 'db.php';
include_once './protected.php'; //ต่างจากไฟล์ sigin.php , ถูกเขียนขึ้นเพื่อความปลอดภัย
require "./vendor/autoload.php";
//dont forget to add header configurations for CORS
use \Firebase\JWT\JWT;

$dbService  = new DB_Connection(); //สร้างคลาสใหม่
$connection = $dbService->db_connect(); //เชื่อมต่อฐานข้อมูล
$id         = $decoded->data->id;  //เช็คการเข้ารหัส
$sql        = "SELECT * FROM customers";  //เอาข้อมูลจาก ฐานข้อมุลทั้งหมด
$stmt = $connection->prepare($sql);
$stmt->execute();
$numOfRows = $stmt->rowCount();


$ans = array();
if ($numOfRows > 0) {  
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){ //นำค่ามาแสดง
        array_push($ans,$res);
    }
    echo json_encode($ans);
} else {  
    echo json_encode(array("success" => "false"));
}