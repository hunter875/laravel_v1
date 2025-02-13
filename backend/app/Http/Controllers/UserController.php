<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use App\Exceptions\CustomException;
use App\Models\User;
use App\Models\Role; // Thêm dòng này để sử dụng model Role
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCode;
use App\Constants\StatusCode;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        if (!auth()->check() || !auth()->user()->can('AccessAdmin', User::class)) {
            abort(403, 'Unauthorized action.');
        }

        $users = $this->userService->getAllUsers();
        $roles = Role::all(); // Lấy danh sách roles

        return view('users.index', compact('users', 'roles'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();

        $user = $this->userService->create($data);

        return response()->json([
            'success' => true,
            'message' => trans('msg.created'),
            'user' => $user
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        $data = $request->validated();

        $user = $this->userService->update($id, $data);

        return response()->json([
            'success' => true,
            'message' => trans('msg.updated'),
            'user' => $user
        ]);
    }

    public function destroy($id)
    {
        $this->userService->delete($id);

        return response()->json([
            'success' => true,
            'message' => trans('msg.deleted')
        ]);
    }

    public function searchByName(Request $request)
    {
        $name = $request->input('search');
        $users = $this->userService->searchByName($name);

        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }

    public function show($id)
    {
        $user = $this->userService->find($id);
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }
}
