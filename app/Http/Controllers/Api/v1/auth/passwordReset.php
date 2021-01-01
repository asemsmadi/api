<?php

namespace App\Http\Controllers\Api\v1\auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class passwordReset extends Controller
{
    public $token;
    public $email;
    public $password;
    public $data;
    public $expires = 60;

    public function reset(\App\Http\Requests\auth\passwordReset $request, $token)
    {
        $this->email = $request->email;
        $this->token = $token;
        $this->password = $request->password;
        $this->checkIfTokenExist();
        $this->checkIfTokenExpired();
        $this->deleteExist();
        return User::where('email', $this->email)->update(['password' => bcrypt($this->password)]) == true ? response()->json(['success' => 'تم التعديل بنجاح']):response()->json(['error' => 'حدث خطأ ما']) ;

    }

    public function deleteExist()
    {
        \DB::table('password_resets')->where(['email' => $this->email, 'token' => $this->token])->delete();
    }

    public function checkIfTokenExist()
    {
        $exist = \DB::table('password_resets')->where(['email' => $this->email, 'token' => $this->token])->first();
        if ($exist != null) {
            $this->data = $exist;
        } else {
            return response()->json(['error' => 'هذا الرابط غير موجود']);
        }
    }

    public function checkIfTokenExpired()
    {
        if (Carbon::parse($this->data->created_at)->addSeconds($this->expires * 60)->isPast()) {
            return response()->json(['error' => 'انتهت صلاحية هذا الرابط']);
        }
    }
}
