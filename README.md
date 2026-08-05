# HoaSang Mobile - Website Thương Mại Điện Tử Kinh Doanh Điện Thoại

## 📖 Giới thiệu dự án
Dự án "Xây dựng website thương mại điện tử (Kinh doanh điện thoại di động)" được phát triển nhằm cung cấp một nền tảng mua sắm trực tuyến chuyên nghiệp, thân thiện và tối ưu cho hệ thống Hoa Sáng Mobile. Hệ thống bao gồm hai phân hệ chính:
- **Khách hàng (User):** Xem sản phẩm, tìm kiếm, giỏ hàng, đặt hàng, thanh toán (COD, VNPay), xem lịch sử đơn hàng, sử dụng mã giảm giá và chatbot tư vấn.
- **Quản trị viên (Admin):** Quản lý sản phẩm, danh mục, thương hiệu, đơn hàng, người dùng, phiếu nhập kho, mã giảm giá (voucher), tin tức (blog) và xem báo cáo thống kê.

**Tác giả:** Elysszxje

## 🛠 Công nghệ ứng dụng
Dự án được xây dựng dựa trên các công nghệ web:
- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP
- **Cơ sở dữ liệu:** MySQL

## ⚙️ Các phần mềm cần thiết
Để chạy dự án trên máy tính cá nhân (localhost), bạn cần cài đặt các phần mềm sau:
1. **[XAMPP](https://www.apachefriends.org/download.html):** Cung cấp Web Server Apache và hệ quản trị CSDL MySQL.
2. **[Visual Studio Code](https://code.visualstudio.com/):** Trình soạn thảo mã nguồn (hoặc bất kỳ trình soạn thảo code nào khác).

## 🚀 Hướng dẫn cài đặt và chạy dự án (Localhost)

**Bước 1: Cài đặt mã nguồn**
- Clone repository này hoặc tải mã nguồn file `.zip` về máy và giải nén.
- Copy thư mục dự án (ví dụ: `hoasang`) và dán vào thư mục `htdocs` của phần mềm XAMPP.
- *Đường dẫn mặc định:* `C:\xampp\htdocs\hoasang`

**Bước 2: Khởi động Web Server**
- Mở ứng dụng **XAMPP Control Panel**.
- Nhấn nút **Start** ở 2 module: **Apache** và **MySQL**.

**Bước 3: Thiết lập Cơ sở dữ liệu (Database)**
- Truy cập vào địa chỉ: `http://localhost/phpmyadmin` trên trình duyệt web.
- Tạo một cơ sở dữ liệu mới (ví dụ tên là: `hoasang_db`).
- Chọn tab **Import (Nhập)**, tải lên file cơ sở dữ liệu `hoasang.sql` của dự án và nhấn **Go (Thực hiện)**.

**Bước 4: Cấu hình kết nối CSDL**
- Mở thư mục dự án trong Visual Studio Code.
- Tìm đến file cấu hình kết nối CSDL và cập nhật thông tin:
  ```php
  $servername = "localhost";
  $username = "root";
  $password = ""; // Mặc định XAMPP để trống
  $dbname = "hoasang_db"; // Tên database vừa tạo
  ```

**Bước 5: Cấu hình API Chatbot**
- Tạo một file mới tên là `env.php` ở thư mục gốc (root folder) của dự án.
- Dán đoạn mã sau vào file `env.php` và thay thế `'INSERT_YOUR_API_KEY_HERE'` bằng API key thật của bạn:
  ```php
  <?php
  // FILE NÀY DÙNG ĐỂ LƯU KEY BẢO MẬT - KHÔNG PUSH LÊN GITHUB
  define('GEMINI_API_KEY', 'INSERT_YOUR_API_KEY_HERE'); 
  ?>
  ```

**Bước 6: Trải nghiệm dự án**
- **Trang Khách hàng:** Truy cập `http://localhost/hoasang`
- **Trang Quản trị (Admin):** Truy cập `http://localhost/hoasang/admin` (hoặc đường dẫn quản trị tương ứng của bạn).
  - *Tài khoản quản trị mặc định:*
    - **Username:** `admin`
    - **Password:** `admin`


