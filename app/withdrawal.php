<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class withdrawal extends Model
{
    protected $fillable = [
        'id',
        'amount',
        'note',
        'dateRequest',
        'dateReceived',
        'status',
        'code',
        'investor_id',
        'created_at',
    ];
    protected $with = ['investor'];

    public function createWithdrawal($request)
    {
        $data = $request->all();
        $data['code'] = GenerateUniqeCode($request->investor_id);
        return $this->create($data);
    }

    public function updateWithdrawal($request)
    {
        $this->update($request->all());
    }

    public function investor()
    {
        return $this->belongsTo(\App\Investor::class, 'investor_id', 'id');
    }

    public function createNewWithdrawalFromInvestor($request, $investorID)
    {
        \DB::beginTransaction();
        \App\investorBalance::where('investor_id', $investorID)->first()->IncreasePendingBalanceByWithdrawal($request->amount);
        $data = $this->create([
            'amount' => $request->amount,
            'dateRequest' => now(),
            'note' => ' ',
            'investor_id' => $investorID,
            'status' => 1
        ]);
        \DB::commit();
        return $data;
    }

    public function createNewWithdrawalFromAdmin($request, $investorID)
    {
        \DB::beginTransaction();
        \App\investorBalance::where('investor_id', $investorID)->first()->IncreasePendingBalanceByWithdrawal($request->amount);
        $data = $this->create([
            'amount' => $request->amount,
            'dateRequest' => now(),
            'note' => ' ',
            'investor_id' => $investorID,
            'status' => 1
        ]);
        \DB::commit();
        return $data;
    }

    public function rejectWithdrawalRequest()
    {
        \DB::beginTransaction();
        \App\investorBalance::where('investor_id', $this->investor_id)->first()->DecreasePendingBalanceByRejectWithdrawalRequest($this->amount);
        $this->update(['status' => 4]);
        \DB::commit();
    }

    public function acceptWithdrawalRequest($request)
    {
        \DB::beginTransaction();
        $code = GenerateUniqeCode($this->investor_id);
        $data['code'] = $code;
        $data['dateReceived'] = $request->dateReceived;
        $data['status'] = 2;
        $this->update($data);
        \DB::commit();
    }

    public function EndWithdrawalRequest()
    {
        \DB::beginTransaction();
        \App\investorBalance::where('investor_id', $this->investor_id)->first()->DecreasePendingBalanceByRejectWithdrawalRequest($this->amount);
        \App\investorBalance::where('investor_id', $this->investor_id)->first()->DecreaseProfitBalanceByRejectWithdrawalRequest($this->amount);
        \App\transaction::CreateNewTransactionByWithdrawal($this->attributes);
        $this->update(['status' => 3]);
        \DB::commit();
    }
}
