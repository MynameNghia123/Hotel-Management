<?php 
namespace App\Repositories\Implementations;
use App\Models\RoleClaim;
use Illuminate\Support\Collection;
use App\Repositories\Contracts\RoleClaimRepositoryInterface;
class EloquentRoleClaimRepository implements RoleClaimRepositoryInterface{
        protected $model;
    
        public function __construct(RoleClaim $model){
            $this->model = $model;
        }
    
        public function getAll() : Collection{
            return $this->model->all();
        }
    
        public function create(array $data) : RoleClaim{
            return $this->model->create($data);
        }
    
        public function findById($id) : RoleClaim{
            return $this->model->findOrFail($id);
        }
        public function update($id, array $data) : RoleClaim{
            $roleClaim = $this->findById($id);
            $roleClaim->update($data);
            return $roleClaim;
        }
        public function delete($id) : bool{
            $roleClaim = $this->findById($id);
            return $roleClaim->delete();
        }
}
    
?>