<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\ServiceRepositoryInterface;
use App\Services\Contracts\ServiceServiceInterface;

/**
 * ServiceService - Implement ServiceServiceInterface (extends BaseServiceInterface)
 * 
 * Quản lý logic nghiệp vụ cho dịch vụ, bao gồm:
 * - Lấy tất cả dịch vụ
 * - Tạo dịch vụ mới
 * - Tìm dịch vụ theo ID
 * - Cập nhật dịch vụ
 * - Xóa dịch vụ
 * - Lấy dịch vụ có phân trang
 */
class ServiceService implements ServiceServiceInterface
{
    public function __construct(
        private readonly ServiceRepositoryInterface $serviceRepository
    ) {}

    /**
     * Lấy tất cả dịch vụ
     * @return mixed
     */
    public function getAll()
    {
        return $this->serviceRepository->getAll();
    }

    /**
     * Tạo dịch vụ mới
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->serviceRepository->create($data);
    }

    /**
     * Tìm dịch vụ theo ID
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->serviceRepository->findById($id);
    }

    /**
     * Cập nhật dịch vụ
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        return $this->serviceRepository->update($id, $data);
    }

    /**
     * Xóa dịch vụ
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->serviceRepository->delete($id);
    }

    /**
     * Lấy dịch vụ có phân trang
     * @param array $filters
     * @param int $perPage
     * @return mixed
     */
    public function getPaginated(array $filters = [], $perPage = 10)
    {
        return $this->serviceRepository->getPaginated($filters, $perPage);
    }
}
