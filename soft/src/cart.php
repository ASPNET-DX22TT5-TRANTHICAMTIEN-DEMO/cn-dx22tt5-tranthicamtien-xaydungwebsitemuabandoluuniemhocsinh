<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/config.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['add'])) {
    $id = intval($_GET['add']);
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    header("Location: cart.php");
    exit;
}

if (isset($_GET['decrease'])) {
    $id = intval($_GET['decrease']);
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]--;
        if ($_SESSION['cart'][$id] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    }
    header("Location: cart.php");
    exit;
}

if (isset($_GET['remove'])) {
    $id = intval($_GET['remove']);
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Giỏ hàng</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5 cart-box">
  <h3>🛒 Giỏ hàng của bạn</h3>

  <?php if (empty($_SESSION['cart'])): ?>
    <p>Giỏ hàng đang trống. <a href="products.php">Tiếp tục mua sắm →</a></p>
  <?php else: ?>
    <?php
    $ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
    $result = $conn->query("SELECT * FROM products WHERE id IN ($ids)");
    $tong = 0;
    ?>
    <table class="table table-bordered">
      <thead class="thead-light">
        <tr>
          <th>Sản phẩm</th>
          <th>Hình</th>
          <th>Giá</th>
          <th>Số lượng</th>
          <th>Thành tiền</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($sp = $result->fetch_assoc()):
          $id = $sp['id'];
          $sl = $_SESSION['cart'][$id];
          $tt = $sl * $sp['price'];
          $tong += $tt;
        ?>
        <tr>
          <td><?php echo htmlspecialchars($sp['name']); ?></td>
          <td><img src="img/<?php echo htmlspecialchars($sp['image']); ?>" width="60" alt=""></td>
          <td><?php echo number_format($sp['price']); ?>đ</td>
          <td>
            <div class="quantity-control">
              <a href="cart.php?decrease=<?php echo $id; ?>" class="btn btn-sm btn-outline-secondary">−</a>
              <span><?php echo $sl; ?></span>
              <a href="cart.php?add=<?php echo $id; ?>" class="btn btn-sm btn-outline-primary">+</a>
            </div>
          </td>
          <td><?php echo number_format($tt); ?>đ</td>
          <td>
            <a href="cart.php?remove=<?php echo $id; ?>" 
               class="btn btn-sm btn-danger"
               onclick="return confirm('Xóa sản phẩm này khỏi giỏ hàng?');">Xóa</a>
          </td>
        </tr>
        <?php endwhile; ?>
        <tr>
          <td colspan="4" class="text-right"><strong>Tổng cộng:</strong></td>
          <td colspan="2"><strong class="text-danger"><?php echo number_format($tong); ?>đ</strong></td>
        </tr>
      </tbody>
    </table>

    <div class="text-right">
      <a href="products.php" class="btn btn-secondary">← Tiếp tục mua hàng</a>
      <a href="checkout.php" class="btn btn-success">Thanh toán</a>
    </div>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
