<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User; // Make sure to import the User model
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('users')->count() == 0) {
            // Create admin user
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@realstate.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),

            ]);

            // Create admin role and assign to admin user
            $adminRole = Role::firstOrCreate(['name' => 'admin']);
            $admin->assignRole($adminRole);

            // Create normal user
            $user = User::create([
                'name' => 'User',
                'email' => 'user@realstate.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
            ]);

            // Create user role and assign to normal user
            $userRole = Role::firstOrCreate(['name' => 'user']);
            $user->assignRole($userRole);
        }
    }
}
