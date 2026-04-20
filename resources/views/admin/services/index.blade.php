@extends('admin.layouts.master')

@section('title', 'Quản lý dịch vụ | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/services.css')
@endpush

@section('content')
<div style="display:flex; height:100vh; background:#f5f6fa;">

    {{-- SIDEBAR --}}
    @include('admin.layouts.sidebar')

    {{-- CONTENT --}}
    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

        {{-- HEADER --}}
        <header style="height:64px; background:#fff; border-bottom:1px solid #f1f3f7; padding:0 32px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0; box-shadow:0 1px 4px rgba(0,0,0,.04);">
            <div style="display:flex; align-items:center; gap:8px; font-size:14px; font-weight:600; color:#1e293b; cursor:pointer;">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                16819 &middot; Urban Luxe Hotel
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div style="display:flex; align-items:center; gap:18px;">
                <div style="text-align: right;">
                    <span style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase;">Ngày làm việc</span>
                    <div style="font-size:13px; font-weight:700; color:#1e293b;">24 Tháng 05, 2024</div>
                </div>
                <button style="position:relative; width:36px; height:36px; border:none; background:#f1f5f9; cursor:pointer; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#64748b;">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                    <span style="position:absolute; top:8px; right:8px; width:6px; height:6px; background:#ef4444; border-radius:50%;"></span>
                </button>
                <div style="width:36px; height:36px; border-radius:10px; background:#dcfce7; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=dcfce7&color=16a34a&size=80" style="width:100%; height:100%; object-fit:cover;" alt="Admin User">
                </div>
            </div>
        </header>

        {{-- MAIN CONTENT --}}
        <div style="flex:1; overflow-y:auto; padding:32px; display:flex; flex-direction:column; background:#f8fafc;">
            
            <div class="sv-container">
                @if ($message = Session::get('success'))
                    <div style="margin-bottom: 16px; padding: 12px 16px; background: #dcfce7; border: 1px solid #86efac; border-radius: 8px; color: #166534; font-weight: 500;">
                        ✓ {{ $message }}
                    </div>
                @endif
                @if ($message = Session::get('error'))
                    <div style="margin-bottom: 16px; padding: 12px 16px; background: #fee2e2; border: 1px solid #fecaca; border-radius: 8px; color: #991b1b; font-weight: 500;">
                        ✕ {{ $message }}
                    </div>
                @endif
                <div class="sv-header">
                    <div>
                        <h1 class="sv-title">Quản lý dịch vụ</h1>
                        <p class="sv-subtitle">Hệ thống quản trị khách sạn Urban Luxe - Quản lý danh mục dịch vụ dựa trên mô hình dữ liệu.</p>
                    </div>
                    <a href="{{ route('admin.services.create') }}" class="sv-btn-primary" style="text-decoration: none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                        Thêm dịch vụ mới
                    </a>
                </div>

                <div class="sv-toolbar">
                    <form method="GET" action="{{ route('admin.services.index') }}" style="display: flex; align-items: center; gap: 12px; flex: 1;">
                        <div class="sv-search-wrapper">
                            <div class="sv-search-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            </div>
                            <input type="text" name="filter[search]" class="sv-search-input" placeholder="Tìm tên dịch vụ..." value="{{ request('filter.search') }}" onkeyup="if(event.key==='Enter') this.form.submit();">
                        </div>
                        
                        <select class="sv-select" name="filter[group_id]" onchange="this.form.submit();">
                            <option value="">Nhóm dịch vụ (Tất cả)</option>
                            @foreach($serviceGroups as $group)
                            <option value="{{ $group->id }}" {{ request('filter.group_id') == $group->id ? 'selected' : '' }}>{{ $group->service_name }}</option>
                            @endforeach
                        </select>

                        <button class="sv-btn-action" type="button" style="color: #94a3b8;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        </button>
                    </form>
                </div>

                <div class="sv-table-wrapper">
                    <table class="sv-table">
                        <thead>
                            <tr>
                                <th>MÃ DỊCH VỤ (ID)</th>
                                <th>TÊN DỊCH VỤ (NAME)</th>
                                <th>NHÓM DỊCH VỤ (SERVICE NAME)</th>
                                <th>ĐƠN GIÁ (UNIT PRICE)</th>
                                <th>ĐƠN VỊ TÍNH (UNIT)</th>
                                <th style="text-align: right;">THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $item)
                            <tr>
                                <td class="sv-id">{{ $item->id }}</td>
                                <td class="sv-name-main">{{ $item->name }}</td>
                                <td>{{ $item->group ? $item->group->service_name : 'N/A' }}</td>
                                <td class="sv-price">{{ number_format($item->unit_price, 0, ',', '.') }} VNĐ</td>
                                <td>{{ $item->unit }}</td>
                                <td>
                                    <div class="sv-actions">
                                        <a href="{{ route('admin.services.edit', $item->id) }}" class="sv-btn-action edit" title="Chỉnh sửa">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.services.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="sv-btn-action delete" title="Xóa" style="border:none; cursor:pointer; background:none;">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <x-pagination :paginator="$services" />
            </div>

        {{-- FOOTER --}}
        @include('admin.layouts.footer')

    </main>
</div>
@endsection