<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten = $_POST['ten'];
    $gia = $_POST['gia'];
    $hinh = $_POST['hinh'];
    $loai = $_POST['loai'];
    $mota = $_POST['mota'];

    if ($ten && $gia && $hinh) {
        $stmt = $conn->prepare("INSERT INTO sanpham (ten, gia, hinh, loai, mota) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sisss", $ten, $gia, $hinh, $loai, $mota);
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
