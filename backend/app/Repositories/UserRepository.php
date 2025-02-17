<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{
    public function find($id)
    {
        return User::find($id);
    }

    public function all()
    {
        return User::all();
    }

    public function create(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        return User::create($data);
    }

    public function update($id, array $data)
{
    $user = User::find($id);
    if ($user) {
        return $user->update($data);
    }
    return false;
}
    
    
    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return true;
        }
        return false;
    }

    public function paginate($perPage)
    {
        return User::paginate($perPage);
    }

    public function getUserById($id)
    {
        return User::find($id);
    }
}