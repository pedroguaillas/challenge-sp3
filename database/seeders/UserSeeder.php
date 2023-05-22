<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::create([
            'name' => 'Pedro Guaillas Admin',
            'email' => 'peter.tufi@gmail.com',
            'password' => Hash::make('Password')
        ]);

        User::create([
            'name' => 'Pedro Guaillas Operativo',
            'email' => 'peter.tufi1@gmail.com',
            'password' => Hash::make('Password')
        ]);
    }
}
