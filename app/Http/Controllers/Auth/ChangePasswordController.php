<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{

    public function index(Request $request) {

        try {

            $validator = Validator::make($request->all(), [
                'current_password' => ['required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('Current Password didn\'t match');
                    }
                }],
                'password' => ['required','min:8','same:confirm_password'],
                'confirm_password' => ['required']
            ]);

            if ($validator->fails()) {
                return redirect('/change-password')
                    ->withErrors($validator)
                    ->withInput();
            }

//            Log::debug("Sudah VALIDASI biasa");

            $user = Auth::user();

            $user->fill([
                'password' => bcrypt($request->password)
            ])->save();

//            $request->session()->flash('success', 'Password changed');
////            return redirect('/')->with('status','Password has changed successfully');
//
//            return redirect('/')->with(['status' => 'Password has changed successfully']);



            Session::flash("flash_notification", [
                "level"     => "success",
                "message"   => "Password changed successfully"
            ]);

            return redirect('/');


        } catch (\Exception $e) {
            Log::debug($request);

        }

    }

}
