<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class FaskesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name'          => 'view_faskes',
            'guard_name'    => 'web'
        ]);

        Permission::create([
            'name'          => 'add_faskes',
            'guard_name'    => 'web'
        ]);

        Permission::create([
            'name'          => 'edit_faskes',
            'guard_name'    => 'web'
        ]);

        Permission::create([
            'name'          => 'delete_faskes',
            'guard_name'    => 'web'
        ]);
    }
}
