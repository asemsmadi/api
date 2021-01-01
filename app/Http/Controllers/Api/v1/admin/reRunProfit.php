<?php

namespace App\Http\Controllers\Api\v1\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Http\Resources\ReRunProfit as resource;
use \App\rerunprofit as Model;
use \App\Http\Requests\admin\rerunprofit\create;
use \App\Http\Requests\admin\rerunprofit\accept;

class reRunProfit extends Controller
{
    public function index()
    {
        return resource::collection(Model::all());
    }

    public function create()
    {
        return \App\Http\Resources\investorResource::collection(\App\Investor::all());
    }

    public function store(create $request)
    {
        $investor = $request->investor_id;
        if (CheckIfInvestorHasEnoughMoney($investor, $request->amount)) {
            $model = new Model();
            return new resource(Model::findOrFail($model->createNewReRunProfitRequest($request)['id']));
        } else {
            return response()->json(['error' => 'لا يوجد مبلغ كاف']);
        }
    }

    public function reject($id)
    {
        $model = Model::findOrFail($id);
        if ($model->status == 1) {
            $model->rejectRerunProfitRequest();
            return new resource(Model::findOrFail($id));
        } else {
            return response()->json(['error' => 'غير مسموح بهذه الحركة']);
        }
    }

    public function acceptRequest(accept $request, $id)
    {
        $model = Model::findOrFail($id);
        if ($model->status == 1) {

            if (CheckIfBalancePendingIsenoughForTransfer($model->investor_id, $model->amount)) {
                $model->acceptRequest($request);
                return new resource(Model::findOrFail($id));
            } else {
                return response()->json(['error' => 'لا يوجد مبلغ كاف']);
            }
        } else {
            return response()->json(['error' => 'غير مسموح بهذه الحركة']);
        }
    }
}
