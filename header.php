<?php
header("Access-Control-Max-Age: 3600"); //การคงสถาพของ แคส
header("Access-Control-Allow-Methods: POST, PUT, DELETE, UPDATE"); //คำสั่ง  Methods ที่เรียกใช่
header("Access-Control-Allow-Origin: * "); //การสามารถ Access ฐานข้อมูลจากโดเมนไหนก็ได้
header("Content-Type: application/json; charset=UTF-8"); //รูปแบบผลลัพธ์การแสดง
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); //ความสามารถในการเข้าถึงฐานข้อมูลใน Headers