<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Hotel;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Hiển thị danh sách user
    public function index()
    {
        $users = User::paginate(7);
        $roles = Role::all();
        
        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Hiển thị form thêm người dùng mới.
     */
    public function create()
    {
        $roles = Role::all();
        
        return view('users.create', compact('roles'));
    }

    /**
     * Lưu người dùng mới vào cơ sở dữ liệu.
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Hiển thị form chỉnh sửa người dùng.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Cập nhật thông tin người dùng.
     */
    public function update(UserRequest $request, User $user)
    {
        $validated = $request->validated();
        Log::info('Validated data: ', $validated);

        // Bỏ qua email nếu không thay đổi
        if ($request->email === $user->email) {
            unset($validated['email']);
        }

        // Nếu có mật khẩu mới thì mã hóa, nếu không thì bỏ qua
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Xóa người dùng (trừ Admin role_id = 1).
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role_id == 1) {
            return redirect()->route('users.index')->with('error', 'Admin users cannot be deleted.');
        }

        // Check if the user has associated hotels
        if (Hotel::where('user_id', $id)->exists()) {
            return redirect()->route('users.index')->with('error', 'User cannot be deleted because they have associated hotels.');
        }

        $user->delete(); // Soft delete
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function checkUserHotels(Request $request)
    {
        $user = User::find($request->user_id);

        if ($user && $user->hotels()->exists()) {
            return response()->json(['hasHotel' => true]);
        }

        return response()->json(['hasHotel' => false]);
    }
}
