<?php
session_start();

if (!isset($_SESSION['last_order_id']) || !isset($_SESSION['total_amount'])) {
    header("Location: cart.php");
    exit;
}

$orderId = $_SESSION['last_order_id'];
$totalAmount = $_SESSION['total_amount'];

unset($_SESSION['cart']);
unset($_SESSION['last_order_id']);
unset($_SESSION['total_amount']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán thành công</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container mt-5 text-center">
    <h2 class="text-success">Đặt hàng thành công!</h2>
    <p>Mã đơn hàng của bạn là: <strong>#<?php echo $orderId; ?></strong></p>
    <p>Tổng tiền thanh toán: <strong><?php echo number_format($totalAmount, 0, ',', '.'); ?>đ</strong></p>
    <a href="index.php" class="btn btn-primary mt-3">Về trang chủ</a>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
