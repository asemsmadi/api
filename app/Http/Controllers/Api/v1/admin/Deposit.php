<?php

namespace App\Http\Controllers\Api\v1\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Deposit as Model;
use \App\Http\Requests\admin\Deposit\create as cRequest;
use \App\Http\Requests\admin\Deposit\update as uRequest;
use \App\Http\Resources\depositResource as resource;
use \App\Http\Requests\admin\Deposit\AcceptInvestorRequest;
use \App\Http\Requests\admin\Deposit\EndInvestorRequest;

class Deposit extends Controller
{

    public function index()
    {
        return resource::collection(Model::all());
    }

    public function create()
    {
        return \App\Http\Resources\investorResource::collection(\App\Investor::all());
    }

    public function store(cRequest $request)
    {
        $data = new Model();
        $Deposit = $data->AddNewDeposit($request);
        return new resource(Model::findOrFail($Deposit));
    }

    public function show($id)
    {
        return new resource(Model::findOrFail($id));
    }

    public function edit($id)
    {
        return new resource(Model::findOrFail($id));
    }

    public function update(uRequest $request, $id)
    {
        $data = Model::findOrFail($id);
        $data->UpdateDeposit($request);
        return new resource(Model::findOrFail($id));
    }


    public function acceptInvestorRequest(AcceptInvestorRequest $request, $id)
    {
        $model = Model::findOrFail($id);
        if ($model->status != 1) {
            return response()->json(['error' => 'غير مسموح باكمال هذه العمليه']);
        }
        $model->acceptRequestFormInvestor($request);
        return new resource(Model::findOrFail($id));
    }

    public function endInvestorRequest($id, EndInvestorRequest $request)
    {

        $model = Model::findOrFail($id);
        if ($model->status != 2) {
            return response()->json(['error' => 'غير مسموح باكمال هذه العمليه']);
        }
        $model->EndRequestFormInvestor($request);
        return new resource(Model::findOrFail($id));
    }

    public function rejectInvestorRequest(AcceptInvestorRequest $request,$id)
    {
        $model = Model::findOrFail($id);
        if ($model->status != 1) {
            return response()->json(['error' => 'غير مسموح باكمال هذه العمليه']);
        }
        $model->rejectRequestFormInvestor($request);
        return new resource(Model::findOrFail($id));
    }
}
