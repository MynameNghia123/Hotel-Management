# 🏨 Hệ thống Quản lý Khách sạn (Hotel Management)

Dự án này là một ứng dụng web giúp tự động hóa quy trình đặt phòng, quản lý nhân sự và theo dõi trạng thái phòng cho các khách sạn quy mô vừa và nhỏ.

---

## 📸 Hình ảnh Demo

![Trang chủ](screenshots/home.png)

![Dashboard](screenshots/dashboard.png)


---

## 🛠️ Công nghệ sử dụng (Tech Stack)

- **Frontend**: Vite, JS, CSS/TailwindCSS
- **Backend**: Laravel (PHP)
- **Database**: MySQL
- **Tools**: Laragon, Git, Composer, NPM
- **Kiến trúc**: Repository - Service Pattern

---

## 🌟 Chức năng chính (Key Features)

- Quản lý danh sách phòng và theo dõi trạng thái phòng (Trống, Đang dọn, Đã đặt...).
- Xác thực người dùng (Login/Register) và phân quyền (Admin / Customer).
- Xử lý logic đặt phòng cho khách hàng.
- Quản lý hóa đơn và thống kê doanh thu (Dashboard Admin).

---

## 🚀 Hướng dẫn cài đặt (Installation)

**Yêu cầu hệ thống:**
- PHP >= 8.1
- Node.js & npm
- Composer
- Môi trường Local: **Laragon** (khuyên dùng trên Windows) hoặc XAMPP.

**Các bước thực hiện:**

1. **Clone repository:**
   ```bash
   git clone <link-repo>
   ```

2. **Mở thư mục dự án bằng IDE** (ví dụ: VS Code, Antigravity IDE) và chuyển vào thư mục dự án:
   ```bash
   cd Hotel
   ```

3. **Cài đặt thư viện Backend:**
   ```bash
   composer install
   ```

4. **Cài đặt thư viện Frontend:**
   ```bash
   npm install
   ```

5. **Cấu hình môi trường:**
   - Copy file `.env.example` thành `.env`:
     ```bash
     cp .env.example .env
     ```
   - Mở file `.env` và cấu hình kết nối database MySQL (đảm bảo bạn đã tạo database `hotelManagement_db` trong MySQL):
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=hotelManagement_db
     DB_USERNAME=root
     DB_PASSWORD=
     ```

6. **Khởi tạo Key và Database:**
   ```bash
   php artisan key:generate
   php artisan migrate
   ```

7. **Chạy Server:**
   - Chạy server Backend (Mở Terminal 1):
     ```bash
     php artisan serve
     ```
   - Chạy server Frontend (Mở Terminal 2):
     ```bash
     npm run dev
     ```

---

## 💡 Những gì tôi học được (What I Learned)

- **Kiến trúc hệ thống:** Hiểu sâu và ứng dụng thành công **Repository - Service Pattern** trong Laravel. Điều này giúp tách biệt rõ ràng logic truy vấn dữ liệu và logic nghiệp vụ, làm cho code gọn gàng, dễ test và dễ bảo trì hơn rất nhiều so với việc nhồi nhét tất cả vào Controller.
- **Quản lý Transaction:** Nắm bắt được cách giải quyết bài toán đồng bộ dữ liệu khi đặt phòng (tránh tình trạng đặt trùng phòng hoặc lỗi giữa chừng) bằng Database Transactions.
- **Quy trình Fullstack:** Nắm vững cách kết nối mượt mà giữa Frontend (Vite) và Backend (Laravel) trong quá trình phát triển, cũng như quy trình deploy cơ bản ở môi trường local (Laragon).
