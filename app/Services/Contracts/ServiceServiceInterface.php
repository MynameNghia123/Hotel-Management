<?php

namespace App\Services\Contracts;

interface ServiceServiceInterface extends BaseServiceInterface
{
    // Thừa kế tất cả các method từ BaseServiceInterface:
    // - getAll()
    // - create(array $data)
    // - findById($id)
    // - update($id, array $data)
    // - delete($id)
    // - getPaginated(array $filters = [], $perPage = 10)
    
    // Các method specific cho Service nếu cần...
}
