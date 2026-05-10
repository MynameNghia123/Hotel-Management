<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Contracts\SearchServiceInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __construct(
        private readonly SearchServiceInterface $searchService
    ) {
    }

    public function index(Request $request): View
    {
        return view('client.pages.search', $this->searchService->prepareSearchData($request->all()));
    }
}
