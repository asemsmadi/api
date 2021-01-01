<?php

namespace App\Http\Controllers\Api\v1\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class register extends Controller
{
    public function index(\App\Http\Requests\auth\register $request)
    {
        $Investor = new \App\Investor();
        $Investor->createNewInvestor($request);
        return response()->json(['success'=>'done'], 201);
    }
}
