<?php

namespace App\Http\Controllers\Api\v1\investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Http\Requests\investor\transfer\create;
use \App\transfer as Model;
use \App\Http\Resources\transfers as resource;

class transfer extends Controller
{
    public function request(create $request)
    {
        $Investor_id = auth()->user()->investor->id;
        if (CheckIfInvestorHasEnoughMoney($Investor_id, $request->amount)) {
            $model = new Model();
            $transfer = $model->createNewTransferRequestFromInvestor($request,$Investor_id);
            return $transfer;
        } else {
            return response()->json(['error' => 'المبلغ غير متوفر']);
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
