<?php

namespace App\Http\Controllers\Admin\Authentication;

use App\Contracts\Authentication\PermissionInterface;
use App\Contracts\Authentication\RoleInterface;
use App\Contracts\Authentication\UserInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use App\Models\User;

class UserController extends Controller
{
    protected $userRepo;
    protected $permissionRepo;
    protected $roleRepo;

    public function __construct(UserInterface $userRepo, PermissionInterface $permissionRepo, RoleInterface $roleRepo)
    {
        $this->userRepo = $userRepo;
        $this->permissionRepo = $permissionRepo;
        $this->roleRepo = $roleRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = $this->userRepo->paginate($request);

        return Inertia::render('Admin/Authentication/User/Index', [
            'users' => $users,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->roleRepo->findWithPermissions();
        $permissions = $this->permissionRepo->findAll();

        return Inertia::render('Admin/Authentication/User/Create', [
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:' . User::class,
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', Password::min(8), 'confirmed'],
            'password_confirmation' => 'required',
            'role' => 'required',
        ]);

        if (!$user = $this->userRepo->create($request)) {
            return back()->with('error', 'User gagal disimpan. Silahkan coba lagi!');
        }

        if (!$user->assignRole($request->role)) {
            return back()->with('error', 'Role gagal disimpan. Silahkan coba lagi!');
        }

        return redirect()->route('admin-user.index')->with('success', 'User berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!$user = $this->userRepo->findById($id)) {
            return redirect()->route('admin-user.index')->with('error', 'User tidak ditemukan. Silahkan coba lagi!');
        }

        $user->role = $user->getRoleNames()->first();
        $selectedPermissions = $user->getAllPermissions()->pluck('name');

        $roles = $this->roleRepo->findWithPermissions();
        $permissions = $this->permissionRepo->findAll();

        return Inertia::render('Admin/Authentication/User/Edit', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'selectedPermissions' => $selectedPermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255',
            'role' => 'required',
        ]);

        if (!$user = $this->userRepo->findById($id)) {
            return back()->with('error', 'User tidak ditemukan. Silahkan coba lagi!');
        }

        if (!$this->userRepo->update($id, $request)) {
            return back()->with('error', 'User gagal diupdate. Silahkan coba lagi!');
        }

        if (!$user->syncRoles($request->role)) {
            return back()->with('error', 'Role gagal diupdate. Silahkan coba lagi!');
        }

        return redirect()->route('admin-user.index')->with('success', 'User berhasil diupdate!');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function editPassword(string $id)
    {
        if (!$user = $this->userRepo->findById($id)) {
            return redirect()->route('admin-user.index')->with('error', 'User tidak ditemukan. Silahkan coba lagi!');
        }

        return Inertia::render('Admin/Authentication/User/ResetPassword', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePassword(Request $request, string $id)
    {
        $request->validate([
            'password' => ['required', Password::min(8), 'confirmed'],
            'password_confirmation' => 'required',
        ]);

        if (!$this->userRepo->resetPassword($id, $request)) {
            return back()->with('error', 'Password gagal diupdate. Silahkan coba lagi!');
        }

        return redirect()->route('admin-user.index')->with('success', 'Password berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$user = $this->userRepo->findById($id)) {
            return back()->with('error', 'User tidak ditemukan. Silahkan coba lagi!');
        }

        if (!$user->delete($id)) {
            return back()->with('error', 'User gagal dihapus. Silahkan coba lagi!');
        }

        if (!$user->syncRoles([])) {
            return back()->with('error', 'Role user gagal dihapus. Silahkan coba lagi!');
        }

        return redirect()->route('admin-user.index')->with('success', 'User berhasil dihapus!');
    }
}
