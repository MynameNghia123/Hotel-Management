@extends('admin.layouts.master')

@section('title', 'Đăng nhập hệ thống - Urban Luxe')

@section('content')
<div class="self-stretch h-[1024px] inline-flex justify-start items-start">
  <div class="w-[853.33px] self-stretch relative border-r">
    <img class="w-[853.33px] h-[1024px] left-0 top-0 absolute object-cover" src="https://placehold.co/853x1024" />
    <div class="w-[853.33px] h-[1024px] p-12 left-0 top-0 absolute bg-black/40 inline-flex flex-col justify-end items-start">
      <div class="self-stretch pb-4 flex flex-col justify-start items-start">
        <div class="self-stretch flex flex-col justify-start items-start">
          <div class="self-stretch justify-center text-white text-4xl font-bold font-['Inter'] leading-10">Urban Luxe Hotel Management</div>
        </div>
      </div>
      <div class="w-[512px] max-w-[512px] opacity-90 flex flex-col justify-start items-start">
        <div class="w-[477.17px] justify-center text-white text-lg font-normal font-['Inter'] leading-7">Quản lý khách sạn chuyên nghiệp, nâng tầm trải nghiệm<br/>khách hàng với hệ thống quản trị hiện đại.</div>
      </div>
    </div>
  </div>
  <div class="w-96 self-stretch px-20 bg-white inline-flex flex-col justify-center items-start shadow-xl relative z-10">
    <div class="w-full relative">
      <div class="w-full pb-8">
        <div class="w-12 h-12 mb-4 bg-purple-700/10 rounded-lg flex justify-center items-center">
            <div class="w-4 h-4 bg-purple-700 rounded-sm"></div>
        </div>
        <h1 class="text-gray-900 text-3xl font-bold font-['Inter'] leading-9 mb-2">Đăng nhập quản trị</h1>
        <p class="text-gray-500 text-sm font-normal font-['Inter'] leading-5">Chào mừng trở lại! Vui lòng nhập thông tin để tiếp tục.</p>
      </div>
      <div class="w-full flex flex-col gap-6">
        <div class="w-full flex flex-col gap-2">
          <label class="text-gray-700 text-sm font-medium font-['Inter'] leading-5">Tên đăng nhập</label>
          <div class="w-full relative">
            <input type="text" value="admin@urbanluxe.com" class="w-full pl-10 pr-4 py-3.5 bg-white rounded-lg outline outline-1 outline-offset-[-1px] outline-gray-300 text-gray-900 text-base font-normal font-['Inter'] focus:outline-purple-600">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
              <div class="w-4 h-4 bg-gray-400 rounded-full"></div>
            </div>
          </div>
        </div>
        <div class="w-full flex flex-col gap-2">
          <label class="text-gray-700 text-sm font-medium font-['Inter'] leading-5">Mật khẩu</label>
          <div class="w-full relative">
            <input type="password" value="password" class="w-full pl-10 pr-4 py-3.5 bg-white rounded-lg outline outline-1 outline-offset-[-1px] outline-gray-300 text-gray-900 text-base font-normal font-['Inter'] focus:outline-purple-600">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
              <div class="w-4 h-4 rounded-sm border-2 border-gray-400"></div>
            </div>
          </div>
        </div>
        <div class="w-full flex justify-between items-center">
          <div class="flex items-center gap-2">
            <input type="checkbox" id="remember" class="w-4 h-4 rounded border-gray-300 text-purple-600 focus:ring-purple-600 cursor-pointer">
            <label for="remember" class="text-gray-600 text-sm font-normal font-['Inter'] leading-5 cursor-pointer">Ghi nhớ đăng nhập</label>
          </div>
        </div>
        <button class="w-full py-3.5 bg-purple-700 hover:bg-purple-800 transition-colors rounded-lg shadow-sm flex items-center justify-center cursor-pointer mt-2">
          <span class="text-white text-sm font-bold font-['Inter'] leading-5">ĐĂNG NHẬP</span>
        </button>
      </div>
    </div>
  </div>
</div>
@endsection