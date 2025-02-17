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

    // Dữ liệu cần cập nhật
    $updateData = [
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'first_name' => $validatedData['first_name'],
        'last_name' => $validatedData['last_name'],
    ];

    if (!empty($validatedData['password'])) {
        $updateData['password'] = Hash::make($validatedData['password']);
    }

    // Xử lý avatar nếu có
    if ($request->hasFile('avatar')) {
        // Xóa avatar cũ nếu có
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $updateData['avatar'] = $request->file('avatar')->store('avatars', 'public');
    }

    // Cập nhật thông tin người dùng
    $user->update($updateData);

    return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
}

}
