<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class VaccincePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name'          => 'view_vaccine',
            'guard_name'    => 'web'
        ]);

        Permission::create([
            'name'          => 'add_vaccine',
            'guard_name'    => 'web'
        ]);

        Permission::create([
            'name'          => 'edit_vaccine',
            'guard_name'    => 'web'
        ]);

        Permission::create([
            'name'          => 'delete_vaccine',
            'guard_name'    => 'web'
        ]);
    }
}
