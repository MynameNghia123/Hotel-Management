<?php
    namespace App\Services\Implementations;
    use App\Repositories\Contracts\RoleClaimRepositoryInterface;
    use App\Repositories\Contracts\RoleRepositoryInterface;
    use App\Services\Contracts\RoleServiceInterface;

    class RoleService implements RoleServiceInterface{
        protected $roleRepository;
        protected $roleClaimRepository;

        public function __construct(RoleRepositoryInterface $roleRepository, RoleClaimRepositoryInterface $roleClaimRepository){
            $this->roleRepository = $roleRepository;
            $this->roleClaimRepository = $roleClaimRepository;
        }

        public function getAll(){
            return $this->roleRepository->getAll();
        }

        public function findById($id){
            return $this->roleRepository->findById($id);
        }

        public function create(array $data){
            return $this->roleRepository->create($data);
        }

        public function update($id, array $data){
            return $this->roleRepository->update($id, $data);
        }

        public function delete($id){
            return $this->roleRepository->delete($id);
        }
    }
?>