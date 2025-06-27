<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ClienteUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'cliente@turnero.com'],
            [
                'name' => 'Cliente',
                'password' => Hash::make('cliente123'),
                'role' => 'cliente',
                'nivel' => 'basico',
            ]
        );        
    }
}
