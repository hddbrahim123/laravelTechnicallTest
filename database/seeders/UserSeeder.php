<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name'=>'admin',
            'email'=>'admin@admin.com',
            'password'=>Hash::make('123456789')
        ]);


        $roleAdmin = Role::whereName('admin')->first();
        $admin->roles()->syncWithoutDetaching($roleAdmin);

        $user = User::create([
            'name'=>'user',
            'email'=>'user@user.com',
            'password'=>Hash::make('123456789')
        ]);

        $roleUser = Role::whereName('user')->first();
        $user->roles()->syncWithoutDetaching($roleUser);

        
    }
}
