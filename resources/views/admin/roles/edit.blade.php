@extends('admin.layouts.master')

@section('title', 'Chỉnh sửa vai trò | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/staff-roles.css')
@endpush

@push('scripts')
    @vite('resources/js/admin/roles-permissions.js')
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
            @if ($errors->any())
                <div style="color: red; background: #fee2e2; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="sr-container">
                <div style="margin-bottom: 24px;">
                    <a href="{{ route('admin.roles.index') }}" style="color:#64748b; font-size:14px;">&larr; Quay lại danh sách</a>
                    <h1 class="sr-title" style="margin-top:8px;">Thông tin vai trò</h1>
                    <p class="sr-subtitle">Thiết lập chi tiết quyền hạn cho vai trò người dùng trong hệ thống.</p>
                </div>
                <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                    @csrf
                    @method('PUT')
                    <div style="margin-bottom: 24px;">
                        <label for="role_name" style="font-weight:600;">TÊN VAI TRÒ <span style="color:#ef4444;">*</span></label>
                        <input id="role_name" name="role_name" type="text" class="i" placeholder="Nhập tên vai trò" value="{{ $role->name }}" required style="margin-top:8px; width:100%; max-width: 400px; background: #f3f4f6; border: 1px solid #e5e7eb; padding: 12px; border-radius: 8px; font-size: 14px; color: #1f2937;">
                    </div>
                    @php
                        // Tạo array các quyền đã chọn
                        $selectedPermissions = $role->roleClaims->map(function($claim) {
                            return $claim->claim_name . '.' . $claim->claim_value;
                        })->toArray();
                    @endphp
                    <div>
                        {{-- Bảng phân quyền --}}
                        <table class="sr-table" style="width: 100%; border-collapse: collapse; margin-bottom: 24px;">
                            <thead>
                                <tr style="background: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #64748b;">
                                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                            <input type="checkbox" id="selectAllPermissions" style="cursor: pointer;">
                                            <span>DANH SÁCH PHÂN QUYỀN</span>
                                        </label>
                                    </th>
                                    <th style="padding: 12px; text-align: center; font-weight: 600; color: #64748b; width: 80px;">XEM</th>
                                    <th style="padding: 12px; text-align: center; font-weight: 600; color: #64748b; width: 80px;">THÊM</th>
                                    <th style="padding: 12px; text-align: center; font-weight: 600; color: #64748b; width: 80px;">SỬA</th>
                                    <th style="padding: 12px; text-align: center; font-weight: 600; color: #64748b; width: 80px;">XÓA</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Vận hành --}}
                                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                    <td colspan="5" style="padding: 12px; font-weight: 600; color: #3b82f6; font-size: 12px;">
                                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                            <input type="checkbox" data-category-select="operations" style="cursor: pointer;">
                                            <span>VĂN HÀNH</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px;">Sơ đồ phòng</td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="room-map.view" data-category="operations" {{ in_array('room-map.view', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="room-map.create" data-category="operations" {{ in_array('room-map.create', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="room-map.edit" data-category="operations" {{ in_array('room-map.edit', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="room-map.delete" data-category="operations" {{ in_array('room-map.delete', $selectedPermissions) ? 'checked' : '' }}></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px;">Chỉnh sửa sơ đồ phòng</td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="room-map-edit.view" data-category="operations" {{ in_array('room-map-edit.view', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="room-map-edit.create" data-category="operations" {{ in_array('room-map-edit.create', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="room-map-edit.edit" data-category="operations" {{ in_array('room-map-edit.edit', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="room-map-edit.delete" data-category="operations" {{ in_array('room-map-edit.delete', $selectedPermissions) ? 'checked' : '' }}></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px;">Quản lý đặt phòng</td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="bookings.view" data-category="operations" {{ in_array('bookings.view', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="bookings.create" data-category="operations" {{ in_array('bookings.create', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="bookings.edit" data-category="operations" {{ in_array('bookings.edit', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="bookings.delete" data-category="operations" {{ in_array('bookings.delete', $selectedPermissions) ? 'checked' : '' }}></td>
                                </tr>

                                {{-- Quản lý phòng --}}
                                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                    <td colspan="5" style="padding: 12px; font-weight: 600; color: #3b82f6; font-size: 12px;">
                                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                            <input type="checkbox" data-category-select="rooms" style="cursor: pointer;">
                                            <span>QUẢN LÝ PHÒNG</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px;">Danh sách phòng</td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="rooms.view" data-category="rooms" {{ in_array('rooms.view', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="rooms.create" data-category="rooms" {{ in_array('rooms.create', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="rooms.edit" data-category="rooms" {{ in_array('rooms.edit', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="rooms.delete" data-category="rooms" {{ in_array('rooms.delete', $selectedPermissions) ? 'checked' : '' }}></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px;">Loại phòng</td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="room-types.view" data-category="rooms" {{ in_array('room-types.view', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="room-types.create" data-category="rooms" {{ in_array('room-types.create', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="room-types.edit" data-category="rooms" {{ in_array('room-types.edit', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="room-types.delete" data-category="rooms" {{ in_array('room-types.delete', $selectedPermissions) ? 'checked' : '' }}></td>
                                </tr>

                                {{-- Quản lý tài sản --}}
                                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                    <td colspan="5" style="padding: 12px; font-weight: 600; color: #3b82f6; font-size: 12px;">
                                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                            <input type="checkbox" data-category-select="assets" style="cursor: pointer;">
                                            <span>QUẢN LÝ TÀI SẢN</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px;">Trang thiết bị</td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="equipment.view" data-category="assets" {{ in_array('equipment.view', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="equipment.create" data-category="assets" {{ in_array('equipment.create', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="equipment.edit" data-category="assets" {{ in_array('equipment.edit', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="equipment.delete" data-category="assets" {{ in_array('equipment.delete', $selectedPermissions) ? 'checked' : '' }}></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px;">Phiếu sửa chữa</td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="repair-ticket.view" data-category="assets" {{ in_array('repair-ticket.view', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="repair-ticket.create" data-category="assets" {{ in_array('repair-ticket.create', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="repair-ticket.edit" data-category="assets" {{ in_array('repair-ticket.edit', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="repair-ticket.delete" data-category="assets" {{ in_array('repair-ticket.delete', $selectedPermissions) ? 'checked' : '' }}></td>
                                </tr>

                                {{-- Khách hàng --}}
                                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                    <td colspan="5" style="padding: 12px; font-weight: 600; color: #3b82f6; font-size: 12px;">
                                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                            <input type="checkbox" data-category-select="customers" style="cursor: pointer;">
                                            <span>KHÁCH HÀNG</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px;">Quản lý khách hàng</td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="customers.view" data-category="customers" {{ in_array('customers.view', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="customers.create" data-category="customers" {{ in_array('customers.create', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="customers.edit" data-category="customers" {{ in_array('customers.edit', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="customers.delete" data-category="customers" {{ in_array('customers.delete', $selectedPermissions) ? 'checked' : '' }}></td>
                                </tr>

                                {{-- Dịch vụ & Tiện ích --}}
                                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                    <td colspan="5" style="padding: 12px; font-weight: 600; color: #3b82f6; font-size: 12px;">
                                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                            <input type="checkbox" data-category-select="services" style="cursor: pointer;">
                                            <span>DỊCH VỤ & TIỆN ÍCH</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px;">Quản lý dịch vụ</td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="services.view" data-category="services" {{ in_array('services.view', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="services.create" data-category="services" {{ in_array('services.create', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="services.edit" data-category="services" {{ in_array('services.edit', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="services.delete" data-category="services" {{ in_array('services.delete', $selectedPermissions) ? 'checked' : '' }}></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px;">Quản lý tiện ích</td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="amenities.view" data-category="services" {{ in_array('amenities.view', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="amenities.create" data-category="services" {{ in_array('amenities.create', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="amenities.edit" data-category="services" {{ in_array('amenities.edit', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="amenities.delete" data-category="services" {{ in_array('amenities.delete', $selectedPermissions) ? 'checked' : '' }}></td>
                                </tr>

                                {{-- Hệ thống --}}
                                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                    <td colspan="5" style="padding: 12px; font-weight: 600; color: #3b82f6; font-size: 12px;">
                                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                            <input type="checkbox" data-category-select="system" style="cursor: pointer;">
                                            <span>HỆ THỐNG</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px;">Quản lý nhân viên</td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="employees.view" data-category="system" {{ in_array('employees.view', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="employees.create" data-category="system" {{ in_array('employees.create', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="employees.edit" data-category="system" {{ in_array('employees.edit', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="employees.delete" data-category="system" {{ in_array('employees.delete', $selectedPermissions) ? 'checked' : '' }}></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px;">Quản lý vai trò</td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="roles.view" data-category="system" {{ in_array('roles.view', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="roles.create" data-category="system" {{ in_array('roles.create', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="roles.edit" data-category="system" {{ in_array('roles.edit', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="roles.delete" data-category="system" {{ in_array('roles.delete', $selectedPermissions) ? 'checked' : '' }}></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px;">Cấu hình chung</td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="configuration.view" data-category="system" {{ in_array('configuration.view', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="configuration.create" data-category="system" {{ in_array('configuration.create', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="configuration.edit" data-category="system" {{ in_array('configuration.edit', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="configuration.delete" data-category="system" {{ in_array('configuration.delete', $selectedPermissions) ? 'checked' : '' }}></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px;">Thống kê</td>
                                    <td style="padding: 12px; text-align: center;"><input type="checkbox" name="permissions[]" value="statistical.view" data-category="system" {{ in_array('statistical.view', $selectedPermissions) ? 'checked' : '' }}></td>
                                    <td style="padding: 12px; text-align: center;"></td>
                                    <td style="padding: 12px; text-align: center;"></td>
                                    <td style="padding: 12px; text-align: center;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top:32px; display:flex; gap:12px;">
                        <a href="{{ route('admin.roles.index') }}" class="sr-btn-secondary" style="text-decoration:none; padding:10px 16px; border-radius:8px;">Hủy</a>
                        <button type="submit" class="sr-btn-primary">Cập nhật vai trò</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- FOOTER --}}
        @include('admin.layouts.footer')
    </main>
</div>
@endsection