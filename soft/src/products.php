<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/config.php';

$result = $conn->query("SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Danh sách sản phẩm - Quà lưu niệm</title>
  <meta name="viewport" connamet="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="banner mb-4">
  <img src="img/banner1.jpg" class="img-fluid w-100 rounded shadow" alt="Banner quà lưu niệm">
</div>

<div class="container mt-5 mb-5">
  <h2 class="text-center mb-4">Danh sách sản phẩm</h2>

  <form method="get" action="#" class="row mb-4">
    <div class="col-md-6 mb-2">
      <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm...">
    </div>
    <div class="col-md-3 mb-2">
      <select class="form-select" name="category">
        <option selected>Tất cả loại</option>
        <option>Đồ lưu niệm</option>
        <option>Văn phòng phẩm</option>
        <option>Trang trí</option>
      </select>
    </div>
    <div class="col-md-3 mb-2">
      <button type="submit" class="btn btn-hong w-100">Lọc</button>
    </div>
  </form>

  <div class="row">
    <?php while ($sp = $result->fetch_assoc()) { ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <img src="img/<?php echo htmlspecialchars($sp['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($sp['name']); ?>">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?php echo htmlspecialchars($sp['name']); ?></h5>
            <p class="card-text text-danger fw-bold"><?php echo number_format($sp['price']); ?>đ</p>
            <a href="product-detail.php?id=<?php echo $sp['id']; ?>" class="btn btn-hong mt-auto">Xem chi tiết</a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
