<?php

namespace App\Http\Controllers\Api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\transfers\create;
use App\Http\Requests\admin\transfers\update;
use App\Http\Resources\transfers as resource;
use App\transfer as Model;
use Illuminate\Http\Request;

class transfer extends Controller
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
        if (CheckIfInvestorHasEnoughMoney($request->investor_id_From, $request->amount)) {
            $model = new Model();
            $model = $model->createTransfer($request);
            return new resource($model);
        } else {
            return response()->json(['error' => 'هذا المستخدم لا يملك مبلغ كاف لاتمام هذا الاحراء']);
        }
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

    public function rejectTransfer($id)
    {

        $model = Model::findOrFail($id);
        if ($model->status == 1) {

            $model->rejectTransfer();
            return Model::findOrFail($id);
        } else {
            return response()->json(['error' => 'لا يمكتك اتمام هذا الاجراء']);
        }
    }

    public function acceptTransfer($id)
    {
        $model = Model::findOrFail($id);
        if ($model->status == 1) {
            if (CheckIfBalancePendingIsenoughForTransfer($model->investor_id_From, $model->amount)) {
                $model->acceptTransfer();
                return Model::findOrFail($id);
            } else {
                return response()->json(['error' => 'هذا المستخدم لا يملك مبلغ كاف لاتمام هذا الاحراء']);
            }
        } else {
            return response()->json(['error' => 'لا يمكتك اتمام هذا الاجراء']);
        }
    }
}
