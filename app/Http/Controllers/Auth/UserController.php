<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UserController extends Controller
{
    // Displays all Users
    public function ListAllUser()
    {
        // Fetch all the user roles
        $userRoles = Role::where('name', 'LIKE', 'user%')->get();

        // Get the users who have the user roles
        $allusers = User::whereHas('roles', function ($query) use ($userRoles) {
            $query->whereIn('name', $userRoles->pluck('name'));
        })->get();

        return view('auth.admin.user_management.view_users', compact('allusers'));
    }

    // Showing The User Adding Page
    public function AddNewUser()
    {

        return view('auth.admin.user_management.add_users');
    }

    // Store New User
    public function StoreNewUser(Request $request)
    {

        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required',
            'profile_image' => 'required|image|mimes:jpeg,jpg,png|max:2048'
        ])->validate();

        $imageName = time() . '_' . $request->file('profile_image')->getClientOriginalName();
        $imagePath = $request->file('profile_image')->storeAs('chatify/', $imageName, 'public');


        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender_type,
            'password' => bcrypt($request->password),
            'profile_image' => $imageName,
            'profile_image_path' => $imagePath,
        ]);

        $newUser->assignRole('user');

        return redirect()->route('show_users')->with('success', 'New User Added Successfully!');
    }

    // Delete User From Database
    public function DeleteUser($user_id)
    {
        $user = User::findOrFail($user_id);

        // Get the user's role
        $userRole = $user->roles->first();

        // Revoke the role before deleting the user
        if ($userRole) {
            $user->removeRole($userRole);
        }

        $image_path = $user->profile_image_path;
        $default_image_path = 'talkster/default_pp.png';

        $user->delete();
        if ($image_path) {
            // if there is image in the db
            if ($image_path != $default_image_path) {
                // if the image is not the default image then delete the image
                Storage::disk('public')->delete($image_path);
            }
        }

        return redirect()->route('show_users')->with('deleteSuccess', 'User has been deleted successfully!');
    }


    public function DisabledUserList()
    {
        // Fetch all the user roles
        $userRoles = Role::where('name', 'LIKE', 'user%')->get();

        // Get the users who have the user roles
        $allusers = User::where(function ($query) use ($userRoles) {
            $query->whereHas('roles', function ($roleQuery) use ($userRoles) {
                $roleQuery->whereIn('name', $userRoles->pluck('name'));
            })->where('account_status', false)
                ->whereNotNull('account_inactive_since');
        })->get();

        // dd($allusers);

        return view('auth.admin.user_management.account_disabled_users', compact('allusers'));
    }

    // Restore Disabled User Account
    public function EnableUserAccount($userid){
        $disabledAccount = User::find($userid);
        if($disabledAccount && !$disabledAccount->account_status){
            // Now reverting the account_status to true & also removing the account_inactive_since
            $disabledAccount->account_status = true;
            $disabledAccount->account_inactive_since = null;
            $disabledAccount->account_inactive_reason = null;
            $disabledAccount->save();
            toastr()->success('User has been restored successfully!', 'Restore Compete');
            return redirect()->route('show_inactive_users');
        }else{
            toastr()->error('User Not Found', 'Restore Failure');
            return redirect()->route('show_inactive_users');
        }
    }

    // Suspend / Ban / Disable User Account from admin dashboard.
    public function SuspendUserAccount($userid){
        $bannedAccount = User::find($userid);
        if($bannedAccount && $bannedAccount->account_status && $bannedAccount->account_inactive_since == null){
            $bannedAccount->account_status = false;
            $bannedAccount->account_inactive_since = Carbon::now();
            $bannedAccount->account_inactive_reason = "Admin Banned";
            $bannedAccount->save();
            toastr()->info('User has been disabled!', 'Account Disabled');
            return redirect()->route('show_inactive_users');

        }else{
            toastr()->error('Something went wrong!', 'Restore Failure');
            return redirect()->route('show_users');
        }
    }
}
