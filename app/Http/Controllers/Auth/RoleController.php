<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// using the roles and permission spatie model
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    //Creating Permissions

    public function AllRolesAndPermission(){
        // $permissions = Permission::all();
        $roles = Role::all();
        return view('auth.admin.permission.all_roles', compact('roles'));

    }
    public function AllPermission(){
        // $permissions = Permission::all();
        $permissions = Permission::all();
        return view('auth.admin.permission.all_permission', compact('permissions'));

    }

    // public function AddPermission(){
    //     return view('auth.admin.permission.add_permission');
    // }

    // public function StorePermission(Request $request){
    //     // creating new roles with permission

    //     $permission = Permission::create(['name' => 'edit articles']);

    // }
}
