<?php

namespace App\Services\Contracts;

interface CustomerServiceInterface
{
    public function getAllCustomers();
    public function getById(int $id);
    public function storeCustomer(array $data);
    public function updateCustomer(array $data, int $id);
    public function deleteCustomer(int $id);
}
