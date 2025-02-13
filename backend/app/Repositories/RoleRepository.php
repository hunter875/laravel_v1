<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use App\Models\Hotel;

class RoleRepository implements RoleRepositoryInterface
{
    public function all()
    {
        return Role::all();
    }

    public function find($id)
    {
        return Role::find($id);
    }

    public function create(array $data)
    {
        return Role::create($data);
    }

    public function update($id, array $data)
    {
        $role = Role::find($id);
        if ($role) {
            $role->update($data);
            return $role;
        }
        return null;
    }

    public function delete($id)
    {
        $role = Role::find($id);
        if ($role) {
            // Kiểm tra xem role có tồn tại trong bảng users hoặc hotels không
            if (User::where('role_id', $id)->exists() || Hotel::where('role_id', $id)->exists()) {
                return false;
            }
            $role->delete();
            return true;
        }
        return false;
    }
}
