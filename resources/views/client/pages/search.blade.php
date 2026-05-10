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
        <form class="search-bar-inline" action="{{ route('search') }}" method="GET">
            <div class="sb-item">
                <span class="sb-label">Check In</span>
                <div class="sb-input-group">
                    <i class="far fa-calendar-alt"></i>
                    <input type="date" name="checkin" value="{{ $criteria['checkin'] }}" required>
                </div>
            </div>

            <div class="sb-item">
                <span class="sb-label">Check Out</span>
                <div class="sb-input-group">
                    <i class="far fa-calendar-alt"></i>
                    <input type="date" name="checkout" value="{{ $criteria['checkout'] }}" required>
                </div>
            </div>

            <div class="sb-item sb-item-guests">
                <div class="sb-guest-input">
                    <label class="sb-label" for="searchAdults">Nguoi lon</label>
                    <input id="searchAdults" type="number" name="adults" min="1" value="{{ $criteria['adults'] }}" required>
                </div>
                <div class="sb-guest-input">
                    <label class="sb-label" for="searchChildren">Tre em</label>
                    <input id="searchChildren" type="number" name="children" min="0" value="{{ $criteria['children'] }}" required>
                </div>
                <div class="sb-guest-input">
                    <label class="sb-label" for="searchRooms">So phong</label>
                    <input id="searchRooms" type="number" name="rooms" min="1" value="{{ $criteria['rooms'] }}" required>
                </div>
            </div>

            @if(!empty($criteria['room_type']))
                <input type="hidden" name="room_type" value="{{ $criteria['room_type'] }}">
            @endif

            <button type="submit" class="btn-update-search">
                <i class="fas fa-search"></i>
                Tim phong
            </button>
        </form>
    </section>

    <section
        class="results-container js-results-container"
        data-nights="{{ $searchSummary['nights'] }}"
        data-requested-rooms="{{ $criteria['rooms'] }}"
        data-checkin="{{ $criteria['checkin'] }}"
        data-checkout="{{ $criteria['checkout'] }}"
        data-adults="{{ $criteria['adults'] }}"
        data-children="{{ $criteria['children'] }}"
    >
        <div class="results-header">
            <div class="results-title">
                <h2>Hay chon phong</h2>
                <p>
                    Tim thay {{ $searchSummary['results_count'] }} loai phong phu hop.
                    {{ $searchSummary['checkin_label'] }} - {{ $searchSummary['checkout_label'] }} ({{ $searchSummary['nights'] }} dem)
                </p>
                @if($searchSummary['is_relaxed_result'])
                    <p class="results-note">
                        Khong co loai phong nao du {{ $criteria['rooms'] }} phong trong cung mot hang.
                        Duoi day la cac lua chon con trong de ban ket hop.
                    </p>
                @endif
            </div>
        </div>

        <div class="room-result-table">
            <div class="table-header">
                <div class="th-label">Thong tin phong</div>
                <div class="th-label">Tien nghi</div>
                <div class="th-label">Suc chua</div>
                <div class="th-label">Gia & gia tri</div>
                <div class="th-label">Dat phong</div>
            </div>

            @forelse($roomTypes as $roomType)
                @php
                    $firstImage = $roomType->images->first();
                    $imagePath = $firstImage?->image_url ? ltrim($firstImage->image_url, '/') : 'img/room-deluxe.png';
                    $nameLower = \Illuminate\Support\Str::lower($roomType->name);
                    $fallbackImage = str_contains($nameLower, 'suite')
                        ? asset('img/room-suite.png')
                        : (str_contains($nameLower, 'penthouse') ? asset('img/room-penthouse.png') : asset('img/room-deluxe.png'));
                    $areaText = ((int) $roomType->width > 0 && (int) $roomType->height > 0)
                        ? ((int) $roomType->width * (int) $roomType->height) . ' m2'
                        : 'Dang cap nhat';
                @endphp

                <div class="room-row js-room-row" data-room-id="{{ $roomType->id }}" data-room-name="{{ $roomType->name }}" data-price="{{ (float) $roomType->daily_price }}" data-max="{{ (int) $roomType->available_rooms_count }}">
                    <div class="col-info">
                        <img
                            src="{{ asset($imagePath) }}"
                            alt="{{ $roomType->name }}"
                            class="room-thumb-small"
                            loading="lazy"
                            onerror="this.onerror=null;this.src='{{ $fallbackImage }}';"
                        >
                        <div>
                            <h3 class="room-name-small">{{ $roomType->name }}</h3>
                            <div class="room-meta-small">
                                <span><i class="fas fa-expand"></i> {{ $areaText }}</span>
                                <span><i class="fas fa-user-friends"></i> {{ (int) $roomType->adult_quantity }} nguoi lon, {{ (int) $roomType->child_quantity }} tre em</span>
                                <span><i class="fas fa-door-open"></i> Con trong {{ (int) $roomType->available_rooms_count }} / {{ (int) $roomType->rooms_count }} phong</span>
                            </div>
                            <a href="{{ route('room') }}" class="link-photos">Xem them <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="col-amenities">
                        @foreach($roomType->amenities->take(8) as $amenity)
                            <div class="amenity-mini">
                                <i class="fas {{ $amenityIconMap[$amenity->icon] ?? 'fa-check' }}"></i>
                                {{ $amenity->name }}
                            </div>
                        @endforeach
                        @if($roomType->amenities->isEmpty())
                            <div class="amenity-mini"><i class="fas fa-circle-info"></i> Dang cap nhat tien nghi</div>
                        @endif
                    </div>

                    <div class="col-capacity">
                        @php
                            $adultCapacity = max(1, (int) $roomType->adult_quantity);
                            $childCapacity = max(0, (int) $roomType->child_quantity);
                            $totalCapacity = $adultCapacity + $childCapacity;
                            $cappedAdults = min($adultCapacity, 4);
                        @endphp
                        <div class="capacity-stack">
                            <span class="capacity-number">{{ $totalCapacity }} khach</span>
                            <span class="capacity-detail">{{ $adultCapacity }} nguoi lon, {{ $childCapacity }} tre em</span>
                            <div class="capacity-icons">
                                @for($i = 0; $i < $cappedAdults; $i++)
                                    <i class="fas fa-user"></i>
                                @endfor
                                @if($adultCapacity > 4)
                                    <span class="capacity-more">+{{ $adultCapacity - 4 }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-price">
                        <div class="price-main">{{ number_format((float) $roomType->daily_price, 0, ',', '.') }} d</div>
                        <div class="price-sub">moi dem</div>
                        @if((int) $roomType->available_rooms_count >= (int) $criteria['rooms'])
                            <div class="badge-tag badge-best"><i class="fas fa-check"></i> Du {{ (int) $criteria['rooms'] }} phong theo yeu cau</div>
                        @else
                            <div class="badge-tag badge-suggest"><i class="fas fa-info-circle"></i> Con {{ (int) $roomType->available_rooms_count }} phong</div>
                        @endif
                    </div>

                    <div class="col-booking">
                        <label class="sb-label" for="qty-{{ $roomType->id }}">So luong</label>
                        <input
                            id="qty-{{ $roomType->id }}"
                            type="number"
                            class="room-qty-input js-room-qty"
                            min="0"
                            max="{{ (int) $roomType->available_rooms_count }}"
                            value="{{ (int) $roomType->default_selected_quantity }}"
                        >
                        <small>Toi da {{ (int) $roomType->available_rooms_count }} phong</small>
                    </div>
                </div>
            @empty
                <div class="room-row room-row-empty">
                    <div class="empty-state">
                        Khong tim thay phong phu hop voi bo loc hien tai. Vui long doi ngay hoac giam so luong phong.
                    </div>
                </div>
            @endforelse
        </div>

        <div class="booking-summary-wrapper">
            <div class="booking-summary-card">
                <span class="summary-total-label">Tong gia ({{ $searchSummary['nights'] }} dem)</span>
                <span class="summary-total-value js-summary-total">0 d</span>
                <p class="summary-selection js-summary-selection">Chua chon phong</p>
                <a href="{{ route('checkout') }}" class="summary-action-link js-summary-action" style="text-decoration: none; width: 100%;">
                    <button type="button" class="btn-book-now-final">
                        Tiep tuc dat phong
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </a>
            </div>
        </div>
    </section>
</main>
@endsection
