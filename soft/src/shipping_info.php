<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$sql = "
SELECT o.id AS orders_id, o.total_amount, o.order_date, o.status,
       u.username,
       s.receiver_name, s.address, s.phone, s.delivery_date
FROM orders o
JOIN users u ON o.user_id = u.id
LEFT JOIN shipping_info s ON o.id = s.order_id
ORDER BY o.id DESC
";

$result = $conn->query($sql);
if (!$result) {
    die("Lỗi truy vấn: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý đơn hàng</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="container mt-5">
  <h3>Danh sách đơn hàng</h3>
  <table class="table table-bordered table-hover">
    <thead class="thead-dark">
      <tr>
        <th>Mã ĐH</th>
        <th>Người đặt</th>
        <th>Ngày đặt</th>
        <th>Tổng tiền</th>
        <th>Trạng thái</th>
        <th>Người nhận</th>
        <th>Địa chỉ</th>
        <th>Điện thoại</th>
        <th>Ngày giao</th>
      </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td>#<?php echo $row['orders_id']; ?></td>
        <td><?php echo htmlspecialchars($row['username']); ?></td>
        <td><?php echo $row['order_date']; ?></td>
        <td><?php echo number_format($row['total_amount'], 0); ?>đ</td>
        <td><?php echo htmlspecialchars($row['status']); ?></td>
        <td><?php echo htmlspecialchars($row['receiver_name']); ?></td>
        <td><?php echo htmlspecialchars($row['address']); ?></td>
        <td><?php echo htmlspecialchars($row['phone']); ?></td>
        <td><?php echo htmlspecialchars($row['delivery_date']); ?></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
