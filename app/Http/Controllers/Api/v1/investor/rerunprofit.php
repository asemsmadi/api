<?php

namespace App\Http\Controllers\Api\v1\investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\rerunprofit as Model;
use \App\Http\Requests\investor\rerunprofit\create;
use \App\Http\Resources\ReRunProfit as resource;

class rerunprofit extends Controller
{
    public function request(create $request)
    {
        $investorId = auth()->user()->investor->id;
        if (CheckIfInvestorHasEnoughMoney($investorId, $request->amount)) {
            $model = new Model;
            $data = $model->createNewReRunProfitRequestFromInvestor($request, $investorId);
            return new resource($data);
        } else {
            return response()->json(['error' => 'لا يوجد لديك رصيد كاف']);
        }
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
