<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
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
        $role = Role::create(['name' => 'Super Admin']);

        $role->givePermissionTo($this->permissions);
    }
}
