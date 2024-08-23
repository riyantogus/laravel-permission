<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * List of applications to add.
     */
    private $permissions = [
        'create users',
        'edit users',
        'delete users',
        'create permissions',
        'edit permissions',
        'delete permissions',
        'create roles',
        'edit roles',
        'delete roles'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
