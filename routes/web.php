<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Middleware\Auth\CheckAccountStatus;
use Illuminate\Support\Facades\Auth;

// Roles And Permission Controller Namespace
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\Auth\VerifiedUser;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\AdminController;

use App\Http\Controllers\Auth\UserProfileController;
use App\Http\Controllers\Auth\ConversationController;
use App\Http\Middleware\Auth\RedirectIfEmailVerified;

use App\Http\Controllers\Auth\FilePondController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 *
 *
 * Landing page routes
 *
 */


// Global Login Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'showLoginForm')->name('home')->middleware('guest');
    Route::get('/register', 'showRegisterPage')->name('user_register')->middleware('guest');
    Route::post('/register', 'registerSave')->name('user_signup');
    Route::get('/login', 'showLoginForm')->name('user_login')->middleware('guest');
    Route::post('/login', 'loginVerify')->name('login_status')->middleware(['throttle:3,1']);
    // throttle:3,1 ---> means 3 requests in the post method /login route in 1 minutes.
    // if the request is failed user will get 429 Too many request error page.
    // The idea behind this is to prevent from unwanted login try.
});

/**
 *
 *
 * Administrator section Routes
 *
 */

// only for admin and super admin
Route::group(['middleware' => ['role:superadmin|admin']], function () {
    // Admin Management Routes
    Route::controller(AdminController::class)->group(function () {

        // Showing Admin dashboard
        Route::get('/admin/dashboard', 'ShowDashboard')->name('adminDashboard');
        Route::get('/admin/dashboard/profile', 'ShowProfile')->name('admin_profile');

        //Updating Admin Dashboard Profile
        Route::post('/admin/dashboard/profile', 'UpdateProfile')->name('update_dashboard_profile');

        // Adding new Admin
        Route::get('/admin/dashboard/add-admin', 'AddNewAdmin')->name('add_admin');
        Route::post('/admin/dashboard/add-admin', 'StoreNewAdmin')->name('add_newadmin');

        // Update Admin
        Route::get('/admin/dashboard/edit/{admin_id}', 'EditNewAdmin')->name('edit_admin');
        Route::post('/admin/dashboard/edit/{admin_id}', 'UpdateNewAdmin')->name('update_admin');


        // viewing all the admins
        Route::get('/admin/dashboard/list-admins', 'ListAllAdmin')->name('show_admins');

        // Deleting the admins
        Route::get('/admin/dashboard/delete/{admin_id}', 'DeleteAdmin')->name('delete_admin');


        // Admin Profile Password Management
        Route::get('/admin/dashboard/profile/change-password', 'ChangePasswordArea')->name('change_password');
        Route::post('/admin/dashboard/profile/change-password/{admin_id}', 'UpdatePassword')->name('update_profile_password');
    });

    // User Management Routes
    Route::controller(UserController::class)->group(function () {
        // viewing all the users
        Route::get('/admin/dashboard/list-users', 'ListAllUser')->name('show_users');
        // Adding new users
        Route::get('/admin/dashboard/add-user', 'AddNewUser')->name('add_user');
        Route::post('/admin/dashboard/add-user', 'StoreNewUser')->name('add_newuser');

        // Viewing Disabled or Deactivated Users.
        Route::get('/admin/dashboard/disabled-accounts', 'DisabledUserList')->name('show_inactive_users');

        // Disabling/Suspend/Ban User
        Route::delete('/admin/dashboard/suspend/user/{user_id}', 'SuspendUserAccount')->name('suspend_this_user');

        // Restoring Users
        Route::get('/admin/dashboard/restore/user/{user_id}', 'EnableUserAccount')->name('restore_user');


        // Deleting Users
        Route::get('/admin/dashboard/delete/user/{user_id}', 'DeleteUser')->name('delete_user');

    });

    // Super Admin Roles & Permission
    Route::controller(RoleController::class)->group(function () {
        Route::get('/admin/dashboard/role', "AllRolesAndPermission")->name('view_roles');
        Route::get('/admin/dashboard/permissions', "AllPermission")->name('view_permissions');
    });



    // Super Admin & Admin Logout Route
    Route::get('/admin/dashboard/logout', function () {
        Auth::logout();
        toastr()->info('Come back soon Chief!', 'Admin Logout');
        return redirect()->route('user_login');
    })->name('admin_logout');
});



