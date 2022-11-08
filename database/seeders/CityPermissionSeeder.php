<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CityPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name'          => 'view_city',
            'guard_name'    => 'web'
        ]);

        Permission::create([
            'name'          => 'add_city',
            'guard_name'    => 'web'
        ]);

        Permission::create([
            'name'          => 'edit_city',
            'guard_name'    => 'web'
        ]);

        Permission::create([
            'name'          => 'delete_city',
            'guard_name'    => 'web'
        ]);
    }
}
