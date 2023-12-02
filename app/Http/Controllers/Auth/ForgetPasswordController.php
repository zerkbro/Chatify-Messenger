<?php

namespace App\Http\Controllers\Auth;

use App\Jobs\PasswordResetEmailJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ForgetPasswordController extends Controller
{
    //
    public function showForgetPasswordForm()
    {
        return view('auth.frontend.forget-password');
    }

    public function sendForgetPasswordLink(Request $request){
        $request->validate(['email' => 'required|email']);

        PasswordResetEmailJob::dispatch($request->only('email'));
        toastr()->success('Password reset link will be sent to your email!', 'Reset Link Sent');
        return back()->with(['status' => 'Reset Link Sent Success!']);
    }

    public function verifyForgetPasswordLink($token)
    {
        return view('auth.frontend.reset-password', ['token' => $token]);
    }

    public function updateNewPassword(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|same:password_confirmation|min:8',
            'password_confirmation' => 'required|same:password'
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            toastr()->success('Password has been changed!', 'Successfully Changed');
            return redirect()->route('user_login')->with('status', __($status));
        } else {
            toastr()->error('Failed to change password!', 'Failed Change');
            return back()->withErrors(['email' => [__($status)]]);
        }
    }


    /*
     * Send reset password link to the given user email.
     *
     * (
     *  Currently not in used.
     * Only to show demo for our presentation
     *  )
     */
    public function mailForgetPasswordLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

}
