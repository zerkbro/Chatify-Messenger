<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\ResendEmailVerificationJob;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function showEmailVerificationPage(){
        return view('auth.frontend.verify-email');
    }

    public function verifyEmailVerificationLink(EmailVerificationRequest $request){
        $request->fulfill();
        toastr()->success('Your email has been verified successfully!', 'Congratulations!');

        return redirect('/dashboard')->with('status', 'Your email has been successfully verified! Welcome To Chatify.');
    }

    public function resendEmailVerificationLink(Request $request){
        if(auth()->user()->hasVerifiedEmail()){
            toastr()->error('Your email has already been verified!', 'Error!');
            return redirect()->route('dashboard');
        }
        ResendEmailVerificationJob::dispatch($request->user());
        toastr()->success('Verification link has been sent!', 'Email Sent');
        return back();
    }



}
