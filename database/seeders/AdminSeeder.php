<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $admin = Admin::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ]);
        
            $admin->tokens()->create([
                'name' => 'Admin Token',
                'token' => hash('sha256', 'admin_token'),
                'abilities' => ['*'],
            ]);
        } catch(Exception $e) {
            error_log(json_encode($e->getMessage()));
        }
        
    }
}
