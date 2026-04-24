@extends('admin.layouts.master')

@section('title', 'Quản lý loại dịch vụ | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/service-types.css')
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

                <div class="st-container">
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
                    <div class="st-header">
                        <div>
                            <h1 class="st-title">Quản lý loại dịch vụ</h1>
                            <p class="st-subtitle">Trang quản lý nhóm dịch vụ (ServiceGroups) cho hệ thống khách sạn Urban
                                Luxe.</p>
                        </div>
                        <a href="{{ route('admin.service-types.create') }}" class="st-btn-primary"
                            style="text-decoration: none;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            Thêm loại dịch vụ
                        </a>
                    </div>

                    <div class="st-toolbar">
                        <div class="st-search-wrapper">
                            <div class="st-search-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </div>
                            <input type="text" class="st-search-input" placeholder="Tìm tên loại dịch vụ hoặc id...">
                        </div>

                        <button class="st-btn-filter">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                            </svg>
                            Bộ lọc
                        </button>
                    </div>

                    <div class="st-table-wrapper">
                        <table class="st-table">
                            <thead>
                                <tr>
                                    <th>MÃ NHÓM (ID)</th>
                                    <th>TÊN NHÓM DỊCH VỤ (SERVICE NAME)</th>
                                    <th style="text-align: right;">THAO TÁC</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($serviceGroups as $item)
                                    <tr>
                                        <td class="st-id">{{ $item->id }}</td>
                                        <td class="st-name-main">{{ $item->service_name }}</td>
                                        <td>
                                            <div class="st-actions">
                                                <a href="{{ route('admin.service-types.edit', $item->id) }}"
                                                    class="st-btn-action edit" title="Chỉnh sửa">
                                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path>
                                                        <path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.service-types.destroy', $item->id) }}"
                                                    method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="st-btn-action delete" title="Xóa"
                                                        style="border:none; cursor:pointer; background:none;">
                                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path
                                                                d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2">
                                                            </path>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <x-pagination :paginator="$serviceGroups" />

                {{-- FOOTER --}}
                @include('admin.layouts.footer')

        </main>
    </div>
@endsection