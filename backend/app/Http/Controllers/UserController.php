<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use App\Exceptions\CustomException;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCode;
use App\Constants\StatusCode;

class UserController extends Controller
{
    protected $userService;

    // Inject UserService vào controller thông qua constructor
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        if (!auth()->check() || !auth()->user()->can('AccessAdmin', User::class)) {
            abort(403, 'Unauthorized action.');
        }
    
        // Lấy danh sách người dùng từ service
        $users = $this->userService->getAllUsers();
    
        return view('users.index', compact('users'));  // Hoặc tên view mà bạn muốn
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

        if (!$user) {
            throw new CustomException(trans('msg.update_failed'), ErrorCode::FAILED, StatusCode::BAD_REQUEST);
        }

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
}
