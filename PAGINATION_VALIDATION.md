# Pagination Validation & Default Values

## 📋 Tổng quan

Trait `PaginationTrait` cung cấp validation cho `per_page` parameter và xử lý default values.

## ✨ Tính năng

### 1. **Validation `per_page`**
- Chỉ cho phép các giá trị: `5, 10, 20, 50, 100`
- Nếu giá trị không hợp lệ, tự động trở về mặc định
- Chống tấn công với giá trị quá lớn (e.g., ?per_page=999999)

### 2. **Default Values**
- **per_page**: Mặc định `10` (có thể tùy chỉnh)
- **page**: Mặc định `1` (tự động)
- Luôn đảm bảo URL không ghi rõ tham số vẫn hoạt động

### 3. **Type Safety**
- Tự động ép kiểu thành `integer`
- Ngăn chặn SQL injection

---

## 🚀 Cách sử dụng

### Bước 1: Thêm Trait vào Controller

```php
<?php

namespace App\Http\Controllers;

use App\Http\Traits\PaginationTrait;

class MyController extends Controller
{
    use PaginationTrait;
    
    public function index()
    {
        // Lấy per_page với validation
        $perPage = $this->getPerPage(10); // Default: 10
        
        // Sử dụng trong service/repository
        $data = $this->service->getPaginated($perPage);
        
        return view('my-view', compact('data'));
    }
}
```

### Bước 2: Tùy chỉnh giá trị (tùy chọn)

```php
// Thay đổi default value
$perPage = $this->getPerPage(20); // Default: 20

// Thay đổi các giá trị được phép
$perPage = $this->getPerPage(10, [5, 10, 15, 20, 30]);
```

### Bước 3: Nhận trang hiện tại (nếu cần)

```php
$page = $this->getCurrentPage(1); // Default: 1
```

---

## 📝 Ví dụ thực tế

### Trước (không có validation):
```php
public function index()
{
    $perPage = request('per_page', 10); // Có thể nhận giá trị 999999
    $staffs = $this->service->getPaginated($perPage);
    return view('staffs.index', compact('staffs'));
}
```

### Sau (có validation):
```php
public function index()
{
    $perPage = $this->getPerPage(10); // Chỉ nhận [5, 10, 20, 50, 100]
    $staffs = $this->service->getPaginated($perPage);
    return view('staffs.index', compact('staffs'));
}
```

---

## 🔒 Bảo mật

### URL hợp lệ:
```
/admin/staffs                    → per_page = 10 (default)
/admin/staffs?per_page=20        → per_page = 20 ✅
/admin/staffs?page=2&per_page=50 → per_page = 50, page = 2 ✅
```

### URL không hợp lệ (tự động khôi phục):
```
/admin/staffs?per_page=999      → per_page = 10 ✅ (mặc định)
/admin/staffs?per_page=abc      → per_page = 10 ✅ (mặc định)
/admin/staffs?page=0             → page = 1 ✅ (tối thiểu)
/admin/staffs?page=-5            → page = 1 ✅ (tối thiểu)
```

---

## 🎯 Controllers đã áp dụng

- ✅ **StaffController**
- ✅ **RoleController**

## 📌 Áp dụng cho các controller khác

Để áp dụng cho controller khác, chỉ cần:

1. Thêm `use PaginationTrait;`
2. Thay đổi `request('per_page', 10)` → `$this->getPerPage(10)`

---

## 💡 Ghi chú

- Trait này hoạt động độc lập, không cần thay đổi Model hay Service
- Giá trị mặc định có thể tùy chỉnh theo nhu cầu
- Toàn bộ validation xảy ra ở backend, an toàn từ front-end
