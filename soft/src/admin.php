<?php
session_start();
include 'config.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Tạo CSRF token nếu chưa có
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Xử lý xóa sản phẩm bằng POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("❌ CSRF token không hợp lệ!");
    }

    $id = intval($_POST['delete']);
    $stmt = $conn->prepare("DELETE FROM sanpham WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $_SESSION['success'] = "🗑️ Đã xóa sản phẩm thành công!";
    header("Location: admin.php");
    exit;
}

// Phân trang
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Đếm tổng số sản phẩm để tính số trang
$total = $conn->query("SELECT COUNT(*) AS total FROM sanpham")->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);

// Lấy danh sách sản phẩm theo trang
$stmt = $conn->prepare("SELECT * FROM sanpham ORDER BY id DESC LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý sản phẩm</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container mt-5">
  <h3 class="mb-4">📦 Quản lý sản phẩm</h3>
  <a href="them-sanpham.php" class="btn btn-success mb-3">➕ Thêm sản phẩm</a>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
  <?php endif; ?>

  <table class="table table-bordered table-hover table-striped">
    <thead class="thead-dark">
      <tr>
        <th>ID</th>
        <th>Tên</th>
        <th>Giá</th>
        <th>Hình</th>
        <th>Loại</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($sp = $result->fetch_assoc()) { ?>
        <tr>
          <td><?php echo $sp['id']; ?></td>
          <td><?php echo htmlspecialchars($sp['ten']); ?></td>
          <td><?php echo number_format($sp['gia']); ?>đ</td>
          <td>
            <img src="img/<?php echo htmlspecialchars($sp['hinh']); ?>" width="60" class="rounded shadow-sm">
          </td>
          <td><?php echo htmlspecialchars($sp['loai']); ?></td>
          <td>
            <a href="sua-sanpham.php?id=<?php echo $sp['id']; ?>" class="btn btn-sm btn-warning">✏️ Sửa</a>
            <form method="POST" action="admin.php" style="display:inline;">
              <input type="hidden" name="delete" value="<?php echo $sp['id']; ?>">
              <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
              <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?');">🗑️ Xóa</button>
            </form>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <!-- Phân trang -->
  <nav>
    <ul class="pagination">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
          <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
