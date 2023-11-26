<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yoeunes\Toastr\Facades\Toastr;

class UserProfileController extends Controller
{

    // Display the user profile page
    public function ShowUserProfile()
    {
        return view('auth.frontend.user.user_profile');
    }

    // Updating the user profile picture
    public function UpdateProfilePicture(Request $request)
    {
        $user_id = auth()->user()->id;
        $user = User::findOrFail($user_id);
        Validator::make($request->all(), [
            'profile_image' => 'required|image|mimes:jpeg,jpg,png|max:2048'
        ])->validate();

        // We are saving the default image from getting deleted.
        if ($user->profile_image_path != 'chatify/default_pp.png') {
            // Deleting the profile image if exists
            if ($user->profile_image_path && Storage::exists('public/' . $user->profile_image_path)) {
                Storage::delete('public/' . $user->profile_image_path);
            }
        }

        // Upload the new image with a custom name
        $image = $request->file('profile_image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = $image->storeAs('chatify/users', $imageName, 'public');

        // Update the course image details
        $user->profile_image = $imageName;
        $user->profile_image_path = $imagePath;

        $user->save();
        toastr()->success('Profile Picture has been updated!', 'Nice!');
        // return redirect()->route('userProfile')->with('updateSuccess', 'Profile Picture has been updated!');
        return redirect()->route('userProfile');
    }

    // Updating User Additional Profile Information
    public function UpdateProfileInfo(Request $request)
    {
        $user_id = auth()->user()->id;
        $user = User::findOrFail($user_id);
        $validatedData = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|numeric|digits:10',
            'address' => 'required',
            'city' => 'required',
            'user_bio' => 'required|max:25',
            'gender' => [
                'required',
                Rule::in(['male', 'female', 'other']),
            ],
        ])->validate();
        $user->name = $validatedData['first_name'] . ' ' . $validatedData['last_name'];
        $user->update($validatedData);
        // toastr()->success('Your information has been updated!', 'Congrats');
        Toastr::success('Profile has been updated!','Done',["positionClass" => "toast-top-center"]);
        return redirect()->route('userProfile');
    }

    //User Password Change Page
    public function ChangePassword()
    {
        return view('auth.frontend.user.change_password');
    }

    public function UpdatePassword(Request $request)
    {
        $user_id = auth()->user()->id;
        $user = User::findOrFail($user_id);

        $user_current_password = $user->password;
        $entered_current_password = $request->old_password;

        // Validating the request data entered by user
        Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|same:confirm_password',
            'confirm_password' => 'required|same:new_password',
        ])->validate();

        // Verify the current password
        if (!Hash::check($entered_current_password, $user_current_password)) {
            // toastr()->error('Current Password Do Not Match', 'Update Failed');
            Toastr::error('Current Password Do Not Match!','Failed',["positionClass" => "toast-top-center"]);

            return redirect()->back();
        }

        //Encrypting the password
        $user->password = Hash::make($request->input('new_password'));

        // Updating the password
        $user->save();
        // toastr()->success('Password has been changed!', 'Update Success');
        Toastr::success('Password has been updated!','Done',["positionClass" => "toast-top-center"]);

        return redirect()->back();
    }


    // Showing Search Friends Page With Suggested Friends
    public function SearchFriends()
    {
        // Get the authenticated user ID for preventing self suggestation
        $authenticatedUserId = auth()->id();

        // Get the "user" role model using the Spatie Permission package
        $userRole = Role::where('name', 'user')->first();

        // Query random suggested users who have the "user" role and exclude the authenticated user
        $suggestedUsers = $userRole->users()
            ->where('id', '!=', $authenticatedUserId)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('auth.frontend.user.friend.search_friends');
        // return view('livewire.friend-searchbar');
    }
}
