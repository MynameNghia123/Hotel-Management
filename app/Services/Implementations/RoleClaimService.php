<?php
    namespace App\Services\Implementations;
    use App\Repositories\Contracts\RoleClaimRepositoryInterface;
    use App\Services\Contracts\RoleClaimServiceInterface;

    class RoleClaimService implements RoleClaimServiceInterface{
        protected $roleClaimRepository;

        public function __construct(RoleClaimRepositoryInterface $roleClaimRepository){
            $this->roleClaimRepository = $roleClaimRepository;
        }

        public function getAll(){
            return $this->roleClaimRepository->getAll();
        }

        public function findById($id){
            return $this->roleClaimRepository->findById($id);
        }

        public function create(array $data){
            return $this->roleClaimRepository->create($data);
        }

        public function update($id, array $data){
            return $this->roleClaimRepository->update($id, $data);
        }

        public function delete($id){
            return $this->roleClaimRepository->delete($id);
        }
        public function getByRoleId($roleId){
            return $this->roleClaimRepository->getByRoleId($roleId);
        }
        public function deleteByRoleId($roleId){
            return $this->roleClaimRepository->deleteByRoleId($roleId);
        }
        public function getPaginated(array $filters = [], $perPage = 15){
            return $this->roleClaimRepository->getPaginated($filters, $perPage);
        }
    }
?>