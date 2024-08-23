<?php

namespace App\Http\Controllers\Admin\Authentication;

use App\Contracts\Authentication\PermissionInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Permission;

class PermissionController extends Controller
{
    protected $permissionRepo;

    public function __construct(PermissionInterface $permissionRepo)
    {
        $this->permissionRepo = $permissionRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permissions = $this->permissionRepo->paginate($request);

        return Inertia::render('Admin/Authentication/Permission/Index', [
            'permissions' => $permissions,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Authentication/Permission/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:' . Permission::class,
        ]);

        if (!$this->permissionRepo->create($request->name)) {
            return back()->with('error', 'Permission gagal disimpan. Silahkan coba lagi!');
        }

        return redirect()->route('admin-permission.index')->with('success', 'Permission berhasil disimpan!');
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
        if (!$permission = $this->permissionRepo->findById($id)) {
            return redirect()->route('admin-permission.index')->with('error', 'Permission tidak ditemukan. Silahkan coba lagi!');
        }

        return Inertia::render('Admin/Authentication/Permission/Edit', [
            'permission' => $permission,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:' . Permission::class,
        ]);

        if (!$this->permissionRepo->findById($id)) {
            return back()->with('error', 'Permission tidak ditemukan. Silahkan coba lagi!');
        }

        if (!$this->permissionRepo->update($id, $request->name)) {
            return back()->with('error', 'Permission gagal diupdate. Silahkan coba lagi!');
        }

        return redirect()->route('admin-permission.index')->with('success', 'Permission berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$this->permissionRepo->findById($id)) {
            return back()->with('error', 'Permission tidak ditemukan. Silahkan coba lagi!');
        }

        if (!$this->permissionRepo->delete($id)) {
            return back()->with('error', 'Permission gagal dihapus. Silahkan coba lagi!');
        }

        return redirect()->route('admin-permission.index')->with('success', 'Permission berhasil dihapus!');
    }
}
