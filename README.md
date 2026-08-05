# HoaSang Mobile - Website Thương Mại Điện Tử Kinh Doanh Điện Thoại
## English section below

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

---

# English Section

# HoaSang Mobile - Mobile Phone E-commerce Website

## 📖 Project Introduction
The project "Building an e-commerce website (Mobile phone business)" was developed to provide a professional, user-friendly, and optimized online shopping platform for the Hoa Sang Mobile system. The system consists of two main modules:
- **User:** View products, search, shopping cart, order placement, payment (COD, VNPay), view order history, use discount codes, and consulting chatbot.
- **Admin:** Manage products, categories, brands, orders, users, inventory receipts, vouchers, news (blog), and view statistical reports.

**Author:** Elysszxje

## 🛠 Technologies Used
The project is built using the following web technologies:
- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP
- **Database:** MySQL

## ⚙️ Prerequisites
To run the project on your local machine (localhost), you need to install the following software:
1. **[XAMPP](https://www.apachefriends.org/download.html):** Provides the Apache Web Server and MySQL database management system.
2. **[Visual Studio Code](https://code.visualstudio.com/):** Source code editor (or any other code editor of your choice).

## 🚀 Installation and Setup Guide (Localhost)

**Step 1: Install source code**
- Clone this repository or download the `.zip` source code file and extract it.
- Copy the project folder (e.g., `hoasang`) and paste it into the `htdocs` directory of your XAMPP installation.
- *Default path:* `C:\xampp\htdocs\hoasang`

**Step 2: Start the Web Server**
- Open the **XAMPP Control Panel** application.
- Click the **Start** button for two modules: **Apache** and **MySQL**.

**Step 3: Database Setup**
- Access the following address in your web browser: `http://localhost/phpmyadmin`.
- Create a new database (e.g., named `hoasang_db`).
- Select the **Import** tab, upload the project's `hoasang.sql` database file, and click **Go**.

**Step 4: Configure Database Connection**
- Open the project folder in Visual Studio Code.
- Locate the database connection configuration file and update the information:
  ```php
  $servername = "localhost";
  $username = "root";
  $password = ""; // Default XAMPP is empty
  $dbname = "hoasang_db"; // The newly created database name
  ```

**Step 5: Configure Chatbot API**
- Create a new file named `env.php` in the root folder of the project.
- Paste the following code into the `env.php` file and replace `'INSERT_YOUR_API_KEY_HERE'` with your actual API key:
  ```php
  <?php
  // THIS FILE IS USED TO STORE SECURITY KEYS - DO NOT PUSH TO GITHUB
  define('GEMINI_API_KEY', 'INSERT_YOUR_API_KEY_HERE'); 
  ?>
  ```

**Step 6: Experience the project**
- **User Page:** Access `http://localhost/hoasang`
- **Admin Page:** Access `http://localhost/hoasang/admin` (or your corresponding admin path).
  - *Default admin account:*
    - **Username:** `admin`
    - **Password:** `admin`
