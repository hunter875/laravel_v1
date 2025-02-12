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
        if (!isset($data['role_id'])) {
            $data['role_id'] = 2;
        }

        return $this->userRepository->create($data);
    } catch (\Exception $e) {
        \Log::error('User creation failed: ' . $e->getMessage());
        return null;
    }
}


    public function update(UserRequest $request, $id)
{
    $data = $request->validated();
    $user = $this->userService->update($id, $data);

    if (!$user) {
        return back()->with('error', trans('msg.update_failed'));
    }

    return redirect()->route('users.index')->with('success', trans('msg.updated'));
}

    

    public function delete($id)
    {
        return $this->userRepository->delete($id);
    }

    public function searchByName($name){
        Log::info($name);
        return $this->userRepository->searchByName($name)->paginate(Constant::PAGINATE_DEFAULT);
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
}