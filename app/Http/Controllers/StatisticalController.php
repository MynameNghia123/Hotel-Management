<?php

namespace App\Http\Controllers;

use App\Services\Contracts\StatisticalServiceInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatisticalController extends Controller
{
    public function __construct(
        private readonly StatisticalServiceInterface $statisticalService
    ) {
    }

    public function index(Request $request): View
    {
        return view('admin.statistical.index', [
            'report' => $this->statisticalService->overview($request->all()),
        ]);
    }

    public function revenue(Request $request): View
    {
        return view('admin.statistical.revenue', [
            'report' => $this->statisticalService->revenue($request->all()),
        ]);
    }

    public function roomEfficiency(Request $request): View
    {
        return view('admin.statistical.room-efficiency', [
            'report' => $this->statisticalService->roomEfficiency($request->all()),
        ]);
    }

    public function customers(Request $request): View
    {
        return view('admin.statistical.customers', [
            'report' => $this->statisticalService->customers($request->all()),
        ]);
    }
}
