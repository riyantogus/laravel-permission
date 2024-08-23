<?php

use App\Http\Controllers\Admin\Authentication\PermissionController;
use App\Http\Controllers\Admin\Authentication\RoleController;
use App\Http\Controllers\Admin\Authentication\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::redirect('/', '/admin');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Admin/Home/Index');
    })->name('admin-home.index');

    Route::middleware(['role:Super Admin'])->group(function () {
        // Authentication User
        Route::get('/user', [UserController::class, 'index'])->name('admin-user.index');
        Route::get('/user/create', [UserController::class, 'create'])->name('admin-user.create');
        Route::post('/user', [UserController::class, 'store'])->name('admin-user.store');
        Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('admin-user.edit');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('admin-user.update');
        Route::get('/user/reset-password/{id}/edit', [UserController::class, 'editPassword'])->name('admin-user.edit-password');
        Route::put('/user/reset-password/{id}', [UserController::class, 'updatePassword'])->name('admin-user.update-password');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('admin-user.destroy');

        // Authentication Role
        Route::get('/role', [RoleController::class, 'index'])->name('admin-role.index');
        Route::get('/role/create', [RoleController::class, 'create'])->name('admin-role.create');
        Route::post('/role', [RoleController::class, 'store'])->name('admin-role.store');
        Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('admin-role.edit');
        Route::put('/role/{id}', [RoleController::class, 'update'])->name('admin-role.update');
        Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('admin-role.destroy');

        // Authentication Permission
        Route::get('/permission', [PermissionController::class, 'index'])->name('admin-permission.index');
        Route::get('/permission/create', [PermissionController::class, 'create'])->name('admin-permission.create');
        Route::post('/permission', [PermissionController::class, 'store'])->name('admin-permission.store');
        Route::get('/permission/{id}/edit', [PermissionController::class, 'edit'])->name('admin-permission.edit');
        Route::put('/permission/{id}', [PermissionController::class, 'update'])->name('admin-permission.update');
        Route::delete('/permission/{id}', [PermissionController::class, 'destroy'])->name('admin-permission.destroy');
    });
});

require __DIR__ . '/auth.php';
