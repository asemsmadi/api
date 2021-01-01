<?php

namespace App\Http\Controllers\Api\v1\admin;

use App\Http\Controllers\Controller;
use \App\balance as Model;
use \App\Http\Requests\admin\balance\create;
use \App\Http\Resources\balanceResource as resource;

class balance extends Controller
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
        $model = new Model();
        $data = $model->AddBalanceForInvestor($request);
        return new resource(Model::findOrFail($data));
    }


    public function show($id)
    {
        return new resource(Model::with('user')->findOrFail($id));
    }


    public function destroy($id)
    {
        $model = Model::findOrFail($id);
        if ($model->status == 6) {
            return response()->json(['error' => 'غير مسموح  بهذه الحركة']);
        }
        $model->deleteBalance();
        return new resource(Model::findOrFail($id));
    }
}
