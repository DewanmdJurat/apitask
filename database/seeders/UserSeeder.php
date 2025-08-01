<?php

namespace Database\Seeders;

use App\Models\Role;
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

        DB::table('users')->truncate();
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        $editor = User::create([
            'name' => 'Editor User',
            'email' => 'editor@example.com',
            'password' => Hash::make('password123'),
        ]);

        $author = User::create([
            'name' => 'Author User',
            'email' => 'author@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Assign roles by name
        $admin->roles()->syncWithoutDetaching([
            Role::where('name', 'admin')->first()->id
        ]);

        $editor->roles()->syncWithoutDetaching([
            Role::where('name', 'editor')->first()->id
        ]);

        $author->roles()->syncWithoutDetaching([
            Role::where('name', 'author')->first()->id
        ]);
    }
}
