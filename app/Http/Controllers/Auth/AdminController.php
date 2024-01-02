<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // Showing the Admin Dashboard
    public function ShowDashboard()
    {
        $totalUser = Role::where('name', 'user')->first()->users->count();
        $totalAdmin = Role::whereIn('name', ['superadmin', 'admin'])->get()->pluck('users')->flatten()->count();

        $emailVerifiedUsers = User::whereNotNull('email_verified_at')->count();

        $emailVerifiedPercentage = number_format(($emailVerifiedUsers / $totalUser) * 100, 0); // Formats to 0 decimal places just like absolute value.



        // dd($emailVerifiedUsers);

        // toastr()->success('Welcome Chief!', 'Admin Login');
        return view('auth.admin.dashboard', compact('totalUser', 'totalAdmin', 'emailVerifiedPercentage'));
    }

    // Showing the Admin Profile Page
    public function ShowProfile()
    {
        return view('auth.admin.profile');
    }

    // Updating the Admin Profile Page
    public function UpdateProfile(Request $request)
    {

        $admin = User::findOrFail($request->input('id'));

        // Validate the input fields
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'gender' => 'required|in:male,female,other',
        ]);

        // Compare the new input values with the old values
        $updatedFields = [];

        if ($admin->name !== $request->input('name')) {
            $admin->name = $request->input('name');
            $updatedFields['name'] = $request->input('name');
        }

        if ($admin->phone !== $request->input('phone')) {
            $admin->phone = $request->input('phone');
            $updatedFields['phone'] = $request->input('phone');
        }

        if ($admin->gender !== $request->input('gender')) {
            $admin->gender = $request->input('gender');
            $updatedFields['gender'] = $request->input('gender');
        }

        // Check if any fields were updated
        if (!empty($updatedFields)) {
            $admin->save();
            return redirect()->back()->with('updateSuccess', 'Admin profile has been updated successfully.');
        } else {
            return redirect()->back()->with('info', 'No changes were made to the Admin profile.');
        }
    }

    // Showing Add the Admins in admin page
    public function ListAllAdmin()
    {
        // Fetch all the admin roles
        $adminRoles = Role::where('name', 'LIKE', '%admin')->get();

        // Get the users who have the admin roles
        $admins = User::whereHas('roles', function ($query) use ($adminRoles) {
            $query->whereIn('name', $adminRoles->pluck('name'));
        })->get();

        return view('auth.admin.admin_management.view_admin', compact('admins'));
    }

    // Creating new Admin
    public function AddNewAdmin()
    {
        return view('auth.admin.admin_management.add_admin');
    }


    // store new admins
    public function StoreNewAdmin(Request $request)
    {

        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required',
            'profile_image' => 'required|image|mimes:jpeg,jpg,png|max:2048'
        ])->validate();

        $imageName = time() . '_' . $request->file('profile_image')->getClientOriginalName();
        $imagePath = $request->file('profile_image')->storeAs('chatify/admins/', $imageName, 'public');


        $newAdmin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'profile_image' => $imageName,
            'profile_image_path' => $imagePath,
        ]);

        $role_status = $request->role_type;
        if ($role_status == 'superadmin') {

            $newAdmin->assignRole('superadmin');
        } else {
            $newAdmin->assignRole('admin');
        }

        return redirect()->route('show_admins')->with('success', 'New Admin Added Successfully!');
    }

    // Showing the Edit admin Page with data
    public function EditNewAdmin($admin_id)
    {
        $adminData = User::findOrFail($admin_id);
        return view('auth.admin.admin_management.edit_admin')->with('adminData', $adminData);
    }

    //Update and store Admin
    public function UpdateNewAdmin(Request $request, $admin_id)
    {
        $admin = User::findOrFail($admin_id);
        Validator::make($request->all(), [
            'name' => 'required',
        ])->validate();

        // Compare the new input values with the old values
        $updatedFields = [];

        if ($admin->name !== $request->input('name')) {
            $admin->name = $request->input('name');
            $updatedFields['name'] = $request->input('name');
        }

        if ($admin->email !== $request->input('email')) {
            $admin->email = $request->input('email');
            $updatedFields['email'] = $request->input('email');
        }

        if ($admin->phone !== $request->input('phone')) {
            $admin->phone = $request->input('phone');
            $updatedFields['phone'] = $request->input('phone');
        }

        if ($request->has('role_type')) {
            $newRoleType = $request->input('role_type');
            // storing old role name
            $old_role = $admin->getRoleNames()[0];
            if ($old_role != $newRoleType) {
                $updatedFields['role_type'] = $newRoleType;
                $admin->removeRole($old_role);
                $admin->assignRole($newRoleType);
            }
        }

        // Check if a new image is uploaded
        if ($request->hasFile('profile_image')) {
            //  Preventing the Default image to be deleted if user is using default image.
            if ($admin->profile_image_path != 'talkster/default_pp.png') {
                // Deleting the profile image if exists
                if ($admin->profile_image_path && Storage::exists('public/' . $admin->profile_image_path)) {
                    Storage::delete('public/' . $admin->profile_image_path);
                }
            }

            // Upload the new image with a custom name
            $image = $request->file('profile_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('chatify/admins/', $imageName, 'public');

            // Update the course image details
            $admin->profile_image = $imageName;
            $admin->profile_image_path = $imagePath;
            $updatedFields['profile_image'] = $imageName;
            $updatedFields['profile_image_path'] = $imagePath;
        }

        // Add other fields comparisons as needed
        // Check if the image fields have been modified
        $imageFieldsModified = $admin->isDirty('course_image') || $admin->isDirty('course_image_path');



        // Check if any fields were updated
        // if ($admin->isDirty()) {
        if (!empty($updatedFields) || $imageFieldsModified) {
            $admin->save();

            return redirect()->route('show_admins')->with('updateSuccess', 'Admin has been updated successfully.');
        } else {
            return redirect()->route('show_admins')->with('info', 'No changes were made to the Admins.');
        }
    }

    //Delete Admin
    public function DeleteAdmin($admin_id)
    {

        $admin = User::findOrFail($admin_id);

        // Get the admin's role
        $adminRole = $admin->roles->first();

        // Revoke the role before deleting the admin
        if ($adminRole) {
            $admin->removeRole($adminRole);
        }

        $image_path = $admin->profile_image_path;
        $default_image_path = 'talkster/default_pp.png';

        $admin->delete();
        if ($image_path) {
            // if there is image in the db
            if ($image_path != $default_image_path) {
                // if the image is not the default image then delete the image
                Storage::disk('public')->delete($image_path);
            }
        }

        return redirect()->route('show_admins')->with('deleteSuccess', 'Admin has been deleted successfully!');
    }


    // Display Admin Profile Password Page
    public function ChangePasswordArea()
    {
        return view('auth.admin.change_password');
    }

    // Updating Admin Profile Password
    public function UpdatePassword(Request $request, $admin_id)
    {
        // Getting the authenticated admin id
        $admin = User::findOrFail($admin_id);

        $admin_current_password = $admin->password;
        $entered_current_password = $request->old_password;

        // Validating the request data entered by admin
        Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|same:confirm_password',
            'confirm_password' => 'required|same:new_password',
        ])->validate();


        // Verify the current password
        if (!Hash::check($entered_current_password, $admin_current_password)) {
            return redirect()->back()->with('error', 'Current Password Do Not Match');
        }

        //Encrypting the password
        $admin->password = Hash::make($request->input('new_password'));

        // Updating the password
        $admin->save();

        return redirect()->back()->with('updateSuccess', 'Password updated successfully.');
    }
}
