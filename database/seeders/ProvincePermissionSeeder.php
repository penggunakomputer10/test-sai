<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ProvincePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name'          => 'view_province',
            'guard_name'    => 'web'
        ]);

        Permission::create([
            'name'          => 'add_province',
            'guard_name'    => 'web'
        ]);

        Permission::create([
            'name'          => 'edit_province',
            'guard_name'    => 'web'
        ]);

        Permission::create([
            'name'          => 'delete_province',
            'guard_name'    => 'web'
        ]);
    }
}
