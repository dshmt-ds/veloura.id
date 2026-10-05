<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@veloura.com',
            ],
            [
                'name' => 'Admin Veloura',
                'phone' => '081234567890',
                'role' => 'admin',
                'password' => Hash::make('Admin@12345'),
            ]
        );
    }
}
