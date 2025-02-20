<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RoleRepositoryInterface;
use App\Models\User;

class RoleController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        // Sử dụng policy để kiểm tra quyền truy cập
        $this->authorize('accessAdmin', User::class);

        $roles = $this->roleRepository->all();
        return view('roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('accessAdmin', User::class);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        $this->roleRepository->create($validatedData);

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully.');
    }

    public function update(Request $request, $id)
    {
        $this->authorize('accessAdmin', User::class);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
        ]);

        $this->roleRepository->update($id, $validatedData);

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $this->authorize('accessAdmin', User::class);

        $deleted = $this->roleRepository->delete($id);

        $message = $deleted
            ? 'Role deleted successfully.'
            : 'Role cannot be deleted because it is associated with users or hotels.';
        $status = $deleted ? 'success' : 'error';

        return redirect()->route('roles.index')->with($status, $message);
    }
}
