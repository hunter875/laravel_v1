<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Import Log facade
use App\Models\User;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $validatedData = $request->validated();
    
        $updateData = [
            'name' => $validatedData['name'],
        ];
    
        // Chỉ cập nhật email nếu có thay đổi
        if ($validatedData['email'] !== $user->email) {
            $updateData['email'] = $validatedData['email'];
        }
    
        // Kiểm tra và cập nhật first_name, last_name nếu tồn tại
        if (isset($validatedData['first_name'])) {
            $updateData['first_name'] = $validatedData['first_name'];
        }
    
        if (isset($validatedData['last_name'])) {
            $updateData['last_name'] = $validatedData['last_name'];
        }
    
        // Cập nhật mật khẩu nếu có
        if (!empty($validatedData['password'])) {
            $updateData['password'] = Hash::make($validatedData['password']);
        }
    
        // Xử lý avatar
        if ($request->hasFile('avatar')) {
            if (!empty($user->avatar) && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
    
            $updateData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
    
        try {
            $user->update($updateData);
            return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            Log::error('Profile update failed: ' . $e->getMessage());
            return redirect()->route('profile.index')->with('error', 'Failed to update profile.');
        }
    }
    

}
