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
        @include('admin.layouts.header')

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