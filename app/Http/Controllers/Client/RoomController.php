<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function __construct(
        private readonly RoomType $roomTypeModel
    ) {}

    public function index(): View
    {
        return view('client.pages.room');
    }

    public function show(RoomType $roomType): View
    {
        $roomType->load([
            'images' => fn ($query) => $query->orderBy('order'),
            'amenities',
        ]);

        $similarRoomTypes = $this->roomTypeModel
            ->newQuery()
            ->with([
                'images' => fn ($query) => $query->orderBy('order'),
            ])
            ->where('is_active', true)
            ->where('id', '!=', $roomType->id)
            ->orderByDesc('daily_price')
            ->orderBy('name')
            ->limit(2)
            ->get();

        return view('client.pages.roomdetail', compact('roomType', 'similarRoomTypes'));
    }
}
