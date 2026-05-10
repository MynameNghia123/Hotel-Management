@extends ('client.layouts.master')
@section('title', 'Tim Kiem Phong Nghi | Urban Luxe Hotel')
@section('meta_description', 'Tim kiem phong nghi tai Urban Luxe Hotel theo ngay nhan tra phong, so luong khach va so phong mong muon.')

@push('styles')
@vite(['resources/css/client/search.css', 'resources/js/client/search.js'])
@endpush

@section('content')
@php
    $amenityIconMap = [
        'wifi' => 'fa-wifi',
        'air-conditioner' => 'fa-snowflake',
        'tv' => 'fa-tv',
        'fridge' => 'fa-temperature-low',
        'safe' => 'fa-shield-halved',
        'bathtub' => 'fa-bath',
        'shower' => 'fa-shower',
        'balcony' => 'fa-building',
        'coffee' => 'fa-mug-hot',
        'minibar' => 'fa-wine-bottle',
    ];
@endphp

<main class="search-page">
    <section class="search-header-container" style="background-image: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), url('{{ asset('img/backgroundhomepage.png') }}');">
        <form action="{{ route('search') }}" method="GET" class="search-bar-inline">
            <div class="sb-item">
                <span class="sb-label">Check In</span>
                <div class="sb-input-group">
                    <i class="far fa-calendar-alt"></i>
                    <input type="text" name="checkin" value="{{ $checkin }}" onfocus="(this.type='date')" onblur="(this.type='text')" style="background:transparent; border:none; color:#1e293b; outline:none; font-family:inherit; cursor:pointer; width: 100%;">
                </div>
            </div>

            <div class="sb-item">
                <span class="sb-label">Check Out</span>
                <div class="sb-input-group">
                    <i class="far fa-calendar-alt"></i>
                    <input type="text" name="checkout" value="{{ $checkout }}" onfocus="(this.type='date')" onblur="(this.type='text')" style="background:transparent; border:none; color:#1e293b; outline:none; font-family:inherit; cursor:pointer; width: 100%;">
                </div>
            </div>
            <div class="sb-item">
                <span class="sb-label">Guests</span>
                <div class="sb-input-group">
                    <i class="fas fa-users"></i>
                    <input type="text" name="guests" value="{{ $guests }}" onfocus="(this.type='number')" onblur="(this.type='text')" style="background:transparent; border:none; color:#1e293b; outline:none; font-family:inherit; width: 50px; cursor:pointer;">
                    <span style="color:#64748b;">Khách</span>
                </div>
            </div>
            <button type="submit" class="btn-update-search">
                <i class="fas fa-search"></i>
                Tim phong
            </button>
        </form>
    </section>

    <!-- Results Section -->
    <section class="results-container">
        @if(session('error'))
            <div style="padding: 15px; margin-bottom: 20px; background-color: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #ef4444; border-radius: 8px;">
                {{ session('error') }}
            </div>
        @endif

        <div class="results-header">
            <div class="results-title">
                <h2>Hãy chọn phòng</h2>
                <p>Hiện có {{ count($availableRoomTypes) }} loại phòng phù hợp với bạn</p>
            </div>
        </div>

        <form action="{{ route('checkout.init') }}" method="POST">
            @csrf
            <input type="hidden" name="checkin" value="{{ $checkin }}">
            <input type="hidden" name="checkout" value="{{ $checkout }}">

            <!-- Room List Table -->
            <div class="room-result-table">
                <!-- Table Header -->
                <div class="table-header">
                    <div class="th-label">Thông tin phòng</div>
                    <div class="th-label">Tiện nghi</div>
                    <div class="th-label">Sức chứa</div>
                    <div class="th-label">Giá & Giá trị</div>
                    <div class="th-label">Đặt phòng</div>
                </div>

                @forelse($availableRoomTypes as $roomType)
                <div class="room-row">
                    <div class="col-info">
                        @php
                            $imageUrl = asset('img/room-deluxe.png'); // Default image
                            if ($roomType->images && $roomType->images->count() > 0) {
                                $imageUrl = asset('storage/' . $roomType->images->first()->image_path);
                            }
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $roomType->name }}" class="room-thumb-small">
                        <div>
                            <h3 class="room-name-small">{{ $roomType->name }}</h3>
                            <div class="room-meta-small">
                                <span><i class="fas fa-expand"></i> {{ $roomType->width * $roomType->height }} m²</span>
                                <span><i class="fas fa-user-friends"></i> Max {{ $roomType->adult_quantity }} adults</span>
                                <span><i class="fas fa-bed"></i> {{ $roomType->single_bed_quantity + $roomType->double_bed_quantity }} beds</span>
                            </div>
                            <a href="#" class="link-photos">See photos <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-amenities">
                        @foreach($roomType->amenities->take(6) as $amenity)
                            <div class="amenity-mini"><i class="fas fa-check"></i> {{ $amenity->name }}</div>
                        @endforeach
                    </div>
                    <div class="col-capacity">
                        @for($i = 0; $i < $roomType->adult_quantity; $i++)
                            <i class="fas fa-user"></i>
                        @endfor
                    </div>
                    <div class="col-price">
                        <div class="price-main">{{ number_format($roomType->daily_price, 0, ',', '.') }} đ</div>
                        <div class="price-sub">mỗi đêm</div>
                        <div class="badge-tag badge-suggest"><i class="fas fa-check"></i> Có sẵn {{ $roomType->available_count }} phòng</div>
                    </div>
                    <div class="col-booking">
                        <span class="sb-label">Số lượng</span>
                        <select name="room_qty[{{ $roomType->id }}]" class="select-qty">
                            @for($i = 0; $i <= $roomType->available_count; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                @empty
                <div style="padding: 40px; text-align: center; color: #94a3b8; font-size: 1.1rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
                    Xin lỗi, không có phòng nào trống trong khoảng thời gian này. Vui lòng chọn ngày khác.
                </div>
                @endforelse
            </div>

            <!-- COMPACT BOOKING SUMMARY CARD -->
            @if(count($availableRoomTypes) > 0)
            <div class="booking-summary-wrapper">
                <div class="booking-summary-card">
                    <span class="summary-total-label">ĐẶT PHÒNG TỪ {{ \Carbon\Carbon::parse($checkin)->format('d/m') }} ĐẾN {{ \Carbon\Carbon::parse($checkout)->format('d/m') }}</span>
                    <span class="summary-total-value"></span>
                    <button type="submit" class="btn-book-now-final">
                        Tiếp tục Checkout
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
            @endif
        </form>
    </section>
</main>
@endsection
