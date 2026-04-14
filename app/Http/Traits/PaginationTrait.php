<?php

namespace App\Http\Traits;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait PaginationTrait
{
    /**
     * Lấy per_page từ request và validate
     * 
     * @param int $default - giá trị mặc định (mặc định: 10)
     * @param array $allowed - các giá trị được phép (mặc định: [5, 10, 20, 50, 100])
     * @return int
     */
    public function getPerPage($default = 10, $allowed = [5, 10, 20, 50, 100]): int
    {
        $perPage = request('per_page', $default);
        
        // Ép kiểu thành integer
        $perPage = (int) $perPage;
        
        // Nếu per_page không hợp lệ, sử dụng giá trị mặc định
        if (!in_array($perPage, $allowed)) {
            $perPage = $default;
        }
        
        return $perPage;
    }

    /**
     * Lấy trang từ request
     * 
     * @param int $default - giá trị mặc định (mặc định: 1)
     * @return int
     */
    public function getCurrentPage($default = 1): int
    {
        $page = request('page', $default);
        $page = (int) $page;
        
        // Đảm bảo trang không âm hoặc 0
        return max(1, $page);
    }

    /**
     * Validate trang theo dữ liệu động
     * Nếu trang vượt quá lastPage, throw 404
     * 
     * @param int $currentPage - trang hiện tại
     * @param int $lastPage - trang cuối cùng
     * @param string $mode - 'abort' (throw 404) hoặc 'redirect' (redirect về trang cuối)
     * @return void
     * @throws NotFoundHttpException
     */
    public function validatePageNumber($currentPage, $lastPage, $mode = 'abort'): void
    {
        // Nếu trang hiện tại vượt quá số trang thực tế
        if ($currentPage > $lastPage && $lastPage > 0) {
            if ($mode === 'abort') {
                // Throw 404 error
                abort(404, "Trang {$currentPage} không tồn tại. Chỉ có {$lastPage} trang.");
            } elseif ($mode === 'redirect') {
                // Redirect về trang cuối cùng
                $perPage = request('per_page');
                $url = request()->url() . "?page={$lastPage}";
                if ($perPage) {
                    $url .= "&per_page={$perPage}";
                }
                redirect($url)->send();
            }
        }

        // Nếu không có dữ liệu (lastPage = 0)
        if ($lastPage === 0 && $currentPage > 1) {
            if ($mode === 'abort') {
                abort(404, "Không có dữ liệu để hiển thị.");
            }
        }
    }

    /**
     * Kiểm tra xem có dữ liệu không
     * 
     * @param mixed $collection - Collection hoặc paginator
     * @return bool
     */
    public function hasData($collection): bool
    {
        if (method_exists($collection, 'count')) {
            return $collection->count() > 0;
        }
        return false;
    }
}

