@extends('admin.layouts.master')

@section('title', 'Đăng nhập Quản trị | Urban Luxe')

@section('content')
<div class="flex min-h-screen bg-white">
    <!-- Hình ảnh bên trái -->
    <div class="hidden lg:block lg:w-[65%] relative overflow-hidden">
        <img src="{{ asset('img/admin.jpg') }}" class="absolute inset-0 w-full h-full object-cover" alt="Admin Background">
        <div class="absolute inset-0 bg-black/40 flex flex-col justify-end p-20">
            <h1 class="text-white text-5xl font-bold mb-6 leading-tight font-['Inter']">Urban Luxe Hotel Management</h1>
            <p class="text-white/80 text-xl max-w-xl leading-relaxed font-light">
                Quản lý khách sạn chuyên nghiệp, nâng tầm trải nghiệm khách hàng với hệ thống quản trị hiện đại và tối ưu bậc nhất.
            </p>
        </div>
    </div>

    <!-- Form đăng nhập bên phải -->
    <div class="w-full lg:w-[35%] flex flex-col justify-center px-8 md:px-16 lg:px-20 bg-white">
        <div class="max-w-md w-full mx-auto">
            <!-- Logo Icon -->
            <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center mb-10 shadow-sm border border-purple-100">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" class="text-purple-600">
                    <rect x="3" y="10" width="8" height="12" fill="currentColor" rx="2" />
                    <rect x="13" y="4" width="8" height="18" fill="currentColor" rx="2" opacity="0.6" />
                </svg>
            </div>

            <h2 class="text-4xl font-extrabold text-gray-900 mb-3 tracking-tight">Đăng nhập quản trị</h2>
            <p class="text-gray-500 mb-12 text-lg">Chào mừng trở lại! Vui lòng nhập thông tin để tiếp tục quản lý hệ thống.</p>

            @if ($message = Session::get('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-red-700 font-medium text-sm">{{ $message }}</p>
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2.5 uppercase tracking-wider">Email</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-purple-600 transition-colors">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full pl-12 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500 transition-all outline-none text-gray-900 font-medium" 
                            placeholder="Nhập email đăng nhập" required>
                    </div>
                    @error('email')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2.5 uppercase tracking-wider">Mật khẩu</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-purple-600 transition-colors">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </span>
                        <input type="password" id="password" name="password"
                            class="w-full pl-12 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500 transition-all outline-none text-gray-900 font-medium" 
                            placeholder="••••••••" required>
                        <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between py-2">
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" checked class="w-5 h-5 text-purple-600 border-gray-300 rounded-lg focus:ring-purple-500/20 cursor-pointer">
                        <span class="ml-3 text-[15px] text-gray-600 group-hover:text-gray-900 transition-colors font-medium">Ghi nhớ phiên đăng nhập</span>
                    </label>
                </div>

                <button type="submit" 
                    class="w-full py-4.5 bg-purple-700 hover:bg-purple-800 text-white font-bold rounded-2xl shadow-xl shadow-purple-200 transition-all transform hover:-translate-y-1 active:scale-[0.97] text-lg tracking-wide uppercase">
                    ĐĂNG NHẬP HỆ THỐNG
                </button>
            </form>

            <div class="mt-24 text-center">
                <p class="text-[13px] text-gray-400 font-medium">&copy; 2024 Urban Luxe Management System.<br>Secure Administration Terminal.</p>
            </div>
        </div>
    </div>
</div>

@push('styles')
    @vite(['resources/css/admin/login.css'])
@endpush

<script>
function togglePassword(fieldId) {
    const input = document.getElementById(fieldId);
    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}
</script>

@endsection
