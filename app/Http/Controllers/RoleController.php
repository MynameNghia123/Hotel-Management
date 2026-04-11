<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Services\Contracts\RoleServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleServiceInterface $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index(): View
    {
        $roles = $this->roleService->getAll();
        return view('admin.roles.index', compact('roles'));
    }

    public function create(): View
    {
        return view('admin.roles.create');
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        try {
            $this->roleService->create($request->mapped());
            return redirect()->route('admin.roles.index')->with('success', 'Tạo vai trò thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Tạo vai trò thất bại: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id): View
    {
        $role = $this->roleService->findById($id);
        return view('admin.roles.edit', compact('role'));
    }

    public function update(StoreRoleRequest $request, $id): RedirectResponse
    {
        try {
            $this->roleService->update($id, $request->mapped());
            return redirect()->route('admin.roles.index')->with('success', 'Cập nhật vai trò thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật vai trò thất bại: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $this->roleService->delete($id);
            return redirect()->route('admin.roles.index')->with('success', 'Xóa vai trò thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.roles.index')->with('error', 'Xóa vai trò thất bại: ' . $e->getMessage());
        }
    }
}