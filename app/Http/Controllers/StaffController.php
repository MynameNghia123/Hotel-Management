<?php
namespace App\Http\Controllers;
use App\Http\Requests\Staff\StoreStaffRequest;
use App\Http\Requests\Staff\UpdateStaffRequest;
use App\Http\Traits\PaginationTrait;
use App\Services\Contracts\RoleServiceInterface;
use App\Services\Contracts\StaffServiceInterface;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    use PaginationTrait;
    
    public function __construct(
        private readonly StaffServiceInterface $staffService,
        private readonly RoleServiceInterface $roleService
    ) {
    }

    public function index(Request $request)
    {
        $staffs = $this->staffService->getPaginated(
            $request->input('filter', []),
            $request->input('per_page', 10)
        );
        $this->validatePageNumber($staffs->currentPage(), $staffs->lastPage(), 'abort');
        $roles = $this->roleService->getAll();
        
        return view('admin.staffs.index', compact('staffs', 'roles'));
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
            $message = $this->staffService->toggleStatus($id, request()->input('is_active'));

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cập nhật trạng thái thất bại: ' . $e->getMessage()
            ], 500);
        }
    }

}