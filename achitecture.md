src/ (hoặc app/)
│
├── Http/ (hoặc Controllers/)       <-- Tầng Giao tiếp (Presentation)
│   ├── Controllers/
│   │   ├── AuthController
│   │   ├── RoomController
│   │   └── BookingController       # Chỉ nhận Request, gọi Service, trả về Response/View
│   │
│   └── Requests/ (hoặc DTOs/)      # Chứa các class validate dữ liệu đầu vào (VD: Validate số CCCD, ngày check-in)
│       └── StoreBookingRequest
│
├── Services/                       <-- Tầng Nghiệp vụ (Business Logic)
│   ├── Interfaces/
│   │   └── BookingServiceInterface
│   └── Implements/
│       └── BookingService          # Xử lý logic tính tiền, check phòng trống, áp mã giảm giá...
│
├── Repositories/                   <-- Tầng Truy xuất dữ liệu (Data Access)
│   ├── Contracts/ (Interfaces)
│   │   ├── RoomRepositoryInterface
│   │   └── BookingRepositoryInterface
│   └── Eloquent/ (hoặc Implements/)
│       ├── RoomRepository          # Nơi duy nhất chứa các câu query database (SQL/ORM)
│       └── BookingRepository
│
├── Models/ (hoặc Entities/)        <-- Tầng Dữ liệu cốt lõi
│   ├── User
│   ├── Room                        # Đại diện cho cấu trúc bảng trong Database
│   └── Booking
│
└── Providers/ (hoặc Config/)       <-- Cấu hình Dependency Injection (DI)
    └── RepositoryServiceProvider   # Nơi "đăng ký" Interface nào sẽ chạy Class nào.

---

## 📌 Ví dụ thực tế: Quản lý Học Sinh

### 1. Model — `app/Models/Student.php`
> Đại diện bảng `students` trong DB. Chỉ khai báo cấu trúc, KHÔNG chứa logic.

```php
class Student extends Model {
    protected $fillable = ['name', 'email', 'class_id', 'date_of_birth'];

    public function class(): BelongsTo {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
```

---

### 2. Repository Interface — `app/Repositories/Contracts/StudentRepositoryInterface.php`
> Bản hợp đồng: "Repository học sinh phải có những method nào?"

```php
interface StudentRepositoryInterface extends BaseRepositoryInterface {
    public function getStudentsByClass(int $classId): Collection;
    public function searchByName(string $keyword): Collection;
}
```

### 2b. Repository Implementation — `app/Repositories/Eloquent/EloquentStudentRepository.php`
> Nơi viết code query DB thực tế. Đây là nơi DUY NHẤT được phép gọi Eloquent/SQL.

```php
class EloquentStudentRepository extends BaseRepository implements StudentRepositoryInterface {

    public function __construct(Student $model) {
        parent::__construct($model);
    }

    // Lấy học sinh theo lớp — chỉ là query, không có "if", không có rule nghiệp vụ
    public function getStudentsByClass(int $classId): Collection {
        return $this->model->where('class_id', $classId)->with('class')->get();
    }

    // Tìm kiếm theo tên — chỉ là query
    public function searchByName(string $keyword): Collection {
        return $this->model->where('name', 'LIKE', "%{$keyword}%")->get();
    }
}
```

---

### 3. Service Interface — `app/Services/Contracts/StudentServiceInterface.php`
> Bản hợp đồng: "Service học sinh phải xử lý nghiệp vụ nào?"

```php
interface StudentServiceInterface {
    public function enrollStudent(array $data): Model;   // Đăng ký học sinh mới
    public function transferClass(int $studentId, int $newClassId): bool; // Chuyển lớp
    public function getStudentsByClass(int $classId): Collection;
}
```

### 3b. Service Implementation — `app/Services/StudentService.php`
> Nơi xử lý NGHIỆP VỤ. Gọi Repository để lấy data, nhưng tự quyết định "làm gì với data đó".

