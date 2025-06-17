<?php
$host = 'localhost';
$user = 'root';
$password = ''; // thường để trống nếu dùng XAMPP
$dbname = 'muabandoluuniemhocsinh.dp';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
