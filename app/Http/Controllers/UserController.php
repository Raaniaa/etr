<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use responnse;
use Mail; 
use DB;
use App\Mail\MyTestMail;
class UserController extends Controller
{
    //function new register
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
         'name' => 'required|max:255',
         'email' => 'required|email|max:255|unique:users',
         'password' => 'required|min:3',
        ]);
        if ($validator->fails()){
         return response(['errors'=>$validator->errors()->all()], 422);
        }
        $details = User::create([
         'name' => $request->name,
         'email' => $request->email,
         'password' => Hash::make($request['password']),
        ]);
        $token = $details->createToken('auth_token')->plainTextToken;
        $verifyUser = VerifyUser::create([
         'user_id' => $details->id,
         'token' => mt_rand(100000, 999999),
        ]);
        $user = User::where('id',$details->id)->select('id')->first();
        \Mail::to($details->email)->send(new MyTestMail($details));
       //\Mail::send('name', ['email_verification_token' => $token], function($message) use($request){
        // $message->to($request->email);
         //$message->subject('Email Verification Mail');
         //});
        return response()->json([
         'message' => "User registered successfully",
         'access_token' => $token,
         'data' => $user,
        ],200);
     }
       //function login
    public function login(Request $request){
        $loginData = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|min:3',
           ]);
           if ($loginData->fails())
           {
            return response(['errors'=>$loginData->errors()->all()], 422);
           }
        $user = User::where('email', $request['email'])->first();
        if($user){
            if($user->verified == 0){
                if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                  return response(['message' => 'Wrong Password'], 401);
                }
            }
            if($user->verified != 0){
                if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    return response(['message' => 'Wrong Password'], 401);
                } 
                $accessToken = auth()->user()->createToken('auth_token')->plainTextToken;
                return response(['user' => auth()->user(), 'access_token' => $accessToken]);
            }
            return response(['message' => 'account not verify'], 400); 
        }
        return response(['message' => 'Email Wrong'], 404); 
    }
    public function forgetPassword(Request $request){
        $credentials = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);
        if ($credentials->fails()){
            return response(['errors'=>$credentials->errors()->all()], 422);
        }
        $verifyUser1 = User::where('email',$request->email)->first();
        if($verifyUser1){
            $tokenData = DB::table('password_resets')->where('email', $request->email)->first();
            if($tokenData){
                $verifyUser = DB::table('password_resets')->where('email',$tokenData->email)->update([
                    'email' => $request->email,
                    'token' => mt_rand(100000, 999999),
                ]);
                $verifyUser = array('name'=>$verifyUser1->name,'email'=>$verifyUser1->email ,'token'=>$tokenData->token);
                Mail::send('resetPassword', $verifyUser, function($message) use($verifyUser1) {
                $message->to($verifyUser1->email)->subject
                ('Reset Password Code');
               });
               return response()->json([
                "data" => $verifyUser1->id,
                "message" => 'Reset password link sent on your email id.'],200);
            }
            else{
                $verifyUser = DB::table('password_resets')->insert([
                    'email' => $request->email,
                    'token' => mt_rand(100000, 999999),
                ]);
                $tokenData = DB::table('password_resets')->where('email', $request->email)->first();
                $verifyUser = array('name'=>$verifyUser1->name,'email'=>$verifyUser1->email ,'token'=>$tokenData->token);
                Mail::send('resetPassword', $verifyUser, function($message) use($verifyUser1) {
                    $message->to($verifyUser1->email)->subject
                    ('Reset Password Code');
                });
                return response()->json([
                    "data" => $verifyUser1->id,
                    "message" => 'Reset password link sent on your email id.'],200);
            }
        }
        return response()->json(["message"=> 'user not exist'],404);
    }
    public function reset(Request $request) {
        $credentials = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'token' => 'required',
            'password' => 'required'
           ]);
        if ($credentials->fails()){
            return response(['errors'=>$credentials->errors()->all()], 422);
        }
        $user = DB::table('password_resets')->where('email', $request->email)->first();
        if($user){
            $token=DB::table('password_resets')->where('email', $request->email)->where('token',$request->token)->first();
            if($token){
                $reset= User::where('email',$user->email)->update([
                    'password' => Hash::make('password') ,
                ]);
                return response()->json(["message" => "Password has been successfully changed"],200);
            }
            return response()->json(["message" => "wrong token"],400);
        }
        return response()->json(["message" =>"not exist"],404);
    }
    public function resetCode(Request $request) {
        $credentials = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'token' => 'required',
           ]);
        if ($credentials->fails()){
            return response(['errors'=>$credentials->errors()->all()], 422);
        }
        $user = DB::table('password_resets')->where('email', $request->email)->first();
        if($user){
            $token=DB::table('password_resets')->where('email', $request->email)->where('token',$request->token)->first();
            if($token){

                return response()->json(["message" => "resetCode has been successfully"],200);
            }
            return response()->json(["message" => "wrong token"],400);
        }
        return response()->json(["message" =>"not exist"],404);
    }

}
