<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory(5)->create();

        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin12345'),
            'roles' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Kurir',
            'email' => 'kurir@gmail.com',
            'password' => Hash::make('kurir12345'),
            'roles' => 'kurir',
        ]);

        \App\Models\User::create([
            'name' => 'Pimpinan',
            'email' => 'pimpinan@gmail.com',
            'password' => Hash::make('pimpinan12345'),
            'roles' => 'pimpinan',
        ]);
    }
}
