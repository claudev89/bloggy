<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear Roles
        $role_admin = Role::create(['name' => 'admin']);
        $role_blogger = Role::create(['name' => 'blogger']);
        $role_moderator = Role::create(['name' => 'mod']);

        // Crear permisos
        $permission_create_post = Permission::create(['name' => 'create post']);
        $permission_update_post = Permission::create(['name' => 'update post']);
        $permission_delete_post = Permission::create(['name' => 'delete post']);

        $permission_approve_post = Permission::create(['name' => 'approve post']);
        $permission_discard_post = Permission::create(['name' => 'discard post']);

        $permission_delete_comment = Permission::create(['name' => 'delete comment']);

        // Asignar permisos a roles
        $permissions_admin = [$permission_create_post, $permission_update_post, $permission_delete_post,
            $permission_approve_post, $permission_discard_post, $permission_delete_comment];

        $permissions_moderator = [$permission_approve_post, $permission_discard_post, $permission_delete_comment];

        $permissions_blogger = [$permission_create_post, $permission_update_post, $permission_delete_post];

        // Sincronizar roles y permisos
        $role_admin->syncPermissions($permissions_admin);
        $role_blogger->syncPermissions($permissions_blogger);
        $role_moderator->syncPermissions($permissions_moderator);
    }
}
