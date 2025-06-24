<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Sử dụng prepared statement để tránh SQL injection
    $stmt = $conn->prepare("SELECT * FROM sanpham WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sp = $result->fetch_assoc();
    } else {
        echo "<div style='padding:20px; color:red;'>❌ Sản phẩm không tồn tại.</div>";
        exit;
    }
} else {
    echo "<div style='padding:20px; color:red;'>⚠️ Không có sản phẩm nào được chọn.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chi tiết sản phẩm - <?php echo htmlspecialchars($sp['ten']); ?></title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5 mb-5">
  <div class="row">
    <div class="col-md-5">
      <img src="img/<?php echo htmlspecialchars($sp['hinh']); ?>" class="img-fluid border rounded shadow-sm" alt="<?php echo htmlspecialchars($sp['ten']); ?>">
    </div>
    <div class="col-md-7">
      <h2 class="text-primary font-weight-bold"><?php echo htmlspecialchars($sp['ten']); ?></h2>
      <p><strong>💰 Giá:</strong> <span class="text-danger"><?php echo number_format($sp['gia']); ?> VNĐ</span></p>
      <p><strong>📂 Loại:</strong> <?php echo htmlspecialchars($sp['loai']); ?></p>
      <p><strong>📝 Mô tả:</strong> <?php echo nl2br(htmlspecialchars($sp['mota'])); ?></p>
      <div class="mt-4">
        <a href="cart.php?add=<?php echo $sp['id']; ?>" class="btn btn-hong">🛒 Thêm vào giỏ hàng</a>
        <a href="products.php" class="btn btn-secondary">⬅️ Quay lại danh sách</a>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
