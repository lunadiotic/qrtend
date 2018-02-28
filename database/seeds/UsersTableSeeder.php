<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = ['name' => 'Admin', 'email' => 'admin@mail.com', 'password' => bcrypt('password'), 'role' => 'admin'];
        App\Models\User::create($admin);
        $employee = ['name' => 'Employee', 'email' => 'employee@mail.com', 'password' => bcrypt('password'), 'role' => 'employee'];
        App\Models\User::create($employee);
        
    }
}
