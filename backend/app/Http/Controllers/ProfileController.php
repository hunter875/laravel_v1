<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    /**
     * Hiển thị trang thông tin cá nhân.
     */
    public function index()
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    /**
     * Cập nhật thông tin cá nhân.
     */
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();

        $updateData = [
            'name' => $validated['name'],
        ];

        // Cập nhật email nếu có thay đổi
        if ($validated['email'] !== $user->email) {
            $updateData['email'] = $validated['email'];
        }

        // Cập nhật first_name và last_name nếu được cung cấp
        if (isset($validated['first_name'])) {
            $updateData['first_name'] = $validated['first_name'];
        }
        if (isset($validated['last_name'])) {
            $updateData['last_name'] = $validated['last_name'];
        }

        // Cập nhật mật khẩu nếu có
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        // Xử lý avatar: xóa avatar cũ nếu có và lưu file mới
        if ($request->hasFile('avatar')) {
            if (!empty($user->avatar) && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $updateData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        try {
            $user->update($updateData);
            return redirect()->route('profile.index')
                ->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            Log::error('Profile update failed: ' . $e->getMessage());
            return redirect()->route('profile.index')
                ->with('error', 'Failed to update profile.');
        }
    }
}
