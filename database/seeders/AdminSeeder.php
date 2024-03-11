<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'name' => '1K',
                'email' => '1k@test.com',
                'password' => Hash::make('1K_yukari'),
                'created_at' => '2024-03-09 02:36:33',
                'updated_at' => '2024-03-09 02:36:33'
            ],
            [
                'name' => 'unoki',
                'email' => 'unoki@test.com',
                'password' => Hash::make('1K_yukari'),
                'created_at' => '2024-03-09 02:36:33',
                'updated_at' => '2024-03-09 02:36:33'
            ],
            [
                'name' => 'natsumi',
                'email' => 'natsumi@test.com',
                'password' => Hash::make('1K_yukari'),
                'created_at' => '2024-03-09 02:36:33',
                'updated_at' => '2024-03-09 02:36:33'
            ],
            
        ]);
    }
}