```php
class StudentService implements StudentServiceInterface {

    public function __construct(
        private readonly StudentRepositoryInterface $studentRepository,
        private readonly SchoolClassRepositoryInterface $classRepository,
    ) {}

    // Nghiệp vụ: Đăng ký học sinh — kiểm tra lớp còn chỗ không trước khi tạo
    public function enrollStudent(array $data): Model {
        $class = $this->classRepository->findById($data['class_id']);

        // ← ĐÂY là business logic, Repository không biết rule này
        if ($class->current_students >= $class->max_capacity) {
            throw new Exception('Lớp đã đủ số lượng học sinh tối đa!');
        }

        return DB::transaction(function () use ($data, $class) {
            $student = $this->studentRepository->create($data);
            $this->classRepository->incrementStudentCount($class->id); // cập nhật sĩ số
            return $student;
        });
    }

    // Nghiệp vụ: Chuyển lớp — giảm sĩ số lớp cũ, tăng lớp mới
    public function transferClass(int $studentId, int $newClassId): bool {
        $student = $this->studentRepository->findById($studentId);

        return DB::transaction(function () use ($student, $newClassId) {
            $this->classRepository->decrementStudentCount($student->class_id);
            $this->classRepository->incrementStudentCount($newClassId);
            return $this->studentRepository->update($student->id, ['class_id' => $newClassId]);
        });
    }

    // Delegate đơn giản — không có logic đặc biệt
    public function getStudentsByClass(int $classId): Collection {
        return $this->studentRepository->getStudentsByClass($classId);
    }
}
```

---

### 4. Form Request — `app/Http/Requests/StoreStudentRequest.php`
> Validate dữ liệu đầu vào. Controller nhận cái này thay vì `Request` thông thường.

```php
class StoreStudentRequest extends FormRequest {
    public function rules(): array {
        return [
            'name'          => ['required', 'string', 'max:100'],
            'email'         => ['required', 'email', 'unique:students,email'],
            'class_id'      => ['required', 'exists:school_classes,id'],
            'date_of_birth' => ['required', 'date', 'before:today'],
        ];
    }
}
```

---

### 5. Controller — `app/Http/Controllers/Web/StudentController.php`
> Mỏng nhất có thể. Chỉ nhận request → gọi service → trả view/redirect.

```php
class StudentController extends Controller {

    public function __construct(
        private readonly StudentServiceInterface $studentService,
    ) {}

    // Validate xong tự động (nhờ StoreStudentRequest), chỉ cần gọi service
    public function store(StoreStudentRequest $request): RedirectResponse {
        $student = $this->studentService->enrollStudent($request->validated());
        return redirect()->route('students.show', $student->id)->with('success', 'Đăng ký học sinh thành công!');
    }

    public function transferClass(Request $request, int $id): RedirectResponse {
        $this->studentService->transferClass($id, $request->input('new_class_id'));
        return back()->with('success', 'Chuyển lớp thành công!');
    }
}
```

---

### 6. Đăng ký vào Provider — `app/Providers/RepositoryServiceProvider.php`
> Bước cuối bắt buộc: báo cho Laravel biết Interface nào → Class nào.

```php
public function register(): void {
    $this->app->bind(StudentRepositoryInterface::class, EloquentStudentRepository::class);
    $this->app->bind(StudentServiceInterface::class,    StudentService::class);
}
```

---

## 🔁 Tóm tắt luồng dữ liệu

```
[Request POST /students]
        ↓
StoreStudentRequest::rules()   ← validate: name, email, class_id hợp lệ?
        ↓ (pass)
StudentController::store()     ← nhận $request->validated(), gọi service
        ↓
StudentService::enrollStudent() ← kiểm tra: lớp còn chỗ không? wrap transaction
        ↓
EloquentStudentRepository::create()  ← INSERT INTO students ...
ClassRepository::incrementStudentCount()  ← UPDATE school_classes SET current_students+1
        ↓
Response: redirect về trang chi tiết học sinh
```