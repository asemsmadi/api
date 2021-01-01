<?php

namespace App\Http\Controllers\Api\v1\admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use \App\admin as Model;
use \App\Http\Resources\adminResource;

class admin extends Controller
{
    public function index()
    {
        $data = \App\admin::with('user')->get();
        return adminResource::collection($data);
    }

    public function store(\App\Http\Requests\admin\admin\create $request)
    {
        $model = new Model();
        $model = $model->createAdmin($request);
        return new adminResource(Model::findorFail($model->id));
    }

    public function show($id)
    {
        $data = Model::with('user')->findOrFail($id);
        return new adminResource($data);
    }

    public function update(\App\Http\Requests\admin\admin\update $request, $id)
    {
        $model = Model::findOrFail($id);
        $model->updateAdmin($request);
        return new adminResource(Model::findOrFail($id));
    }

    public function destroy($id)
    {
        $model = \App\User::whereIn('type', [1, 2])->findOrFail($id);
        $model->delete();
        return response()->json(['success' => 'done']);
    }
}
