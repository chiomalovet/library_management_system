<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin3@example.com',
            'password' => bcrypt('password'),
        ]);

        $librarian = User::create([
            'name' => 'Librarian User',
            'email' => 'librarian3@example.com',
            'password' => bcrypt('password'),
        ]);

        $member = User::create([
            'name' => 'Member User',
            'email' => 'member3@example.com',
            'password' => bcrypt('password'),
        ]);

        // Assign roles to users
        $admin->role()->attach(Role::where('name', 'Admin')->first());
        $librarian->role()->attach(Role::where('name', 'Librarian')->first());
        $member->role()->attach(Role::where('name', 'Member')->first());
    }
}
