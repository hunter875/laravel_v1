<?php
namespace App\Services;
use Illuminate\Support\Facades\Log;

use App\Repositories\UserRepositoryInterface;
use App\Common\Constant;
use App\Models\User;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Str;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getHome(){
        return $url = '/home';
    }
    public function getAllUsers()
    {
        return User::paginate(Constant::PAGINATE_DEFAULT);
    }

    public function getUserById($id)
    {
        return User::find($id);
    }

    public function create(array $data)
    {
        try {
            $data['role_id'] = $data['role_id'] ?? 2; // Gọn hơn
    
            return $this->userRepository->create($data);
        } catch (\Throwable $e) { // Bắt cả Error và Exception
            report($e); // Laravel sẽ tự ghi log
            return response()->json(['error' => 'User creation failed'], 500);
        }
    }
    


  
    public function update($id, array $data)
    {
        $user = User::find($id);
        if (!$user) {
            return null; // Nếu không tìm thấy người dùng, trả về null
        }
    
        // Cập nhật thông tin người dùng
        $user->update($data);
    
        return $user; // Trả về người dùng đã được cập nhật
    }
    

    

    public function delete($id)
    {
        return $this->userRepository->delete($id);
    }

    public function searchByName(Request $request)
{
    $query = $request->input('search');
    $users = User::where('name', 'like', '%' . $query . '%')->paginate(10); // Display 10 users per page

    return response()->json([
        'success' => true,
        'users' => $users
    ]);
}


    public function findEmail($email){
        return $this->userRepository->findEmail($email);
    }

    public function resetPassword($email){
        $user = User::where('email', $email)->first();
        $newPassword = Str::random(10);
        $user->password = bcrypt($newPassword);
        $user->save();
        Mail::to($user->email)->send(new ResetPasswordMail($newPassword));
        return 'Đã gửi mật khẩu mới đến bạn';
    }

    public function find($id)
    {
        return $this->userRepository->find($id);
    }
}