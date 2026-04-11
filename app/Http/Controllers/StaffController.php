<?php
namespace App\Http\Controllers;
use App\Http\Requests\Staff\StoreStaffRequest;
use App\Http\Requests\Staff\UpdateStaffRequest;
use App\Services\Contracts\RoleServiceInterface;
use App\Services\Contracts\StaffServiceInterface;


class StaffController extends Controller
{
    protected $staffService;
    protected $roleService;
    public function __construct(StaffServiceInterface $staffService, RoleServiceInterface $roleService)
    {
        $this->staffService = $staffService;
        $this->roleService = $roleService;
    }

    public function index()
    {
        $staffs = $this->staffService->getAll();
        return view('admin.staffs.index', compact('staffs'));
    }

    public function create()
    {
        $roles = $this->roleService->getAll(); 
        return view('admin.staffs.create', compact('roles'));
    }

    public function store(StoreStaffRequest $request)
    {
        try {
            $this->staffService->create($request->validated());
            return redirect()->route('admin.staffs.index')->with('success', 'Tạo nhân viên thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Tạo nhân viên thất bại: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $staff = $this->staffService->findById($id);
        $roles = $this->roleService->getAll();
        return view('admin.staffs.edit', compact('staff', 'roles'));
    }

    public function update($id, UpdateStaffRequest $request)
    {
        try {
            $this->staffService->update($id, $request->validated());
            return redirect()->route('admin.staffs.index')->with('success', 'Cập nhật nhân viên thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật nhân viên thất bại: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->staffService->delete($id);
            return redirect()->route('admin.staffs.index')->with('success', 'Xóa nhân viên thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa nhân viên thất bại: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        try {
            $isActive = request()->input('is_active');
            $this->staffService->update($id, ['is_active' => $isActive]);
            
            $message = $isActive 
                ? 'Kích hoạt nhân viên thành công!' 
                : 'Vô hiệu hóa nhân viên thành công!';
            
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cập nhật trạng thái thất bại: ' . $e->getMessage()
            ], 500);
        }
    }

}