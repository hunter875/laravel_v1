<?php
namespace App\Repositories;

use App\Repositories\ProfileRepositoryInterface;
use App\Models\User;

class ProfileRepository implements ProfileRepositoryInterface{

    public function getProfile($user){
        return $user;
    }

    public function updateProfile($id, array $data){
        $user = User::find($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }

    public function deleteProfile($id){
        return User::destroy($id);
    }

    public function update($id, array $data){
        $user = User::find($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }
}