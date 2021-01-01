<?php

namespace App\Http\Controllers\Api\v1\auth;

use App\Http\Controllers\Controller;
use \App\Http\Requests\auth\password as request;
use Carbon\Carbon;
use DB;
use App\User;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

use Illuminate\Support\Str;

class password extends Controller
{
    public function email(request $request)
    {
      return  $this->sendMail($request->email);
    }
    public function sendMail($email)
    {
        $token = $this->generateToken($email);
        if ($token != 0) {
            User::where('email', $email)->first()->notify(new ResetPasswordNotification($token));
            return response()->json(['error' => 'تم ارسال الرابط بنجاح']);
        } else {
            return response()->json(['error' => 'تم ارسال الرابط مسبقا']);
        }
    }

    public function generateToken($email)
    {
        $isOtherToken = DB::table('password_resets')->where('email', $email)->first();
        if ($isOtherToken != null) {
            return 0;
        } else {
            $token = Str::random(80);;
            $this->storeToken($token, $email);
            return $token;
        }
    }
    public function storeToken($token, $email)
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }

}
