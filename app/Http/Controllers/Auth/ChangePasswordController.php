<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{

    public function index(Request $request) {

        try {

            Log::debug($request);
            Log::debug("Sedang VALIDASI biasa");


            $validator = Validator::make($request->all(), [
                'old_password' => ['required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('Old Password didn\'t match');
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

            Log::debug("Sudah VALIDASI biasa");

//            $password = $request->old_password;

//            $user = Auth::user();
//
//            Log::debug("MASHOQQQ VALIDASI PASWROD");
//
//            if (Hash::check($request->old_password, $user->password)) {
//
//                $user->fill([
//                    'password' => bycrypt($request->password)
//                ])->save();
//
//                $request->session()->flash('success', 'Password changed');
//                return redirect('/login')->with('message','Password changed successfully');
//
//            } else {
//                return Redirect::back()
////                    ->with('status','Cannot find email')
//                    ->withErrors(['password' => "Wrong Password"]);
//            }




        } catch (\Exception $e) {
            Log::debug($request);

        }

    }

}
