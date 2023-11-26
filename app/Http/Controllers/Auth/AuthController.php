<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\EmailVerificationJob;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
// This is the email verification namespace
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.frontend.login');
    }

    public function showRegisterPage()
    {
        return view('auth.frontend.register');
    }

    // user registration
    public function registerSave(Request $request)
    {
        Validator::make($request->all(), [
            // 'username' => 'required|min:5',
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'email' => 'required|email|unique:users',
            'password' => 'required|same:password_confirmation',
            'password_confirmation' => 'required|same:password'
        ])->validate();

        $name = $request->first_name.' '.$request->last_name;
        $user = User::create([
            'name'=> $name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_image' => 'default_pp.png',
            'profile_image_path' => 'chatify/default_pp.png',
            // 'level' => 'Admin'
        ]);

        $user->assignRole('user');
        // event(new Registered($user));

        dispatch(new EmailVerificationJob($user));
        toastr()->success('Your account has been registered!', 'Congratulations!');
        return redirect()->route('user_login')->with('updateSuccess', 'Your account has been registered');
    }

    // verifying the login
    public function loginVerify(Request $request){
        // dd($request->all());
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        $credentials = $request->only('email', 'password');

        // If the user credintials does not match then this shows the error message other wise user is logged in
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
                'password' => trans('auth.failed'),
            ]);

        }

        // remember login email & password with cookies
        if($request->rememberMe != '' && isset($request->rememberMe)){
            setcookie("saved_email", $request->email, time()+3600);
            setcookie("saved_password", $request->password, time()+3600);
        }else{
            setcookie("saved_email", '');
            setcookie("saved_password", '');
        }

        $user = Auth::user();


        // // Check user role and redirect accordingly
        // $request->session()->regenerate();

        // if ($user->hasRole('admin') || $user->hasRole('superadmin')) {
        //     return redirect()->route('adminDashboard');
        // }


        // Check user role and redirect accordingly
        $request->session()->regenerate();

        // Also Checking Whether the account is deleted or not.
        // if($user->account_status == false){
        //     $disabled_user = $user;
        //     return view('auth.frontend.user.account_deactive')->with('disabled_user', $disabled_user);
        // }


        $adminOrSuperadmin = $user->roles->pluck('name')->intersect(['admin', 'superadmin'])->count() > 0;
        if ($adminOrSuperadmin) {
            toastr()->success('Welcome Back Chief!', 'Admin Login');
            return redirect()->route('adminDashboard');
        }
        // Add any other role checks if needed...

        // Redirect to a different route for non-admin/superadmin users
        toastr()->success('Welcome Back '.$user->first_name, 'Login Success');

        return redirect()->route('userDashboard');
    }

    // returning the dashboard
    public function dashboard()
    {
        return view('auth.frontend.user.homepage');
    }


    // user self soft account deactivation

    public function deactiveUser($userId){
        $currentUserId = Auth::id();
        $user = User::findOrFail($userId);
        if($currentUserId == $userId){
            // the proceed delete
            $user->account_inactive_reason = 'Self Deletion'; // self deleted
            $user->account_inactive_since = Carbon::now();
            $user->account_status=false;
            $user->save();
            // $user->delete();

        }
        return redirect()->back();
    }
}
