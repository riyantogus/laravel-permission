<?php

namespace App\Http\Controllers\Admin\Authentication;

use App\Contracts\Authentication\PermissionInterface;
use App\Contracts\Authentication\RoleInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Role;

class RoleController extends Controller
{
    protected $permissionRepo;
    protected $roleRepo;

    public function __construct(PermissionInterface $permissionRepo, RoleInterface $roleRepo)
    {
        $this->permissionRepo = $permissionRepo;
        $this->roleRepo = $roleRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = $this->roleRepo->paginate($request);

        return Inertia::render('Admin/Authentication/Role/Index', [
            'roles' => $roles,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = $this->permissionRepo->findAll();

        return Inertia::render('Admin/Authentication/Role/Create', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:' . Role::class,
        ]);

        if (!$role = $this->roleRepo->create($request->name)) {
            return back()->with('error', 'Role gagal disimpan. Silahkan coba lagi!');
        }

        if (!$role->givePermissionTo($request->permissions)) {
            return back()->with('error', 'Permission gagal disimpan. Silahkan coba lagi!');
        }

        return redirect()->route('admin-role.index')->with('success', 'Role berhasil disimpan!');
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
        if (!$role = $this->roleRepo->findById($id)) {
            return redirect()->route('admin-role.index')->with('error', 'Role tidak ditemukan. Silahkan coba lagi!');
        }

        $permissions = $this->permissionRepo->findAll();
        $rolePermissions = $role->permissions->pluck('name');

        return Inertia::render('Admin/Authentication/Role/Edit', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if (!$role = $this->roleRepo->findById($id)) {
            return back()->with('error', 'Role tidak ditemukan. Silahkan coba lagi!');
        }

        if (!$this->roleRepo->update($id, $request->name)) {
            return back()->with('error', 'Role gagal diupdate. Silahkan coba lagi!');
        }

        if (!$role->syncPermissions($request->permissions)) {
            return back()->with('error', 'Role permissions gagal diupdate. Silahkan coba lagi!');
        }

        return redirect()->route('admin-role.index')->with('success', 'Role berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$this->roleRepo->findById($id)) {
            return back()->with('error', 'Role tidak ditemukan. Silahkan coba lagi!');
        }

        if (!$this->roleRepo->delete($id)) {
            return back()->with('error', 'Role gagal dihapus. Silahkan coba lagi!');
        }

        return redirect()->route('admin-role.index')->with('success', 'Permission berhasil dihapus!');
    }
}
