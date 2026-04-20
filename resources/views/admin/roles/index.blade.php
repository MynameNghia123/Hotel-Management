@extends('admin.layouts.master')

@section('title', 'Quản lý vai trò | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/staff-roles.css')
@endpush

@section('content')
<div style="display:flex; height:100vh; background:#f5f6fa;">

    {{-- SIDEBAR --}}
    @include('admin.layouts.sidebar')

    {{-- CONTENT --}}
    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

        {{-- HEADER --}}
        @include('admin.layouts.header')

        {{-- MAIN CONTENT --}}
        <div style="flex:1; overflow-y:auto; padding:32px; display:flex; flex-direction:column; background:#f8fafc;">
            
            @if ($message = Session::get('success'))
                <div style="margin-bottom: 16px; padding: 12px 16px; background: #dcfce7; border: 1px solid #86efac; border-radius: 8px; color: #166534; font-weight: 500;">
                    ✓ {{ $message }}
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div style="margin-bottom: 16px; padding: 12px 16px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; color: #991b1b; font-weight: 500; animation: slideInDown 0.3s ease;">
                    ✕ {{ $message }}
                </div>
            @endif
            <div class="sr-container">
                <div class="sr-header">
                    <div>
                        <h1 class="sr-title">Quản lý vai trò</h1>
                        <p class="sr-subtitle">Hệ thống quản trị khách sạn Urban Luxe - Quản lý phân quyền và vai trò người dùng (Roles).</p>
                    </div>
                    <button class="sr-btn-primary" onclick="window.location.href='{{ route('admin.roles.create') }}'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 00-3-3.87"></path><path d="M16 3.13a4 4 0 010 7.75"></path></svg>
                        Thêm vai trò mới
                    </button>
                </div>

                <div class="sr-toolbar">
                    <form method="GET" action="{{ route('admin.roles.index') }}" style="display: flex; align-items: center; gap: 12px; flex: 1;">
                        <div class="sr-search-wrapper">
                            <div class="sr-search-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            </div>
                            <input type="text" name="filter[search]" class="sr-search-input" placeholder="Tìm tên vai trò hoặc id ..." value="{{ request('filter.search') }}" onkeyup="if(event.key==='Enter') this.form.submit();">
                        </div>
                    </form>
                    
                    <button class="sr-btn-filter">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        Lọc cơ bản
                    </button>
                </div>

                <div class="sr-table-wrapper">
                    <table class="sr-table">
                        <thead>
                            <tr>
                                <th>MÃ VAI TRÒ (ID)</th>
                                <th>TÊN VAI TRÒ (ROLE NAME)</th>
                                <th>SỐ NHÂN VIÊN (STAFF COUNT)</th>
                                <th>TRẠNG THÁI (STATUS)</th>
                                <th style="text-align: right;">THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                            <tr>
                                <td class="sr-id">{{ $role->id }}</td>
                                <td>
                                    <div class="sr-role-main">
                                        <div class="sr-role-dot" style="background: #3b82f6;"></div>
                                        <div class="sr-role-name">{{ $role->name }}</div>
                                    </div>
                                </td>
                                <td class="sr-staff-count">0</td>
                                <td>
                                    <span class="sr-status-badge">ĐANG KÍCH HOẠT</span>
                                </td>
                                <td>
                                    <div class="sr-actions">

                                        <button class="sr-btn-action edit" title="Chỉnh sửa" onclick="window.location.href='{{ route('admin.roles.edit', $role->id) }}'">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>
                                        <button class="sr-btn-action delete" title="Xóa" data-toggle="modal" data-target="#deleteModal" data-role-id="{{ $role->id }}" data-role-name="{{ $role->name }}">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        </button>
                                        <form id="delete-form-{{ $role->id }}" action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 24px; color: #64748b;">Không có vai trò nào</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Component -->
                <x-pagination :paginator="$roles" />
            </div>

        {{-- FOOTER --}}
        @include('admin.layouts.footer')

    </main>
</div>

<!-- Modal Xóa Vai Trò -->
<div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; padding: 32px; max-width: 400px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        <div style="margin-bottom: 24px;">
            <h2 style="font-size: 20px; font-weight: 700; color: #1f2937; margin-bottom: 8px;">Xác nhận xóa vai trò</h2>
            <p style="color: #6b7280; font-size: 14px;">Bạn có chắc muốn xóa vai trò <strong id="deleteRoleName">Admin</strong> này? Hành động này không thể hoàn tác.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <button type="button" onclick="closeDeleteModal()" style="flex: 1; padding: 10px 16px; border: 1px solid #e5e7eb; border-radius: 8px; background: white; color: #6b7280; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                Hủy
            </button>
            <button type="button" onclick="confirmDelete()" id="deleteConfirmBtn" style="flex: 1; padding: 10px 16px; border: none; border-radius: 8px; background: #ef4444; color: white; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                <span id="deleteButtonText">Xóa vai trò</span>
            </button>
        </div>
    </div>
</div>

<script>
    let deleteRoleId = null;

    // Khi click nút xóa, hiển thị modal
    document.querySelectorAll('.sr-btn-action.delete').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            deleteRoleId = this.getAttribute('data-role-id');
            const roleName = this.getAttribute('data-role-name');
            document.getElementById('deleteRoleName').textContent = roleName;
            document.getElementById('deleteModal').style.display = 'flex';
        });
    });

    // Đóng modal
    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
        deleteRoleId = null;
    }

    // Xác nhận xóa
    function confirmDelete() {
        if (deleteRoleId) {
            const deleteBtn = document.getElementById('deleteConfirmBtn');
            const deleteForm = document.getElementById('delete-form-' + deleteRoleId);
            
            if (deleteBtn && deleteForm) {
                deleteBtn.disabled = true;
                document.getElementById('deleteButtonText').textContent = 'Đang xóa...';
                deleteForm.submit();
            }
        }
    }

    // Đóng modal khi click outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endsection