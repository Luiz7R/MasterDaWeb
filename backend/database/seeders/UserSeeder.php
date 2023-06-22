<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(['email' => 'johndoe@example.net'], [
            'name' => 'John Doe',
            'password' => bcrypt('12345678'),
        ]);

        User::firstOrCreate(['email' => 'johndoe@admin.net'], [
            'name' => 'John Admin Doe',
            'password' => bcrypt('12345678'),
            'user_type' => 1
        ]);
    }
}
