<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VerifyUser;
use Carbon\Carbon;
use Mail; 
use App\Mail\resend;
class VerifyEmailController extends Controller
{
    public function VerifyEmail(Request $request) {
        $id = $request->id;
        $token = $request->token;
        $verifyUser = VerifyUser::where('user_id',$id)->first();
        if(isset($verifyUser) ) {
         $verifyUser = VerifyUser::where('token', $token)->where('user_id',$id)->first();
         if(isset($verifyUser) ) {
            $user = $verifyUser->user;
            if($user->verified == 0) {
              $verifyUser->user->verified = 1;
              $verifyUser->user->save();
              return response()->json([
                'message' => 'Your e-mail is verified. You can now login.',
              ],200);
            } 
            else {
              return response()->json([
                'message' => 'Your e-mail already verified. You can now login.',
              ],200);
            }
        }
        else {
            return response()->json([
              'message' => 'Sorry your token cannot be identified.',
            ],400);
          }
    }
        else {
          return response()->json([
            'message' => 'Sorry your email cannot be identified.',
          ],400);
        }
      }
        //function resend activation by e-Mail
      public function resendMail(Request $request){
        $id = $request->id;
        $verifyUser1 = VerifyUser::where('user_id',$id)->with('user')->first();
        if($verifyUser1){
          $verifyUser = VerifyUser::where('user_id',$id)->update([
          'token' => mt_rand(100000, 999999),
          ]);
          $verifyUser = array('name'=>$verifyUser1->user->name,'email'=>$verifyUser1->user->email ,'token'=>$verifyUser1->token);
          Mail::send('resend', $verifyUser, function($message) use($verifyUser1) {
            $message->to($verifyUser1->user->email)->subject
            ('Resend Activation Code');
          });
          return response()->json([
            'message' => 'success'
          ],200);
        }
        return response()->json([
          'message' => 'faild'
        ],400);
      }   	
}
