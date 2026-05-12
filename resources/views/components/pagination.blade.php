@props(['paginator', 'pageRange' => 1, 'maxVisible' => 6])

@php
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
    $pageRange = $pageRange;
    $maxVisible = $maxVisible; 
    $total = $paginator->total();
    $perPage = $paginator->perPage();
    $from = ($currentPage - 1) * $perPage + 1;
    $to = min($currentPage * $perPage, $total);
    
    // Calculate the range of pages to display
    $pages = [];
    
    if ($lastPage <= $maxVisible) {
        // Show all pages if total pages <= maxVisible
        $pages = range(1, $lastPage);
    } else {
        // Show first page
        $pages[] = 1;
        
        // Calculate start and end of the range around current page
        $rangeStart = max(2, $currentPage - $pageRange); 
        $rangeEnd = min($lastPage - 1, $currentPage + $pageRange);
        
        // Add ellipsis and pages between first and range
        if ($rangeStart > 2) {
            $pages[] = '...';
        }
        
        // Add range pages
        for ($i = $rangeStart; $i <= $rangeEnd; $i++) {
            $pages[] = $i;
        }
        
        // Add ellipsis and pages between range and last
        if ($rangeEnd < $lastPage - 1) {
            $pages[] = '...';
        }
        
        // Show last page
        $pages[] = $lastPage;
    }
@endphp

<div class="pagination-container my-8">
    <!-- Pagination Info and Rows Per Page -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6 px-1">
        <div class="flex items-center gap-4">
            <div class="text-sm text-gray-600">
                Hiển thị <span class="font-semibold text-gray-900">{{ $from }}</span> 
                đến <span class="font-semibold text-gray-900">{{ $to }}</span> 
                trong <span class="font-semibold text-gray-900">{{ $total }}</span> kết quả
            </div>
        </div>
        
        <div class="flex items-center gap-4">
            <!-- Rows Per Page Dropdown -->
            <div class="flex items-center gap-2">
                <label for="perPage" class="text-sm text-gray-600 font-medium">Hiển thị:</label>
                <select 
                    id="perPage"
                    onchange="updatePerPage(this.value)"
                    class="px-3 py-1 rounded-lg border-2 border-gray-300 text-gray-800 hover:border-gray-800 focus:border-gray-900 focus:outline-none font-medium text-sm">
                    <option value="5" {{ request('per_page') == 5 || $perPage == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page') == 10 || $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('per_page') == 20 || $perPage == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ request('per_page') == 50 || $perPage == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 || $perPage == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span class="text-sm text-gray-600">dòng/trang</span>
            </div>
            
            <div class="text-sm text-gray-600">
                Trang <span class="font-semibold text-gray-900">{{ $currentPage }}</span> 
                / <span class="font-semibold text-gray-900">{{ $lastPage }}</span>
            </div>
        </div>
    </div>

    <!-- Pagination Navigation -->
    <nav class="flex items-center justify-center gap-1">
        <!-- Previous Button -->
        @if ($paginator->onFirstPage())
            <button disabled class="px-4 py-2 rounded-lg border-2 border-gray-200 text-gray-400 cursor-not-allowed bg-white transition">
                ← Trước
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}&per_page={{ request('per_page', $perPage) }}" 
               class="px-4 py-2 rounded-lg border-2 border-gray-300 text-gray-800 hover:border-gray-800 hover:bg-gray-50 transition font-medium">
                ← Trước
            </a>
        @endif

        <!-- Page Numbers -->
        <div class="flex gap-2 mx-2">
            @foreach ($pages as $page)
                @if ($page === '...')
                    <span class="px-3 py-2 text-gray-400">...</span>
                @elseif ($page == $currentPage)
                    <button disabled 
                            class="px-4 py-2 rounded-lg bg-gray-900 text-white font-semibold cursor-default transition shadow-md hover:shadow-lg">
                        {{ $page }}
                    </button>
                @else
                    <a href="{{ $paginator->url($page) }}&per_page={{ request('per_page', $perPage) }}" 
                       class="px-4 py-2 rounded-lg border-2 border-gray-200 text-gray-700 hover:border-gray-800 hover:bg-gray-100 transition font-medium">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
        </div>

        <!-- Next Button -->
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}&per_page={{ request('per_page', $perPage) }}" 
               class="px-4 py-2 rounded-lg border-2 border-gray-300 text-gray-800 hover:border-gray-800 hover:bg-gray-50 transition font-medium">
                Sau →
            </a>
        @else
            <button disabled class="px-4 py-2 rounded-lg border-2 border-gray-200 text-gray-400 cursor-not-allowed bg-white transition">
                Sau →
            </button>
        @endif
    </nav>
</div>

<script>
function updatePerPage(value) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', value);
    url.searchParams.set('page', 1); // Reset to first page
    window.location.href = url.toString();
}
</script>
