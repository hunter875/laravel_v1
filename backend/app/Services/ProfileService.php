<?php
namespace App\Services;

use App\Repositories\ProfileRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileService {
    protected $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository) {
        $this->profileRepository = $profileRepository;
    }

    public function getProfile() {
        $user = Auth::user();
        return $this->profileRepository->getProfile($user);
    }

    public function updateProfile(array $data) {
        $user = Auth::user();    
        if (isset($data['avatar']) && $data['avatar']->isValid()) {
            $avatarPath = $data['avatar']->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }
        else {
            $avatar = 'avatars/default_avatar.png'; 
        }

        return $this->profileRepository->updateProfile($user->id, $data);
    }

    public function deleteProfile() {
        $user = Auth::user();
        return $this->profileRepository->deleteProfile($user->id);
    }

    public function update($id, array $data) {
        return $this->profileRepository->update($id, $data);
    }
}