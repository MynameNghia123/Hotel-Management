<?php
namespace App\Services\Implementations;
use App\Services\Contracts\StaffServiceInterface;
use App\Repositories\Contracts\StaffRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class StaffService implements StaffServiceInterface
{
    protected $staffRepository;

    public function __construct(StaffRepositoryInterface $staffRepository)
    {
        $this->staffRepository = $staffRepository;
    }

    public function getAll()
    {
        return $this->staffRepository->getAll();
    }

    public function create(array $data)
    {
        // Hash the password before saving
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->staffRepository->create($data);
    }

    public function findById($id)
    {
        return $this->staffRepository->findById($id);
    }

    public function update($id, array $data)
    {
        // Hash password nếu có
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->staffRepository->update($id, $data);
    }
    
    public function delete($id) : bool
    {
        return $this->staffRepository->delete($id);
    }
}
