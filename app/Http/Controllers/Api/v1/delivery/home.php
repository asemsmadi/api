<?php

namespace App\Http\Controllers\Api\v1\delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Http\Requests\delivery\transaction;
use \App\Http\Resources\withdrawals as resource;
use \App\withdrawal as Model;

class home extends Controller
{
    public function getTransaction(transaction $request)
    {
        return new resource(Model::where(['code' => $request->code, 'status' => 2])->firstOrFail());
    }

    public function acceptTransaction($id)
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
