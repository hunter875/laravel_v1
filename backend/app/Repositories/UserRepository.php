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
        return User::findOrFail($id);
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
        $user = User::findOrFail($id);
        $user->update($data);

        return $user->fresh();
    }

    public function delete($id)
    {
        return User::destroy($id);
    }

    public function searchByName($name)
    {
        return User::where('name', 'like', '%' . $name . '%');
    }

    public function findEmail($email){
        return User::where('email', '=', $email)->first();
    }

}