<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function searchByName($name);
    public function findEmail($email);
}
