<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'Admin',
                'password' => Hash::make('Admin'),
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'Admin1',
                'password' => Hash::make('Admin1'),
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'Admin3',
                'password' => Hash::make('Admin3'),
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
