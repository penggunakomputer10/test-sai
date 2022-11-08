<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class AccountAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name'      => 'admin',
            'email'     => 'admin@mail.com',
            'password'  => bcrypt('admin123'),
            'role_id'   => 1
        ]);

        $admin->assignRole('admin');

    }
}
