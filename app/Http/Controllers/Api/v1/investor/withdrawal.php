<?php

namespace App\Http\Controllers\Api\v1\investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Http\Requests\investor\withdrawal\create;
use \App\withdrawal as Model;
use \App\Http\Resources\withdrawals as resource;

class withdrawal extends Controller
{
    public function request(create $request)
    {
        $investorID = auth()->user()->investor->id;
        if (CheckIfInvestorHasEnoughMoney($investorID, $request->amount)) {
            $model = new Model();
            $withdrawal = $model->createNewWithdrawalFromInvestor($request, $investorID);
        } else {
            return response()->json(['error' => 'لا بوجد رصيد كافي']);
        }
        return new resource($withdrawal);
    }

    public function ShowRequest($id)
    {
        return new resource(Model::where('investor_id', auth()->user()->investor->id)->findOrFail($id));
    }

    public function allRequest()
    {
        return resource::collection(Model::where('investor_id', auth()->user()->investor->id)->get());
    }
}
