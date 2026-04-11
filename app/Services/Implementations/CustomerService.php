<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Services\Contracts\CustomerServiceInterface;

class CustomerService implements CustomerServiceInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository
    ) {}

    public function getAllCustomers()
    {
        return $this->customerRepository->getAll();
    }

    public function getById(int $id)
    {
        return $this->customerRepository->findById($id);
    }

    public function storeCustomer(array $data)
    {
        return $this->customerRepository->create($data);
    }

    public function updateCustomer(array $data, int $id)
    {
        return $this->customerRepository->update($id, $data);
    }

    public function deleteCustomer(int $id)
    {
        return $this->customerRepository->delete($id);
    }
}
