<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name'=>'Super Admin'
        ]);
        Role::create([
            'name'=>'HR Admin'
        ]);
        Role::create([
            'name'=>'PM Teacher'
        ]);
        Role::create([
            'name'=>'User'
        ]);
        User::create([
            'name'=>'Mr Admin',
            'role_id' => 1,
            'employee_id' => 1,
            'email'=>'admin@gmail.com',
            'password'=> Hash::make('123456'),
            'active_status' => 1,
            'created_at' => now(),
        ]);
    }
}
