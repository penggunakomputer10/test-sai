<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name'          => 'view_user',
            'guard_name'    => 'web'
        ]);

        Permission::create([
            'name'          => 'add_user',
            'guard_name'    => 'web'
        ]);

        Permission::create([
            'name'          => 'edit_user',
            'guard_name'    => 'web'
        ]);

        Permission::create([
            'name'          => 'delete_user',
            'guard_name'    => 'web'
        ]);

        Permission::create([
            'name'          => 'permission_user',
            'guard_name'    => 'web'
        ]);
    }
}
