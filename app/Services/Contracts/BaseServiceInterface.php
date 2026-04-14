<?php
    namespace App\Services\Contracts;

    interface BaseServiceInterface{
        public function getAll();
        public function create(array $data);
        public function findById($id);
        public function update($id, array $data);
        public function delete($id);
        public function getPaginated(array $filters = [], $perPage = 10);

    }
?>