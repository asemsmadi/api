<?php

namespace App\Http\Controllers\Api\v1\investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Deposit as Model;

use \App\Http\Requests\investor\deposit\create;

use \App\Http\Resources\depositResource as resource;

class DepositRequest extends Controller
{
    public function request(create $request)
    {
        $model = new Model();
        $model = $model->AddNewDepositRequest($request);
        return new resource(Model::findOrFail($model));
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
