<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class admin extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'role',
        'created_at',
    ];
    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    public function createAdmin($request)
    {
        \DB::beginTransaction();
        $password = $request->password;
        $user = array();
        $user['email'] = $request->email;
        $user['name'] = $request->name;
        $user['password'] = bcrypt($password);
        $user['type'] = $request->type;
        $u = \App\User::create($user);
        $admin = array();
        $admin['user_id'] = $u->id;
        $admin['role'] = '1';
        $admin = $this->create($admin);
        $u->notify(new \App\Notifications\admin\admin\createAdmin($password));
        \DB::commit();
        return $admin;
    }

    public function updateAdmin($request)
    {
        \DB::beginTransaction();
        $user = array();
        $user['email'] = $request->email;
        $user['name'] = $request->name;
        $u = \App\User::findOrFail($request->id)->update($user);
        $Investor = array();
        $Investor['role'] = 1;
        $this->update($Investor);
        \DB::commit();
    }
}
