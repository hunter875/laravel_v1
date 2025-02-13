<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use App\Common\Constant;
use App\Models\Role;

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
        $user = User::create($data);
       
        return $user;
    }

    public function update($id, array $data)
    {
        $user = User::find($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
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

    public function searchByName($name)
    {
        return User::where('name', 'like', '%' . $name . '%')->get();
    }

    public function findEmail($email)
    {
        return User::where('email', $email)->first();
    }
}