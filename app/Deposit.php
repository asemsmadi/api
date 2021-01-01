<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'id',
        'amount',
        'note',
        'status',
        'DateDelivery',
        'investor_id',
        'created_at',
    ];

    protected $with = [
        'user'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Investor::class, 'investor_id', 'id');
    }

    public function AddNewDepositRequest($request)
    {
        \DB::beginTransaction();
        $data = [];
        $data['amount'] = $request->amount;
        $data['status'] = 1;
//        $data['investor_id'] = auth()->user()->Investor->id;
        $data['investor_id'] = 7;
        \DB::commit();
        return ($this->create($data))->id;
    }

    public function AddNewDeposit($request)
    {
        return ($this->create($request->all()))->id;
    }

    public function UpdateDeposit($request)
    {
        $this->update($request->all());
    }

    public function acceptRequestFormInvestor($request)
    {
        \DB::beginTransaction();
        $data = [];
        $data['note'] = $request->note;
        $data['status'] = 2;
        $data['DateDelivery'] = $request->DateDelivery;
        \DB::commit();
        $this->update($data);
    }

    public function EndRequestFormInvestor($request)
    {
        \DB::beginTransaction();
        $this->update(['status' => 3]);
        \App\transaction::createDepositTransaction($this->attributes);
        \App\balance::createNewBalanceForInvestorByDeposit($this->attributes, $request);
        \DB::commit();
    }

    public function rejectRequestFormInvestor($request)
    {
        \DB::beginTransaction();
        $this->update(['status' => 4]);
        \DB::commit();
    }
}
