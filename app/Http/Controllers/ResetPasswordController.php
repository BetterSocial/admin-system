<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class ResetPasswordController extends Controller
{
    public function index(Request $request)
    {

        try {
            $nama = "Reset Password Better Account";
            $email = $request->email;
            $token = $request->_token;

            //Validation
            $dataUser = User::where('email',$email)->first();

            if( $dataUser != null ) {
                $send = Mail::to($email)->send(new ResetPasswordMail($token));
                return Redirect::back();

            } else {
                return Redirect::back()
//                    ->with('status','Cannot find email')
                    ->withErrors(['email' => "We can't find a user with that email address."]);
            }

        }catch (\Exception $e) {
            return response()->json([
                'success'=> false,
                'message'=>$e->getMessage()
            ]);
        };

    }

    public function resetPassword(Request $request) {

        try {

            $rules = [
                'email'             =>  'required|email|unique:users',
                'password'          =>  'required|min:8',
                'password_confirmation'   =>  'required|same:password'
            ]; //|regex:/^(?=\S*[a-z])(?=\S*[!@#$&*])(?=\S*[A-Z])(?=\S*[\d])\S*$/

            $messages = [
                'email.required'            => 'email tidak boleh kosong',
                'password.required'         => 'password tidak boleh kosong',
                'password.min'              => 'Password harus minimal 8 karakter',
                'password.regex'            => 'Format password harus terdiri dari kombinasi huruf besar, angka dan karakter spesial (contoh:!@#$%^&*?><).',
                'verify_password.required'  => 'Verify Password tidak boleh kosong',
                'email.email'               => 'Format Email tidak valid',
                'email.unique'              => 'Email yang anda masukkan telah digunakan',
                'verify_password.same'      => 'Password tidak sama!',
            ];

            $this->validate($request,$rules,$messages);

            $email = $request->email;


            //TODO validasi confirm password belum masuk

            $dataUser = User::where('email',$email)->first();

            if( $dataUser != null ) {

                $dataUser->password = bcrypt($request->password);

                $dataUser->save();

                return redirect('/login')->with('message','Password changed successfully');

            } else {
                return Redirect::back()
//                    ->with('status','Cannot find email')
                    ->withErrors(['email' => "We can't find a user with that email address."]);
            }




        }catch (\Exception $e) {
            return response()->json([
                'success'=> false,
                'message'=>$e->getMessage()
            ]);
        }












    }
}
