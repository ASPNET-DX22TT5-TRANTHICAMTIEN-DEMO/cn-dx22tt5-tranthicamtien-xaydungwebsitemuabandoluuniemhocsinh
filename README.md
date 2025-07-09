# 🎓 Đồ án: Xây dựng website mua bán đồ lưu niệm học sinh

## 👩‍🎓 Thông tin sinh viên
- Họ tên: Trần Thị Cẩm Tiên  
- Mã lớp: DX22TT5  
- Tên repository: `cn-dx22tt5-tranthicamtien-xaydungwebsitemuabandoluuniemhocsinh`  

## 💻 Công nghệ sử dụng
- PHP (thuần, không dùng framework)
- MySQL (CSDL quan hệ)
- HTML5 & CSS3 (giao diện người dùng)
- JavaScript cơ bản (hiệu ứng & tương tác)
- Bootstrap 5 (hỗ trợ responsive layout)

## 🚀 Hướng dẫn cài đặt

1. **Clone repository**:
   ```bash
   git clone https://github.com/ASPNET-DX22TT5-TRANTHICAMTIEN-DEMO/cn-dx22tt5-tranthicamtien-xaydungwebsitemuabandoluuniemhocsinh.git
2. Chạy môi trường PHP:

Sử dụng XAMPP, Laragon hoặc WAMP

Đặt toàn bộ mã nguồn vào thư mục htdocs/ (nếu dùng XAMPP)

3. Cấu hình cơ sở dữ liệu:

Import file SQL đi kèm (nếu có) vào phpMyAdmin

Sửa thông tin kết nối trong includes/config.php:
$conn = mysqli_connect("localhost", "root", "", "ten_csdlduan");

4. Truy cập website:

Mở trình duyệt, nhập đường dẫn:
http://localhost/src/index.php


📌 Chức năng chính
Xem danh sách sản phẩm đồ lưu niệm

Đăng ký / Đăng nhập người dùng

Giỏ hàng và đặt hàng

Tìm kiếm và lọc sản phẩm

Phân quyền (Admin, Người dùng)

Admin quản lý toàn bộ hệ thống


📅 Tiến độ thực hiện
Tiến độ được ghi lại trong thư mục progres-report/

Mỗi tuần sẽ có 1 file báo cáo dạng .md hoặc .docx như: week1.md, tuan4.docx, ...

📁 Cấu trúc thư mục chính
├── src/
│   ├── index.php             # Trang chủ
│   ├── login.php / register.php
│   ├── cart.php              # Giỏ hàng
│   ├── admin/                # Khu vực admin
│   ├── includes/             # Cấu hình, kết nối CSDL
│   ├── css/ / js/ / img/     # Giao diện và tài nguyên
│   └── ...  
├── progress/                 # Báo cáo tiến độ tuần
├── thesis/                   # Thư mục chứa báo cáo đồ án
│   ├── pdf/
│   └── doc/
├── README.md


📜 Ghi chú

- Giao diện tối ưu cho học sinh, sinh viên

- File này (README.md) sẽ cập nhật theo tiến độ thực tế