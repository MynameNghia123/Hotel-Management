@extends('admin.layouts.master')

@section('title', 'Thêm khách hàng | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/customers-create.css')
@endpush

@section('content')
<div class="cs-layout">
    @include('admin.layouts.sidebar')
    
    <main class="cs-main">
        @include('admin.layouts.header')
        
        <div class="cs-content-area">
            <div class="cs-card">
                <h2 class="cs-card-title">Thêm khách hàng mới</h2>
                
                <form action="{{ route('admin.customers.store') }}" method="POST">
                    @csrf
                    <div class="cs-form-row">
                        <div>
                            <label class="cs-form-label">Họ (Last Name) <span style="color:#ef4444">*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" class="cs-form-input" placeholder="Vd: Nguyễn">
                            @error('last_name') <span class="cs-error">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="cs-form-label">Tên (First Name) <span style="color:#ef4444">*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" class="cs-form-input" placeholder="Vd: Minh Anh">
                            @error('first_name') <span class="cs-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="cs-form-row">
                        <div>
                            <label class="cs-form-label">Số điện thoại <span style="color:#ef4444">*</span></label>
                            <input type="text" name="phone_number" value="{{ old('phone_number') }}" class="cs-form-input" placeholder="Vd: 0901234567">
                            @error('phone_number') <span class="cs-error">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="cs-form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="cs-form-input" placeholder="Vd: khachhang@gmail.com">
                            @error('email') <span class="cs-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="cs-form-group">
                        <label class="cs-form-label">Quốc gia</label>
                        <input type="text" name="country" value="{{ old('country', 'Việt Nam') }}" class="cs-form-input" placeholder="Vd: Việt Nam, Hoa Kỳ...">
                        @error('country') <span class="cs-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="cs-actions">
                        <a href="{{ route('admin.customers.index') }}" class="cs-btn-back">Hủy bỏ</a>
                        <button type="submit" class="cs-btn-submit">Lưu khách hàng</button>
                    </div>
                </form>
            </div>
        </div>
        
        @include('admin.layouts.footer')
    </main>
</div>
@endsection
