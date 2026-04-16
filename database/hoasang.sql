-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 16, 2026 at 04:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hoasang`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `thumbnail`, `product_id`, `created_at`) VALUES
(1, 'Iphone 17 Pro Max new seal', 'img/banners/1764601647_banner17max.jpg', 1, '2026-04-14 15:07:27'),
(2, 'S25 Ultra', 'img/banners/1764601871_Thiet-ke-Galaxy-S25-Ultra-co-thay-doi-khong.jpg', 2, '2025-12-01 15:11:11');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `thumbnail`, `content`, `created_at`, `updated_at`) VALUES
(1, '4 tuyệt chiêu nhận biết iPhone Lock không lo bị lừa', 'img/blogs/1763716818_dev_final.jpg', '<h2>iPhone Lock là gì?</h2><p>Trước hết bạn cần hiểu rõ thế nào là iPhone Lock để không bị những lời \"mật ngọt\" của gian thương dụ dỗ. iPhone Lock (khóa SIM) được phát hành độc quyền để hòa mạng duy nhất vào một nhà mạng bên nước ngoài. Khi đưa sang nước khác, người bán sẽ có thủ thuật cấy SIM ghép để hòa mạng khác thoải mái.</p><p><img src=\"https://cdn.nguyenkimmall.com/images/companies/_1/Content/tin-tuc/vien-thong/4-cach-phan-biet-iphone-lock-va-iphone-quoc-te-01.jpg\" alt=\"Cẩn thận rơi vào bẫy lừa bán iPhone Lock\"></p><p><i>Cẩn thận rơi vào bẫy lừa bán iPhone Lock</i></p><p>Trước đây, nhằm đánh lừa khâu kiểm duyệt của Apple hoặc nhà mạng gốc, cách làm thường dùng là sử dụng một \"phôi\" SIM riêng bên ngoài (loại khung kết nối có vỏ lắp liền được SIM của nhà mạng khác), rồi đưa vào khe cắm SIM. Nhưng giờ đây đã có cách tinh vi hơn, tại khe cắm SIM ẩn bên trong, họ sẽ \"cấy\" và lắp thẳng mối nối vào, người dùng chỉ cần lắp SIM vào là dùng như bình thường.</p><h2>Cách phát hiện iPhone Lock dùng SIM ghép</h2><p>Chẳng ai muốn mua một chiếc điện thoại bị lắp ghép, chỉnh sửa với mức giá máy quốc tế.&nbsp;Để không trở thành \"con mồi\" cho kẻ xấu, hãy nắm rõ 4 cách phân biệt&nbsp;iPhone Lock và iPhone quốc tế.</p><p><strong>Cách 1: Lắp SIM của các nhà mạng khác nhau để kiểm tra tổng quát</strong></p><p>Khi người bán hào phóng tặng bạn chiếc SIM họ đang lắp sẵn trong máy, hãy cảnh giác và thử dùng SIM của các nhà mạng khác như VinaPhone, Viettel, Mobifone lắp vào kiểm tra.&nbsp;Nếu phát hiện bất kỳ trường hợp lắp SIM khác nào hiện lên giao diện khó hiểu, yêu cầu kích hoạt dù đang dùng bình thường, thì bạn tạm biệt họ đi nhé! Nguy cơ họ đang lừa bạn rất cao.</p><p><img src=\"https://cdn.nguyenkimmall.com/images/companies/_1/Content/tin-tuc/vien-thong/4-cach-phan-biet-iphone-lock-va-iphone-quoc-te-02.jpg\" alt=\"iPhone quốc tế sẽ không yêu cầu bạn kích hoạt khi đang dùng bình thường\"></p><p><i>iPhone quốc tế sẽ không yêu cầu bạn kích hoạt khi đang dùng bình thường</i></p><p><strong>Cách 2: Truy cập Settings &gt; General &gt; About &gt; Carrier</strong></p><p>Kiểm tra trong phần&nbsp;Settings &gt; General &gt; About &gt; Carrier xem tên nhà mạng hiển thị trên iPhone đã đúng với SIM bạn đang lắp thử hay chưa. Trường hợp nhà mạng không trùng khớp, thì hãy tìm nơi bán hàng uy tín hơn nhé!</p><p><img src=\"https://cdn.nguyenkimmall.com/images/companies/_1/Content/tin-tuc/vien-thong/4-cach-phan-biet-iphone-lock-va-iphone-quoc-te-03.jpg\" alt=\"Thực hiện các bước để kiểm tra iPhone\"></p><p><i>Thực hiện các bước để kiểm tra iPhone</i></p><p>Ngoài ra, bạn cũng có thể vào&nbsp;Settings &gt; Phone để kiểm tra. Nếu ở dưới cùng có lựa chọn ghi tên dịch vụ nhà mạng của bạn hãy yên tâm.</p><p><img src=\"https://cdn.nguyenkimmall.com/images/companies/_1/Content/tin-tuc/vien-thong/4-cach-phan-biet-iphone-lock-va-iphone-quoc-te-04.jpg\" alt=\"Hiện lên&nbsp;Service tên nhà mạng SIM bạn đang gắn vào máy\"></p><p><i>Hiện lên&nbsp;Service tên nhà mạng SIM bạn đang gắn vào máy</i></p><p><strong>Cách 3: Truy cập Settings &gt; General &gt; ICCID</strong></p><p>SIM sẽ có mã xác nhận riêng gọi là ICCID, được quy định sẵn để dành cho các thao tác xem xét và kiểm tra liên quan. Bất kỳ 4 số đầu nào không phải là&nbsp;\"8984\", xin chia buồn với bạn, đây là chiếc iPhone Lock.</p><p><img src=\"https://cdn.nguyenkimmall.com/images/companies/_1/Content/tin-tuc/vien-thong/4-cach-phan-biet-iphone-lock-va-iphone-quoc-te-05.jpg\" alt=\"iPhone quốc tế chuẩn sẽ có ICCID 4 chữ số đầu là \"></p><p><i>iPhone quốc tế chuẩn sẽ có ICCID 4 chữ số đầu là \"8984\"</i></p><p><strong>Cách 4: Một số điểm cần lưu ý</strong></p><p>- Không thể tắt âm thanh trên ứng dụng camera: Bạn biết không những chiếc iPhone dành riêng cho thị trường Nhật và Hàn thường không thể tắt âm thanh khi chụp ảnh bằng thanh gạt âm lượng bên cạnh trái của máy, vì ở đó, họ không muốn người dùng lạm dụng <a href=\"https://www.nguyenkim.com/dien-thoai-di-dong/\">điện thoại</a> chụp trộm người khác nên đã can thiệp từ đầu tính năng tắt âm thanh camera.</p><p><img src=\"https://cdn.nguyenkimmall.com/images/companies/_1/Content/tin-tuc/vien-thong/4-cach-phan-biet-iphone-lock-va-iphone-quoc-te-06.jpg\" alt=\"iPhone ở Nhật và Hàn không thể tắt âm thanh trên camera bằng&nbsp;thanh gạt âm lượng&nbsp;\"></p><p><i>iPhone ở Nhật và Hàn không thể tắt âm thanh trên camera bằng&nbsp;thanh gạt âm lượng</i></p>', '2026-04-14 09:20:18', '2026-04-14 09:20:18'),
(2, 'Mẹo Gửi Hình HD, Đảm Bảo Tối Đa Chất Lượng Ảnh', 'img/blogs/1763717139_Cà Vạt Lụa Tổng Hợp Bản 7 cm – CL7XDS003.png', '<h2><strong>Gửi ảnh HD qua Messenger iPhone, Android</strong></h2><p>Gửi hình trên Facebook sẽ bị bể hình và mờ nhòe ư? Đây đã là chuyện ngày xưa rồi, giờ đây, bạn sẽ bất ngờ với cái cách mà anh Mark đã thay đổi cho tính năng gửi hình qua Messenger đấy! Anh Mark đã nhanh chóng giúp cho Facebook Messenger có chức năng tùy chọn chất lượng ảnh gửi đi. Cụ thể, bạn sẽ tha hồ lựa chọn chất lượng ảnh từ thấp, trung bình đến cao khi gửi ảnh HD qua Messenger iPhone.&nbsp;</p><p><img src=\"https://cdn.nguyenkimmall.com/images/companies/_1/Content/vien-thong/tin-tuc/dien-thoai/gui-hinh-khong-lo-nhoe-voi-5-cach-than-thanh-02.jpg\" alt=\"Cách gửi hình HD qua Messenger iPhone, Android\"></p><p><i>Messenger đã được nâng cấp, giờ đây bạn có thể chọn chất lượng ảnh gửi dễ dàng</i></p><h3><strong>Các bước gửi hình HD qua Messenger</strong></h3><p>Cách gửi ảnh HD qua Messenger iPhone, Android là rất đơn giản. Bạn chỉ chỉ cần thực hiện nhanh theo những bước sau đây.</p><p><strong>Bước 1:</strong> Vào khung chat, nhấn vào biểu tượng chia sẻ ảnh rồi chọn ảnh muốn gửi.&nbsp;</p><p><strong>Bước 2: </strong>Nhấn chọn vào biểu tượng \"HD\" và nhấn biểu tượng gửi đi.</p><p>Khi gửi ảnh ở chế độ HD, chất lượng ảnh sẽ tốt hơn nên dung lượng ảnh cũng cao hơn, vì vậy nên tốc độ gửi ảnh có thể sẽ hơi lâu một chút so với khi gửi ảnh chất lượng thấp. Nếu bạn thấy ảnh có được gửi đi chậm thì cũng không cần phải lo lắng đâu nhé!&nbsp;</p><p>Xem thêm <a href=\"https://www.nguyenkim.com/10-thu-thuat-hay-nhat-tren-facebook-messenger.html\">những thủ thuật hay ho trên Messenger</a> tại đây nhé!</p><h2><strong>Gửi hình HD qua Email</strong></h2><p>Một cách làm khá truyền thống mà hình ảnh lúc nào cũng căng nét chính là gửi hình HD qua mail. Cách này có thể sử dụng được trên cả <a href=\"https://www.nguyenkim.com/dien-thoai-di-dong/\">điện thoại</a> lẫn <a href=\"https://www.nguyenkim.com/may-tinh-de-ban/\">máy tính</a>. Bạn chỉ cần soạn mail và đính kèm tệp ảnh, nhấn nút gửi nữa là xong rồi đấy! Vì Gmail sẽ không nén file hình ảnh của bạn nên bạn có thể hoàn yên tâm về chất lượng ảnh khi gửi hình HD qua Gmail nhé!</p><p><img src=\"https://cdn.nguyenkimmall.com/images/companies/_1/tin-tuc/kinh-nghiem-meo-hay/%C4%91i%E1%BB%87n%20tho%E1%BA%A1i/g%E1%BB%ADi-%E1%BA%A3nh-2.jpg\" alt=\"Cách gửi hình HD qua email\"></p><p><i>Gửi hình qua mail sẽ không lo giảm chất lượng</i></p><p>Tuy nhiên, Gmail vẫn có một nhược điểm đó là dung lượng ảnh khi gửi qua mail chỉ khoảng 20 - 25MB, bạn sẽ không gửi quá nhiều ảnh cùng một lúc được. Hãy chia nhỏ ra gửi để chất lượng và tốc độ gửi ảnh được đảm bảo nhất nhé!</p><p>Tham khảo ngay <a href=\"https://www.nguyenkim.com/nhung-meo-giup-ban-su-dung-gmail-nhu-dan-chuyen-nghiep.html\">những mẹo hay “hô biến” bạn thành “dân chuyên” Gmail</a>.</p>', '2026-04-14 09:23:00', '2026-04-14 09:25:39'),
(3, 'Cách Đăng Nhập, Đăng Xuất Tài Khoản iCloud Trên iPhone, Máy Tính', 'img/blogs/1763717201_dell.png', '<p><strong>iCloud</strong> là một dịch vụ lưu trữ đám mây từ Apple dùng để xác nhận quyền sở hữu của một người dùng đối với chiếc iPhone của họ. iCloud có khả năng đồng bộ dữ liệu từ văn bản, hình ảnh, danh bạ hay nhạc trên tất cả các thiết bị iPhone, iPad,&nbsp; iPod touch, MacOS và máy tính Windows.</p><p>Các dòng điện thoại iPhone có hệ điều hành từ iOS 7 trở về sau đã được tích hợp sẵn iCloud. Đồng thời Apple còn bổ sung thêm tính năng Find My Phone và chế độ Activation Lock cho người dùng từ xa để vô hiệu hóa máy khi bị đánh cắp</p><p>Mục đích của iCloud để bảo vệ thông tin cá nhân và dữ liệu của người dùng. Khi bị đánh cắp hay mất điện thoại, bạn có thể đăng nhập iCloud trên <a href=\"https://www.nguyenkim.com/may-tinh-xach-tay/\">máy tính</a> để xóa thiết bị khỏi danh sách thiết bị. Sau đây là những cách đăng nhập và đăng xuất iCloud trên máy tính, laptop hệ điều hành Windows và dòng máy MacBook.</p><h2><strong>Cách đăng nhập iCloud trên iPhone</strong></h2><p><strong>Bước 1:</strong> Truy cập vào iCloud bằng liên kết: <a href=\"https://www.icloud.com\">https://www.icloud.com</a> &gt; Sau đó nhập đầy đủ tên tài khoản của bạn &gt; Bấm vào nút mũi tên &gt; Điền mật khẩu của bạn &gt; Tiếp tục bấm vào nút mũi tên.</p><p><img src=\"https://cdn.nguyenkimmall.com/images/companies/_1/tin-tuc/kinh-nghiem-meo-hay/C%C3%B4ng%20ngh%E1%BB%87/huong-dan-cach-dang-nhap-icloud-tren-may-tinh-dien-thoai-10.jpg\" alt=\"lazy_img\"></p><p><strong>Bước 2:</strong> Nhập mã xác minh Apple đã gửi để xác thực. Chọn Tin cậy màu xanh để bỏ qua bước nhập mã xác minh cho lần đăng nhập sau.</p><p><img src=\"https://cdn.nguyenkimmall.com/images/companies/_1/tin-tuc/kinh-nghiem-meo-hay/C%C3%B4ng%20ngh%E1%BB%87/huong-dan-cach-dang-nhap-icloud-tren-may-tinh-dien-thoai-11.jpg\" alt=\"lazy_img\"></p><p><strong>Bước 3:</strong> Giao diện của iCloud trên điện thoại sẽ hiện ra và bạn có thể bắt đầu sử dụng.</p><h2><strong>Cách đăng nhập iCloud trên máy tính</strong></h2><h3><strong>Đăng nhập iCloud trên máy tính bằng trình duyệt web</strong></h3><p><strong>Bước 1:</strong> Truy cập vào trang chủ của <a href=\"https://www.icloud.com/\">iCloud</a></p><p><strong>Bước 2:</strong> <strong>Nhập tên tài khoản và mật khẩu</strong> sau đó nhấn<strong> Enter</strong> hoặc nút mũi tên để đăng nhập.</p><p><img src=\"https://cdn.nguyenkimmall.com/images/companies/_1/tin-tuc/kinh-nghiem-meo-hay/C%C3%B4ng%20ngh%E1%BB%87/huong-dan-cach-dang-nhap-icloud-tren-may-tinh-dien-thoai-1.jpg.jpg\" alt=\"Nhập tên tài khoản và mật khẩu để đăng nhập iCloud trên máy tính bằng trình duyệt web\"></p><p><strong>Bước 3:</strong> Giao diện iCloud hiện ra đầy đủ các tính năng mà bạn có thể từng mục bạn muốn xem với nội dung tương ứng.</p>', '2026-04-14 09:26:06', '2026-04-14 09:26:41');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `logo`) VALUES
(1, 'Apple', 'img/company/1764304929_logo-apple-1.png'),
(2, 'Samsung', 'img/company/1764304959_Samsung_old_logo_before_year_2015.svg.png'),
(3, 'Xiaomi', 'img/company/1764304974_Xiaomi_logo_(2021-).svg.png'),
(4, 'Huawei', 'img/company/1764304987_Huawei_Standard_logo.svg.png'),
(5, 'Vivo', 'img/company/1764305000_Vivo_logo_2019.svg.png');

-- --------------------------------------------------------

--
-- Table structure for table `imports`
--

CREATE TABLE `imports` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `supplier_id` int(11) DEFAULT NULL,
  `total` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `imports`
--

INSERT INTO `imports` (`id`, `created_at`, `supplier_id`, `total`) VALUES
(4, '2025-11-28 09:08:44', 1, 349000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `import_details`
--

CREATE TABLE `import_details` (
  `import_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_price` decimal(15,2) DEFAULT NULL,
  `import_price` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `import_details`
--

INSERT INTO `import_details` (`import_id`, `product_id`, `quantity`, `total_price`, `import_price`) VALUES
(4, 1, 12, 324000000.00, 27000000.00),
(4, 5, 5, 25000000.00, 5000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `voucher_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(50) NOT NULL,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `sub_total` decimal(15,2) NOT NULL,
  `payment_method` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `voucher_id`, `user_id`, `created_at`, `updated_at`, `status`, `total`, `sub_total`, `payment_method`) VALUES
