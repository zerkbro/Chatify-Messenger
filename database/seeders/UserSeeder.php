<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user related permission
        // $user_list = Permission::create(['name'=>'users_list']);
        $user_create = Permission::create(['name'=>'user_create', 'group_name' => 'user_group']);
        $user_view = Permission::create(['name'=>'user_view', 'group_name' => 'user_group']);
        $user_update = Permission::create(['name'=>'user_update', 'group_name' => 'user_group']);
        $user_delete = Permission::create(['name'=>'user_delete', 'group_name' => 'user_group']);
        $user_all = Permission::create(['name'=>'user_all', 'group_name' => 'user_group']);


        // admin related permission
        $admin_create = Permission::create(['name'=>'admin_create', 'group_name' => 'admin_group']);
        $admin_view = Permission::create(['name'=>'admin_view', 'group_name' => 'admin_group']);
        $admin_update = Permission::create(['name'=>'admin_update', 'group_name' => 'admin_group']);
        $admin_delete = Permission::create(['name'=>'admin_delete', 'group_name' => 'admin_group']);
        $admin_all = Permission::create(['name'=>'admin_all', 'group_name' => 'admin_group']);

        // creating admin role
        $super_admin_role = Role::create(['name' => 'superadmin']);

        $super_admin_role->givePermissionTo([
            // Granting All Permission related to User
            $user_create,
            $user_view,
            $user_update,
            $user_delete,
            $user_all,

            // Granting All Permission related to Admin
            $admin_create,
            $admin_view,
            $admin_update,
            $admin_delete,
            $admin_all,

        ]);

        $super_admin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.com',
            'password' => bcrypt('password'),
            // 'role' => 'superadmin'
            'phone' => '9812345678',
            'profile_image'=> 'default_pp.png',
            'profile_image_path' => 'chatify/default_pp.png',
        ]);

        $super_admin->assignRole($super_admin_role);



        $admin_role = Role::create(['name' => 'admin']);


        $admin_role->givePermissionTo([
            $user_create,
            $user_view,
            $user_update,
            $user_delete,
            $user_all,
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            // 'role' => 'admin',
            'password' => bcrypt('password'),
            'phone' => '9812345678',
            'profile_image'=> 'default_pp.png',
            'profile_image_path' => 'chatify/default_pp.png',
        ]);

        $admin->assignRole($admin_role);
        $admin->givePermissionTo([
            $user_create,
            $user_view,
            $user_update,
            $user_delete,
            $user_all,
        ]);


        // creating user role
        $user_role = Role::create(['name' => 'user']);

        $user = User::create([
            'name' => 'Simple User',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
            // 'role' => 'user',
            'phone' => '9812345678',
            'profile_image'=> 'default_pp.png',
            'profile_image_path' => 'chatify/default_pp.png',
        ]);

        $user->assignRole($user_role);
        $user->givePermissionTo([
            // $user_list,
            $user_view,
        ]);


    }
}
