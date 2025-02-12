<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller{
    protected $profileService;
    public function __construct(ProfileService $profileService){
        $this->profileService = $profileService;
    }

    public function index(){
        $user = $this->profileService->getProfile();
        return view('profile.index', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $data = $request->validated();
        $profile = $this->profileService->updateProfile($data);
        return redirect()->route('profile.index')->with('success', trans('msg.updated'));
    }

    public function delete(){
        return $this->profileService->delete();
    }
}