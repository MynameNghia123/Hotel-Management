# Dynamic Page Validation

## 📋 Tổng quan

Thêm validation động cho page number để xử lý các trường hợp URL có trang không tồn tại.

## ✨ Tính năng mới

### 1. **validatePageNumber()**
Kiểm tra xem page hiện tại có hợp lệ không:
- Nếu `page > lastPage` → **Throw 404**
- Nếu không có dữ liệu (`lastPage = 0`) → **Throw 404**
- Nếu trang hợp lệ → Cho phép tiếp tục

### 2. **Hai chế độ xử lý:**

| Mode | Hành động |
|------|----------|
| `'abort'` | Throw 404 error (mặc định) |
| `'redirect'` | Redirect về trang cuối cùng |

### 3. **hasData()**
Kiểm tra collection có dữ liệu không

---

## 🚀 Cách sử dụng

### Ví dụ 1: Sử dụng chế độ `'abort'` (mặc định - Throw 404)

```php
public function index()
{
    $perPage = $this->getPerPage(10);
    $staffs = $this->staffService->getPaginated($perPage);
    
    // Nếu page không hợp lệ, throw 404
    $this->validatePageNumber($staffs->currentPage(), $staffs->lastPage(), 'abort');
    
    return view('admin.staffs.index', compact('staffs'));
}
```

**URL hợp lệ:**
```
/admin/staffs           → ✅ OK (page = 1)
/admin/staffs?page=1    → ✅ OK
/admin/staffs?page=5    → ✅ OK (nếu có 5 trang)
```

**URL không hợp lệ:**
```
/admin/staffs?page=999  → ❌ 404 (trang 999 không tồn tại)
/admin/staffs?page=0    → ✅ OK (auto redirect to page 1)
/admin/staffs?page=-5   → ✅ OK (auto redirect to page 1)
```

---

### Ví dụ 2: Sử dụng chế độ `'redirect'` (Redirect về trang cuối)

```php
public function index()
{
    $perPage = $this->getPerPage(10);
    $staffs = $this->staffService->getPaginated($perPage);
    
    // Nếu page không hợp lệ, redirect về trang cuối
    $this->validatePageNumber($staffs->currentPage(), $staffs->lastPage(), 'redirect');
    
    return view('admin.staffs.index', compact('staffs'));
}
```

**Hành động:**
```
/admin/staffs?page=999   → Redirect về /admin/staffs?page=5
/admin/staffs?page=100   → Redirect về /admin/staffs?page=5
```

---

### Ví dụ 3: Kiểm tra xem có dữ liệu không

```php
public function index()
{
    $perPage = $this->getPerPage(10);
    $staffs = $this->staffService->getPaginated($perPage);
    
    // Kiểm tra
    if (!$this->hasData($staffs)) {
        return view('admin.staffs.empty'); // Render trang trống
    }
    
    return view('admin.staffs.index', compact('staffs'));
}
```

---

## 📊 So sánh các chế độ

### **Chế độ `'abort'` (Throw 404)**
- ✅ Người dùng biết trang không tồn tại
- ✅ Chuẩn RESTful API
- ❌ Hiển thị error page 404
- **Dùng khi:** Muốn strict validation

```
/admin/staffs?page=999
    ↓
404 Not Found
"Trang 999 không tồn tại. Chỉ có 5 trang."
```

### **Chế độ `'redirect'` (Redirect)**
- ✅ Người dùng vẫn thấy dữ liệu
- ✅ UX tốt hơn
- ❌ Ẩn lỗi từ người dùng
- **Dùng khi:** Muốn user-friendly

```
/admin/staffs?page=999
    ↓
Redirect to /admin/staffs?page=5
    ↓
Hiển thị trang 5
```

---

## 🔐 Bảo mật

### Chống tấn công:
```
/admin/staffs?page=9999999999    → ❌ 404 hoặc Redirect
/admin/staffs?page=abc           → ✅ OK (convert to 1)
/admin/staffs?page=-999          → ✅ OK (convert to 1)
/admin/staffs?page=0             → ✅ OK (convert to 1)
```

---

## 📝 Method tổng hợp trong Trait

```php
// Lấy per_page (có validation)
$perPage = $this->getPerPage(10);

// Lấy page hiện tại
$currentPage = $this->getCurrentPage(1);

// Validate page dựa trên lastPage (NEW!)
$this->validatePageNumber($currentPage, $lastPage, 'abort');

// Kiểm tra có dữ liệu không
$hasData = $this->hasData($collection);
```

---

## 🎯 Áp dụng cho các controller khác

```php
class MyController extends Controller
{
    use PaginationTrait;
    
    public function index()
    {
        $perPage = $this->getPerPage(10);
        $data = $this->service->getPaginated($perPage);
        
        // Validate page
        $this->validatePageNumber($data->currentPage(), $data->lastPage(), 'abort');
        
        // Check data
        if (!$this->hasData($data)) {
            return view('empty');
        }
        
        return view('index', compact('data'));
    }
}
```

---

## ✅ Controllers đã áp dụng

- ✅ **StaffController** - mode: `'abort'`
- ✅ **RoleController** - mode: `'abort'`

---

## 💡 Edge Cases xử lý

| Case | Kết quả |
|------|--------|
| `page > lastPage` | Abort 404 hoặc Redirect |
| `page = 0` | Convert to page 1 ✅ |
| `page < 0` | Convert to page 1 ✅ |
| `lastPage = 0` (no data) | Abort 404 |
| `per_page = invalid` | Convert to default ✅ |

---

## 🔔 Lưu ý

1. **Luôn validate page** sau khi gọi `getPaginated()`
2. **Chọn mode phù hợp:**
   - `'abort'` = Strict (API)
   - `'redirect'` = User-friendly (Web)
3. **Kiểm tra dữ liệu rỗng** nếu cần render trang khác
