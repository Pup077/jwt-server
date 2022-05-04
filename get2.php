<?php
include_once './header.php';
include_once 'db.php';
include_once './protected.php';
require "./vendor/autoload.php";
//dont forget to add header configurations for CORS
use \Firebase\JWT\JWT;

$dbService  = new DB_Connection();
$connection = $dbService->db_connect();

//$id = $user = $decoded->data->id;  // get value from JWT
$table      = 'customers';
$sql        = "SELECT * FROM " . $table;
//echo $sql;
$stmt = $connection->prepare($sql);
//$stmt->bindParam(':id', $id);
$stmt->execute();
$numOfRows = $stmt->rowCount();

if($numOfRows> 0){
   // $row        = $stmt->fetch(PDO::FETCH_ASSOC);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $id     = $row['id'];
        $name  = $row['name'];
        $phone = $row['phone'];
        $email  = $row['email'];
        $country  = $row['country'];
       // $name = $first_name." ".$last_name;
        $list =array('id'=>$id,'name'=>$name,'email'=>$email,'phone'=>$phone,'country'=>$country);
        echo json_encode(array($list));
    }
   
}else{
    echo json_encode(array("success" => "false"));

}

?>
