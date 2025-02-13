<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RoleRepositoryInterface;

class RoleController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $roles = $this->roleRepository->all();
        return view('roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        $this->roleRepository->create($request->all());

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
        ]);

        $this->roleRepository->update($id, $request->all());

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $deleted = $this->roleRepository->delete($id);

        if ($deleted) {
            return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
        } else {
            return redirect()->route('roles.index')->with('error', 'Role cannot be deleted because it is associated with users or hotels.');
        }
    }
}
