<?php

namespace App\Http\Controllers\Api\v1\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class login extends Controller
{
//    Get Request And Validate It And And Return Jwt Token
    public function index(\App\Http\Requests\auth\login $request)
    {
        if (!$token = auth()->attempt($request->all())) {
            return response()->json(['error' => ''], 401);
        }
        if (!in_array(auth()->user()->type, [1, 6, 2])) {
            return response()->json(['error' => 'UnAuthorization']);
        }
        $user = auth()->user();
        $role = '';
        if ($user->type == 6) {
            if ($user->investor->accept != 'yes') {
                return response()->json(['error' => 'UnAuthorization']);
            }
            $role = 'investor';
        } elseif ($user->type == 1) {
            $role = 'admin';
        } else if ($user->type == 2) {
            $role = 'investor';
        }
        return response()->json(['token' => $token, 'role' => $role]);
    }

}
