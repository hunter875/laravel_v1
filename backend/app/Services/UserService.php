<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getHome()
    {
        return '/home';
    }

    public function getAllUsers($perPage = 10)
    {
        return $this->userRepository->paginate($perPage);
    }

    public function getUserById($id)
    {
        return $this->userRepository->find($id);
    }

    public function create(array $data)
    {
        $data['user_id'] = $data['user_id'] ?? 2;
        return $this->userRepository->create($data);
    }

    public function update($id, array $data)
    {
        
        return $this->userRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->userRepository->delete($id);
    }

    public function findEmail($email)
    {
        return $this->userRepository->findEmail($email);
    }

    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    public function paginate($perPage)
    {
        return $this->userRepository->paginate($perPage);
    }

    public function checkDuplicateUserAndEmail($email, $username)
    {
        return $this->userRepository->checkDuplicateUserAndEmail($email, $username);
    }
}