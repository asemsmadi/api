<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Investor extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'phone',
        'UserImage',
        'UserCardImage',
        'PassPortImage',
        'PassPortNo',
        'accept',
        'sponsorName',
        'sponsorCardImage',
        'sponsorPhone',
        'created_at',
        'updated_at',
    ];

    protected $with = [
        'user',
    ];

    public function createNewInvestor($request)
    {
        \DB::beginTransaction();
        $user = array();
        $user['email'] = $request->email;
        $user['name'] = $request->name;
        $user['password'] = bcrypt($request->password);
        $user['type'] = '6';
        $u = \App\User::create($user);
        $Investor = array();
        $Investor['user_id'] = $u->id;
        $Investor['phone'] = $request->phone;
        $Investor['UserImage'] = Storage::put('image', $request->file('UserImage'));
        $Investor['UserCardImage'] = Storage::put('image', $request->file('UserCardImage'));
        $Investor['PassPortImage'] = Storage::put('image', $request->file('PassPortImage'));
        $Investor['PassPortNo'] = $request->PassPortNo;
        $Investor['sponsorName'] = $request->sponsorName;
        $Investor['sponsorCardImage'] = Storage::put('image', $request->file('sponsorCardImage'));
        $Investor['sponsorPhone'] = $request->sponsorPhone;
        $Investor['created_at'] = now();
        $data = $this->create($Investor);
        \App\investorBalance::create([
            'pending' => 0.00,
            'profit' => 0.00,
            'investor_id' => $data->id,
        ]);
        \DB::commit();
        return $data;
    }

    public function createNewInvestorFromAdmin($request)
    {
        \DB::beginTransaction();
        $password = $request->password;
        $user = array();
        $user['email'] = $request->email;
        $user['name'] = $request->name;
        $user['password'] = bcrypt($password);
        $user['type'] = '6';
        $u = \App\User::create($user);
        $Investor = array();
        $Investor['user_id'] = $u->id;
        $Investor['phone'] = $request->phone;
        $Investor['UserImage'] = Storage::put('image', $request->file('UserImage'));
        $Investor['UserCardImage'] = Storage::put('image', $request->file('UserCardImage'));
        $Investor['PassPortImage'] = Storage::put('image', $request->file('PassPortImage'));
        $Investor['PassPortNo'] = $request->PassPortNo;
        $Investor['sponsorName'] = $request->sponsorName;
        $Investor['sponsorCardImage'] = Storage::put('image', $request->file('sponsorCardImage'));
        $Investor['sponsorPhone'] = $request->sponsorPhone;
        $Investor['created_at'] = now();
        $data = $this->create($Investor);
        $u->notify(new \App\Notifications\admin\Investor\Password($password));
        \DB::commit();
        return $data;
    }

    public function updateInvestorFromAdmin($request)
    {
        \DB::beginTransaction();
        $user = array();
        $user['email'] = $request->email;
        $user['name'] = $request->name;
        $u = $this->user()->update($user);
        $Investor = array();
        $Investor['user_id'] = $u->id;
        $Investor['phone'] = $request->phone;
        if ($request->hasFile('UserImage')) {
            if (Storage::exists($request->UserImage)) {
                Storage::delete($request->UserImage);
            }
            $Investor['UserImage'] = Storage::put('image', $request->file('UserImage'));
        }
        if ($request->hasFile('PassPortImage')) {
            if (Storage::exists($request->PassPortImage)) {
                Storage::delete($request->PassPortImage);
            }
            $Investor['PassPortImage'] = Storage::put('image', $request->file('PassPortImage'));
        }
        if ($request->hasFile('sponsorCardImage')) {
            if (Storage::exists($request->sponsorCardImage)) {
                Storage::delete($request->sponsorCardImage);
            }
            $Investor['sponsorCardImage'] = Storage::put('image', $request->file('sponsorCardImage'));
        }
        if ($request->hasFile('UserCardImage')) {
            if (Storage::exists($request->UserCardImage)) {
                Storage::delete($request->UserCardImage);
            }
            $Investor['UserCardImage'] = Storage::put('image', $request->file('UserCardImage'));
        }
        $Investor['PassPortNo'] = $request->PassPortNo;
        $Investor['sponsorName'] = $request->sponsorName;
        $Investor['sponsorPhone'] = $request->sponsorPhone;
        $data = $this->update($Investor);
        \DB::commit();
        return $data;
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    public function balance()
    {
        return $this->hasMany(\App\balance::class, 'investor_id', 'id');
    }

    public function investorBalance()
    {
        return $this->hasOne(\App\investorBalance::class, 'investor_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(\App\transaction::class, 'investor_id', 'id');
    }

    public function acceptForInvestor()
    {
        $this->update(['accept' => 'yes']);
    }
}