(15, NULL, 5, '2026-04-16 09:12:01', '2026-04-16 09:12:01', 'pending', 35990000.00, 35990000.00, 'vnpay');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `total_price` decimal(15,2) GENERATED ALWAYS AS (`quantity` * `price`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `price`) VALUES
(15, 9, 1, 35990000.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `star` int(11) DEFAULT NULL,
  `rateCount` int(11) DEFAULT NULL,
  `screen` varchar(255) DEFAULT NULL,
  `os` varchar(100) DEFAULT NULL,
  `camera` varchar(255) DEFAULT NULL,
  `cameraFront` varchar(255) DEFAULT NULL,
  `cpu` varchar(255) DEFAULT NULL,
  `ram` varchar(255) DEFAULT NULL,
  `rom` varchar(255) DEFAULT NULL,
  `battery` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `import_price` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `company_id`, `img`, `price`, `star`, `rateCount`, `screen`, `os`, `camera`, `cameraFront`, `cpu`, `ram`, `rom`, `battery`, `created_at`, `updated_at`, `quantity`, `status`, `import_price`) VALUES
(1, 'Iphone 17 Pro Max', 1, 'img/products/1763109858_17 max.png', 39000000.00, 5, 0, '6.9', 'IOS', '48', '12', 'A19 Pro', '8', '256GB', '4352', '2025-11-12 11:12:56', '2025-11-12 11:12:56', 42, 1, 27000000.00),
(2, 'Samsung S25 Ultra', 2, 'img/products/1762512556_s25ultra.png', 29000000.00, 4, 0, '6.9', 'Android', '48', '12', 'Snapdragon 8 Gen 4', '12', '512', '5500', '2025-11-12 11:12:56', '2025-11-12 11:12:56', 60, 1, 50000000.00),
(3, 'Redmi note 13 pro 5g', 3, 'img/products/1762522811_redmi.jpg', 5000000.00, 3, 0, '6.5', 'Android', '48', '12', 'Snap 6 gen 2', '6', '128', '5000', '2025-11-12 11:12:56', '2025-11-12 11:12:56', 10, 1, 5000000.00),
(4, 'Huawei Mate 50 Pro', 1, 'img/products/1763110329_Huawei Mate 50 Pro.jpg', 28999000.00, 5, 0, '6.7 inch', 'HarmonyOS', '50MP', '13MP', 'Kirin 9000', '8GB', '256GB', '4500mAh', '2025-11-14 15:51:44', '2025-11-14 15:51:44', 12, 1, 5000000.00),
(5, 'Vivo X90 Pro', 2, 'img/products/1763110357_Vivo X90 Pro.jpg', 22999000.00, 4, 0, '6.78 inch', 'Android', '50MP', '32MP', 'Snapdragon 8 Gen 2', '12GB', '256GB', '4800mAh', '2025-11-14 15:51:44', '2025-11-14 15:51:44', 17, 1, 5000000.00),
(6, 'Samsung Galaxy Z Fold 5', 3, 'img/products/1763110472_Samsung Galaxy Z Fold 5.jpg', 55999000.00, 5, 0, '7.6 inch', 'Android', '50MP', '10MP', 'Snapdragon 8 Gen 2', '12GB', '512GB', '4400mAh', '2025-11-14 15:51:44', '2025-11-14 15:51:44', 10, 1, 5000000.00),
(7, 'Xiaomi Redmi Note 12 Pro', 1, 'img/products/1763110592_xiaomi-redmi-12-pro-4g-thumb-600x600.jpg', 7999000.00, 4, 0, '6.67 inch', 'Android', '50MP', '13MP', 'Dimensity 1080', '6GB', '128GB', '5000mAh', '2025-11-14 15:51:44', '2025-11-14 15:51:44', 10, 1, 5000000.00),
(8, 'Oppo Reno 8 Pro', 2, 'img/products/1763111483_oppo-reno8-pro-thumb-xanh-1-600x600.jpg', 11499000.00, 3, 0, '6.7 inch', 'Android', '50MP', '32MP', 'Dimensity 1300', '8GB', '256GB', '4500mAh', '2025-11-14 15:51:44', '2025-11-14 15:51:44', 10, 1, 5000000.00),
(9, 'iPhone 14 Pro Max', 3, 'img/products/1763111501_14max.jpg', 35990000.00, 5, 0, '6.7 inch', 'iOS', '48MP', '12MP', 'A16 Bionic', '6GB', '256GB', '4323mAh', '2025-11-14 15:51:44', '2025-11-14 15:51:44', 10, 1, 5000000.00),
(10, 'Realme GT 2 Pro', 1, 'img/products/1763111514_gt2.jpg', 17999000.00, 4, 0, '6.7 inch', 'Android', '50MP', '32MP', 'Snapdragon 8 Gen 1', '12GB', '256GB', '5000mAh', '2025-11-14 15:51:44', '2025-11-14 15:51:44', 10, 1, 5000000.00),
(11, 'OnePlus 11', 2, 'img/products/1763111536_op11.png', 24999000.00, 4, 0, '6.7 inch', 'Android', '50MP', '16MP', 'Snapdragon 8 Gen 2', '12GB', '256GB', '5000mAh', '2025-11-14 15:51:44', '2025-11-14 15:51:44', 10, 1, 5000000.00),
(12, 'Google Pixel 7 Pro', 3, 'img/products/1763111550_Google Pixel 7 Pro.jpg', 26999000.00, 5, 0, '6.7 inch', 'Android', '50MP', '10.8MP', 'Google Tensor G2', '12GB', '128GB', '5000mAh', '2025-11-14 15:51:44', '2025-11-14 15:51:44', 10, 1, 5000000.00),
(13, 'Asus ROG Phone 6', 1, 'img/products/1763111563_Asus ROG Phone 6.png', 28999000.00, 5, 0, '6.78 inch', 'Android', '50MP', '12MP', 'Snapdragon 8+ Gen 1', '16GB', '512GB', '6000mAh', '2025-11-14 15:51:44', '2025-11-14 15:51:44', 10, 1, 5000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL DEFAULT 5,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `contact_phone` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact_email`, `contact_phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Juxin', 'juxin@china.com', '0987111222', 'Juxin, China', '2025-11-21 16:02:37', '2025-11-21 16:03:34'),
(2, 'Cellphones', 'cell@gmail.com', '0987888111', 'Hanoi', '2025-11-21 16:06:12', '2025-11-21 16:06:12'),
(3, 'Thế giới di động', 'tgdd@gmail.com', '0912345678', 'HN', '2025-11-21 20:43:01', '2025-11-21 20:43:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `DienThoai` varchar(15) DEFAULT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `NgayTao` datetime DEFAULT current_timestamp(),
  `Role` enum('Admin','User') DEFAULT 'User',
  `TrangThai` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Username`, `Password`, `HoTen`, `Email`, `DienThoai`, `DiaChi`, `NgayTao`, `Role`, `TrangThai`) VALUES
(2, 'admin', '$2y$10$rCfQAtYJL5QRbp3EtIHiNuK/c7Gj3kIwPtEJZOW4JLkj3Jvycdu5.', 'Tran Pham Thai Vu', 'gabayvu@gmail.com', '0912487938', 'Hanoi', '2026-04-08 20:57:09', 'Admin', 1),
(4, 'admin1', '$2y$10$rCfQAtYJL5QRbp3EtIHiNuK/c7Gj3kIwPtEJZOW4JLkj3Jvycdu5.', 'Vu Tran', 'vutran2k4@gmail.com', '0912487938', 'Hà Nội', '2026-04-16 08:36:08', 'User', 1),
(5, 'user1', '$2y$10$e5xyKL3i378OKJ05CdAOYOR2LxC2M1k0Jb5bcLk7ihP/g.wLdvUFS', 'Test User', 'abc@gmail.com', '0912345678', '', '2026-04-16 08:48:39', 'User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(100) NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `name`, `code`, `discount_value`, `start_date`, `end_date`, `quantity`) VALUES
(1, 'Giải phóng Miền nam 30/4', 'GPMN-3004', 12.00, '2026-04-01 12:12:00', '2026-05-31 12:12:00', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `imports`
--
ALTER TABLE `imports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `import_details`
--
ALTER TABLE `import_details`
  ADD PRIMARY KEY (`import_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_user` (`user_id`),
  ADD KEY `fk_orders_voucher` (`voucher_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `fk_order_items_product` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product` (`product_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `imports`
--
ALTER TABLE `imports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `banners`
--
ALTER TABLE `banners`
  ADD CONSTRAINT `banners_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `imports`
--
ALTER TABLE `imports`
  ADD CONSTRAINT `imports_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `import_details`
--
ALTER TABLE `import_details`
  ADD CONSTRAINT `import_details_ibfk_1` FOREIGN KEY (`import_id`) REFERENCES `imports` (`id`),
  ADD CONSTRAINT `import_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orders_voucher` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `brands` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
