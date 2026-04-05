<?php
    namespace App\Repositories\Implementations;
    use App\Models\Role;
    use App\Repositories\Contracts\RoleRepositoryInterface;
    use Illuminate\Support\Collection;

    class EloquentRoleRepository implements RoleRepositoryInterface{
        protected $model;

        public function __construct(Role $model){
            $this->model = $model;
        }

        public function getAll() : Collection{
            return $this->model->all();
        }

        public function create(array $data) : Role{
            return $this->model->create($data);
        }

        public function findById($id) : Role{
            return $this->model->findOrFail($id);
        }

        public function update($id, array $data) : Role{
            $role = $this->findById($id);
            $role->update($data);
            return $role;
        }

        public function delete($id) : bool{
            $role = $this->findById($id);
            return $role->delete();
        }
    }
?>