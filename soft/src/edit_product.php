<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM sanpham WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Sản phẩm không tồn tại!";
    exit;
}

$sp = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE sanpham SET name=?, price=?, image=?, category=?, description=? WHERE id=?");
    $stmt->bind_param("sisssi", $name, $price, $image, $category, $description, $id);
    $stmt->execute();
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Sửa sản phẩm</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">
  <h3 class="mb-4">Sửa sản phẩm</h3>
  <form method="post" class="p-4 bg-light rounded shadow-sm">
    <div class="form-group">
      <label>Tên sản phẩm:</label>
      <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($sp['name']); ?>" required>
    </div>
    <div class="form-group">
      <label>Giá (VNĐ):</label>
      <input type="number" name="price" class="form-control" value="<?php echo $sp['price']; ?>" required>
    </div>
    <div class="form-group">
      <label>Tên file hình (vd: sanpham1.jpg):</label>
      <input type="text" name="image" class="form-control" value="<?php echo htmlspecialchars($sp['image']); ?>" required>
    </div>
    <div class="form-group">
      <label>Loại sản phẩm:</label>
      <input type="text" name="category" class="form-control" value="<?php echo htmlspecialchars($sp['category']); ?>">
    </div>
    <div class="form-group">
      <label>Mô tả:</label>
      <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($sp['description']); ?></textarea>
    </div>
    <button type="submit" class="btn btn-success">Lưu thay đổi</button>
    <a href="admin.php" class="btn btn-secondary">Quay lại</a>
  </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
