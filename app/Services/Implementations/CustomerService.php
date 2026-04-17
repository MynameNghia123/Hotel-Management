<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Services\Contracts\CustomerServiceInterface;

class CustomerService implements CustomerServiceInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository
    ) {}
    public function getDistinctCountries()
    {
        $customers = $this->getAll(); // Gọi repo lấy TẤT CẢ khách hàng
        return $customers->pluck('country')->unique()->values();
        // return $this->customerRepository->getDistinctCountries();
    }

    public function getAll()
    {
        return $this->customerRepository->getAll();
    }

    public function create(array $data)
    {
        return $this->customerRepository->create($data);
    }

    public function findById($id)
    {
        return $this->customerRepository->findById($id);
    }

    public function update($id, array $data)
    {
        return $this->customerRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->customerRepository->delete($id);
    }

    public function getPaginated(array $filters = [], $perPage = 10)
    {
        return $this->customerRepository->getPaginated($filters, $perPage);
    }
}
