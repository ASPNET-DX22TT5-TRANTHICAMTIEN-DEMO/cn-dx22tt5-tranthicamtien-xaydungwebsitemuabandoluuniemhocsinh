<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    if ($name && $price && $image) {
        $stmt = $conn->prepare("INSERT INTO sanpham (name, price, image, category, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sisss", $name, $price, $image, $category, $description);
        $stmt->execute();
        header("Location: admin.php");
        exit;
    } else {
        $error = "⚠️ Vui lòng nhập đầy đủ thông tin bắt buộc!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thêm sản phẩm</title>
  <link rel="styleshe
