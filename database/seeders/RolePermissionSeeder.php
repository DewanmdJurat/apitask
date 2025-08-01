<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        $admin = Role::create(['name' => 'admin']);
        $editor = Role::create(['name' => 'editor']);
        $author = Role::create(['name' => 'author']);

        $permissions = [
            'view-all-users',
            'assign-roles',
            'create-article',
            'edit-own-article',
            'publish-article',
            'delete-article',
            'view-published',
            'view-own-articles'
        ];

        foreach ($permissions as $perm) {
            Permission::create(['name' => $perm]);
        }

        $admin->permissions()->sync(
            Permission::whereIn('name', [
                'view-all-users',
                'assign-roles',
                'publish-article',
                'delete-article',
                'view-published',
            ])->pluck('id')->toArray()
        );

        $editor->permissions()->sync(
            Permission::whereIn('name', [
                'publish-article',
                'view-published',
            ])->pluck('id')->toArray()
        );

        $author->permissions()->sync(
            Permission::whereIn('name', [
                'create-article',
                'edit-own-article',
                'view-own-articles',
                'view-published',
            ])->pluck('id')->toArray()
        );

    }
}
