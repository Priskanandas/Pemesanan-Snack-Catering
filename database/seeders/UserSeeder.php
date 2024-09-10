<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        User::create([
            'first_name'=>'Suryati',
            'last_name'=>'Suryati',
            'username'=>'admin',
            'role'=>'admin',
            'email'=>'admin@gmail.com',
            'gender'=>'female',
            'tgl_lahir'=>'1976-06-04',
            'password'=>Hash::make('admin123')
        ]);
    }
}
