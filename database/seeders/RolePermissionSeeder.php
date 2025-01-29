<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin-blog']);
        Permission::create(['name' => 'admin-page']);
        Permission::create(['name' => 'admin-user']);

        $roleAdmin = Role::findByName('admin');

        $roleAdmin->givePermissionTo('admin-blog');
        $roleAdmin->givePermissionTo('admin-page');
        $roleAdmin->givePermissionTo('admin-user');
    }
}
