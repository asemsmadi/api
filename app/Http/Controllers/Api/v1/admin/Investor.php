<?php

namespace App\Http\Controllers\Api\v1\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Investor as Model;
use \App\Http\Resources\investorResource as Resource;
use \App\Http\Requests\admin\Investor\create as cRequest;
use \App\Http\Requests\admin\Investor\update as uRequest;

class Investor extends Controller
{
    public function index()
    {
        $data = Model::all();
        return Resource::collection($data);
    }

    public function store(cRequest $request)
    {
        $model = new Model();
        $data = $model->createNewInvestor($request);
        return new Resource($data);
    }

    public function show($id)
    {
        $data = Model::with(['balance', 'InvestorBalance', 'transactions'])->findOrFail($id);
        return new Resource($data);
    }

    public function edit($id)
    {
        $data = Model::findOrFail($id);
        return new Resource($data);
    }

    public function update(uRequest $request, $id)
    {
        $model = Model::findOrFail($id);
        $model->updateInvestor($request);
        return new Resource(Model::findOrFail($id));
    }

    public function accept($id)
    {
        $model = Model::findOrFail($id);
        $model->acceptForInvestor();
        return new Resource(Model::findOrFail($id));
    }

    public function destroy($id)
    {
        $model = Model::findOrFail($id);
        $user = \App\User::findOrFail($model->user_id);
        $model->delete();
        $user->delete();
        return response()->json(['success' => 'done']);
    }
}
