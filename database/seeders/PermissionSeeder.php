<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            ['name' => 'Avaliable_books', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'borrowed_books', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
$adminRole = Role::where('name', 'Admin')->first();
$librarianRole = Role::where('name', 'Librarian')->first();
$memberRole = Role::where('name', 'Member')->first();

$manageBooksPermission = Permission::where('name', 'manage_books')->first();
$manageUsersPermission = Permission::where('name', 'manage_users')->first();
$borrowBooksPermission = Permission::where('name', 'borrow_books')->first();

// Assign Permissions to Admin
$adminRole->permissions()->attach([$manageBooksPermission->id, $manageUsersPermission->id]);

// Assign Permissions to Librarian
$librarianRole->permissions()->attach([$manageBooksPermission->id]);

// Assign Permissions to Member
$memberRole->permissions()->attach([$borrowBooksPermission->id]);

    }

    
}