/**
 *
 * User Routes
 *
 */


// Normal Frontend User Route

Route::middleware(VerifiedUser::class)->group(function () { // for checking the user is authenticated
    Route::middleware(CheckAccountStatus::class)->group(function () { // for checking whether the account is deactive or not.

        Route::group(['middleware' => ['role:user']], function () { // for checking the role is a normal user

            //Frontend user homepage route
            Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('userDashboard')->middleware('verified');

            /**
             *
             * Account Self Soft Delete Route
             *
             */

            Route::delete('/user/delete/{id}', [AuthController::class, 'deactiveUser'])->name('deactive_me');

            // User Profile Section
            Route::get('/user/profile', [UserProfileController::class, 'ShowUserProfile'])->name('userProfile')->middleware('verified');
            Route::post('/user/profile/', [UserProfileController::class, 'UpdateProfilePicture'])->name('updateProfilePicture')->middleware('verified');
            Route::post('/user/profile/info', [UserProfileController::class, 'UpdateProfileInfo'])->name('updateProfileInfo')->middleware('verified');

            // User Password Reset Section
            Route::get('/user/password-update', [UserProfileController::class, 'ChangePassword'])->name('change_user_password');
            Route::post('/user/password-update', [UserProfileController::class, 'UpdatePassword'])->name('update_user_password');


            Route::get('/user/search-friends', [UserProfileController::class, 'SearchFriends'])->name('search_friends')->middleware('verified');


            // Display chat page
            Route::get('/user/chat', function () {
                return view('auth.frontend.user.newdesign');
            })->name('chat_body')->middleware('verified');


            // Display chat of the specific friend or selected friend
            Route::get('/user/chat/{friend_id}', [ConversationController::class, 'setSelectedFriend'])->name('check_msg_status');

            /**
             *
             * Testing Routes
             *
             * For FilePond Files Upload Urls
             *
             */

            Route::post('/tmp-upload', [FilePondController::class, 'tempUpload']);
            Route::delete('/tmp-delete', [FilePondController::class, 'tempDelete']);

            // Frontend User Logout route
            Route::get('/logout', function () {
                Auth::logout();
                Session::flush();
                toastr()->info('Comeback Soon!', 'Logout Success!');
                return redirect()->route('user_login');
            })->name('user_logout');

            // Verified Auth User Forget password route
            Route::get('/forget-my-password', function () {
                // Log out the user first
                Auth::logout();
                // then show the view page
                return redirect()->route('password.request');
            })->name('verified.forget.password');
        });
    });
});


/**
 *
 * Email verification section
 *
 */

Route::get('/email/verify', [EmailVerificationController::class, 'showEmailVerificationPage'])->middleware(VerifiedUser::class, RedirectIfEmailVerified::class)->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verifyEmailVerificationLink'])->middleware(['auth', 'signed', RedirectIfEmailVerified::class])->name('verification.verify');
Route::post('/email/verification-notification', [EmailVerificationController::class, 'resendEmailVerificationLink'])->middleware(['auth', 'throttle:3,1'])->name('verification.send');


/**
 *
 * Resetting password from email & token verification
 *
 */

Route::get('/forget-password', [ForgetPasswordController::class, 'showForgetPasswordForm'])->middleware('guest')->name('password.request');
Route::post('/forget-password', [ForgetPasswordController::class, 'sendForgetPasswordLink'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [ForgetPasswordController::class, 'verifyForgetPasswordLink'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [ForgetPasswordController::class, 'updateNewPassword'])->middleware('guest')->name('password.update');






/**
 *
 * Custom Error Handling (Fallback route)
 *
 */

// Fallback route for Custom 404, 403 error
Route::fallback(function ($request) {
    toastr()->error('Something went wrong', 'Opps!');
    return view('errors.404');
});

