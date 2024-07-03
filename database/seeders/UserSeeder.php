<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon as Carbon;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('users')->count() == 0) {
            DB::table('users')->insert([
                [
                    'name' => 'Super Admin',
                    'email' => 'superadmin@realstate.com',
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::make('password'),
                    'role' => 'admin',
                ],
            ]);
            DB::table('users')->insert([
                [
                    'name' => 'User',
                    'email' => 'user@realstate.com',
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::make('password'),
                    'role' => 'user',
                ],
            ]);
        }
    }
}
