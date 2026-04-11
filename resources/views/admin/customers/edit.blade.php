@extends('admin.layouts.master')

@section('title', 'Chỉnh sửa khách hàng | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/customers-create.css')
@endpush

@section('content')
<div class="cs-layout">
    @include('admin.layouts.sidebar')
    
    <main class="cs-main">
        @include('admin.layouts.header')
        
        <div class="cs-content-area" style="padding: 32px; background: #f8fafc; flex: 1; overflow-y: auto;">
            <div style="max-width: 800px; margin: 0 auto; background: #fff; padding: 32px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #f1f3f7;">
                <hgroup style="margin-bottom: 24px;">
                    <h2 style="margin-top: 0; font-size: 20px; color: #1e293b; margin-bottom: 4px; font-weight: 700;">Chỉnh sửa thông tin khách hàng</h2>
                    <p style="color: #64748b; font-size: 13px; margin: 0;">Mã khách hàng: CUS-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</p>
                </hgroup>
                
                <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 14px;">Họ (Last Name) <span style="color:#ef4444">*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name', $customer->last_name) }}" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none;" placeholder="Vd: Nguyễn">
                            @error('last_name') <span style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 14px;">Tên (First Name) <span style="color:#ef4444">*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name', $customer->first_name) }}" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none;" placeholder="Vd: Minh Anh">
                            @error('first_name') <span style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 14px;">Số điện thoại <span style="color:#ef4444">*</span></label>
                            <input type="text" name="phone_number" value="{{ old('phone_number', $customer->phone_number) }}" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none;" placeholder="Vd: 0901234567">
                            @error('phone_number') <span style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 14px;">Email</label>
                            <input type="email" name="email" value="{{ old('email', $customer->email) }}" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none;" placeholder="Vd: khachhang@gmail.com">
                            @error('email') <span style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 14px;">Quốc gia</label>
                        <input type="text" name="country" value="{{ old('country', $customer->country) }}" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none;" placeholder="Vd: Việt Nam, Hoa Kỳ...">
                        @error('country') <span style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 32px; border-top: 1px solid #f1f3f7; padding-top: 24px;">
                        <a href="{{ route('admin.customers.index') }}" style="padding: 10px 20px; border-radius: 10px; background: #fff; border: 1px solid #e2e8f0; color: #64748b; font-weight: 600; text-decoration: none; font-size: 14px;">Hủy bỏ</a>
                        <button type="submit" style="padding: 10px 24px; border-radius: 10px; background: #2a3f8a; color: #fff; border: none; font-weight: 600; cursor: pointer; font-size: 14px; box-shadow: 0 4px 12px rgba(42, 63, 138, 0.2);">Cập nhật ngay</button>
                    </div>
                </form>
            </div>
        </div>
        
        @include('admin.layouts.footer')
    </main>
</div>
@endsection
