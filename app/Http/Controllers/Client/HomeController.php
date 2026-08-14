<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Contracts\HomeServiceInterface;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly HomeServiceInterface $homeService
    ) {}

    public function index(): View
    {
        return view('client.pages.homepage', $this->homeService->getHomepageData());
    }
}
