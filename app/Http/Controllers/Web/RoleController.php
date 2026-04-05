<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
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
        $this->roleService->create($request->validated());
        return redirect()->route('roles.index')->with('success', 'Tạo vai trò thành công!');
    }

    public function edit($id): View
    {
        $role = $this->roleService->findById($id);
        return view('admin.roles.edit', compact('role'));
    }

    public function update(StoreRoleRequest $request, $id): RedirectResponse
    {
        $this->roleService->update($id, $request->validated());
        return redirect()->route('roles.index')->with('success', 'Cập nhật vai trò thành công!');
    }

    public function destroy($id): RedirectResponse
    {
        $this->roleService->delete($id);
        return redirect()->route('roles.index')->with('success', 'Xóa vai trò thành công!');
    }
}