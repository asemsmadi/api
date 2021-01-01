<?php

namespace App\Http\Controllers\Api\v1\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\withdrawal as Model;
use \App\Http\Requests\admin\withdrawals\create;
use \App\Http\Requests\admin\withdrawals\acceptRequest;

use \App\Http\Resources\withdrawals as resource;
use Illuminate\Support\Facades\View;

class Withdrawals extends Controller
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
        $investorID = $request->investor_id;
        if (CheckIfInvestorHasEnoughMoney($investorID, $request->amount)) {
            $model = new Model();
            $withdrawal = $model->createNewWithdrawalFromAdmin($request, $investorID);
        } else {
            return response()->json(['error' => 'لا بوجد رصيد كافي']);
        }
        return new resource($withdrawal);
    }

    public function show($id)
    {
        return new resource(Model::findOrFail($id));
    }

    public function destroy($id)
    {
        $model = Model::findOrFail($id);
        $model->delete();
        return response(['success' => 'done']);
    }

    public function rejectWithdrawalRequest($id)
    {
        $model = Model::findorFail($id);
        if ($model->status == 1) {
            $model->rejectWithdrawalRequest();
            return new resource(Model::findorFail($id));
        } else {
            return response()->json(['error' => 'لا يمكنك اتمام العمليه']);
        }
    }

    public function acceptWithdrawalRequest($id, acceptRequest $request)
    {
        $model = Model::findorFail($id);
        if ($model->status == 1) {
            $model->acceptWithdrawalRequest($request);
            return new resource(Model::findorFail($id));
        } else {
            return response()->json(['error' => 'لا يمكنك اتمام العمليه']);
        }
    }

    public function EndWithdrawalRequest($id)
    {
        $model = Model::findorFail($id);
        if ($model->status == 2) {
            if (CheckIfBalancePendingIsenoughForTransfer($model->investor_id, $model->amount)) {
                $model->EndWithdrawalRequest();
                return new resource(Model::findorFail($id));
            }
        } else {
            return response()->json(['error' => 'لا يمكنك اتمام العمليه']);
        }
    }
}
