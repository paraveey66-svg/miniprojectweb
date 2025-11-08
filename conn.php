<?php
$host = "localhost";
$port = "5432";
$dbname = "cafe_phrae"; // ตรวจสอบชื่อ DB
$user = "postgres"; 
$password = "postgres"; // รหัสผ่านของคุณ

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
$conn = pg_connect($conn_string);
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
// เพิ่มโค้ดสำหรับ Login/Session ที่นี่เมื่อทำระบบ Login
// เช่น if (!isset($_SESSION['user_id']) && basename($_SERVER['PHP_SELF']) !== 'login.php') { header('Location: login.php'); exit(); }
?>