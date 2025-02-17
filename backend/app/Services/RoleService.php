<?php

namespace App\Services;

use App\Repositories\RoleRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function all()
    {
        try {
            return $this->roleRepository->all();
        } catch (Exception $e) {
            Log::error('Error fetching roles: ' . $e->getMessage());
            throw new Exception('Error fetching roles.');
        }
    }

    public function find($id)
    {
        try {
            return $this->roleRepository->find($id);
        } catch (Exception $e) {
            Log::error('Error finding role with ID: ' . $id . ' - ' . $e->getMessage());
            throw new Exception('Error finding role.');
        }
    }

    public function create(array $data)
    {
        try {
            return $this->roleRepository->create($data);
        } catch (Exception $e) {
            Log::error('Error creating role: ' . $e->getMessage());
            throw new Exception('Error creating role.');
        }
    }

    public function update($id, array $data)
    {
        try {
            return $this->roleRepository->update($id, $data);
        } catch (Exception $e) {
            Log::error('Error updating role with ID: ' . $id . ' - ' . $e->getMessage());
            throw new Exception('Error updating role.');
        }
    }

    public function delete($id)
    {
        try {
            return $this->roleRepository->delete($id);
        } catch (Exception $e) {
            Log::error('Error deleting role with ID: ' . $id . ' - ' . $e->getMessage());
            throw new Exception('Error deleting role.');
        }
    }
}
