<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SetGroupPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin  = Role::find(1);
        $admin->givePermissionTo(
            [
            'view_dashboard',
            'view_user_group',
            'add_user_group',
            'edit_user_group',
            'delete_user_group',
            'permission_user_group',
            'view_user',
            'add_user',
            'edit_user',
            'delete_user',
            'general_setting',
            'view_province',
            'add_province',
            'edit_province',
            'delete_province',
            'view_city',
            'add_city',
            'edit_city',
            'delete_city',
            ]
        );
    }
}
