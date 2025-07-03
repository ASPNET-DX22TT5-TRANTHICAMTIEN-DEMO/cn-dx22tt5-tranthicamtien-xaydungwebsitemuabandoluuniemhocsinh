<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (empty($_SESSION['cart'])) {
    echo "<div class='container mt-5'><h4>Giỏ hàng đang trống. <a href='products.php'>Quay lại mua sắm</a></h4></div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $receiver_name = trim($_POST['receiver_name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $delivery_date = date('Y-m-d');

    $tongtien = 0;
    $items = [];

    $ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));

    if (empty($ids)) {
        echo "Không có sản phẩm nào để thanh toán.";
        exit;
    }

    $result = $conn->query("SELECT * FROM sanpham WHERE id IN ($ids)");
    if (!$result || $result->num_rows === 0) {
        echo "Không lấy được sản phẩm từ giỏ hàng.";
        exit;
    }

    while ($sp = $result->fetch_assoc()) {
        $id = $sp['id'];
        $soluong = $_SESSION['cart'][$id];
        $giatien = $sp['gia'];
        $thanhtien = $giatien * $soluong;
        $tongtien += $thanhtien;

        $items[] = [
            'sanpham_id' => $id,
            'soluong' => $soluong,
            'giatien' => $giatien
        ];
    }

    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total, order_date, status) VALUES (?, ?, NOW(), 'Đang xử lý')");
    $stmt->bind_param("id", $user_id, $tongtien);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    $ship = $conn->prepare("INSERT INTO shipping_info (order_id, receiver_name, address, phone, delivery_date) VALUES (?, ?, ?, ?, ?)");
    $ship->bind_param("issss", $order_id, $receiver_name, $address, $phone, $delivery_date);
    $ship->execute();

    $ct = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($items as $item) {
        $ct->bind_param("iiid", $order_id, $item['sanpham_id'], $item['soluong'], $item['giatien']);
        $ct->execute();
    }

    unset($_SESSION['cart']);
    header("Location: checkout-success.php?order_id=" . $order_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thông tin giao hàng</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container mt-5">
  <h3>Thông tin giao hàng</h3>
  <form method="POST">
    <div class="form-group">
      <label>Họ tên người nhận</label>
      <input type="text" name="receiver_name" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Địa chỉ giao hàng</label>
      <textarea name="address" class="form-control" rows="3" required></textarea>
    </div>
    <div class="form-group">
      <label>Số điện thoại</label>
      <input type="text" name="phone" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Xác nhận đặt hàng</button>
    <a href="cart.php" class="btn btn-secondary ml-2">Quay lại giỏ hàng</a>
  </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
