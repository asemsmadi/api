<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rerunprofit extends Model
{
    protected $fillable = [
        'id',
        'investor_id',
        'amount',
        'created_at',
        'status',
    ];
    protected $with = [
        'investor'
    ];

    public function createNewReRunProfitRequest($request)
    {
        \DB::beginTransaction();
        $data = $this->create([
            'investor_id' => $request->investor_id,
            'amount' => $request->amount,
            'created_at' => now(),
            'status' => 1,
        ]);
        \App\investorBalance::where('investor_id', $request->investor_id)->first()->IncreasePendingByReRunProfit($request->amount);
        \DB::commit();
        return $data;
    }

    public function createNewReRunProfitRequestFromInvestor($request, $investor_id)
    {
        \DB::beginTransaction();
        $data = $this->create([
            'investor_id' => $investor_id,
            'amount' => $request->amount,
            'created_at' => now(),
            'status' => 1,
        ]);
        \App\investorBalance::where('investor_id', $investor_id)->first()->IncreasePendingByReRunProfit($request->amount);
        \DB::commit();
        return $data;
    }

    public function rejectRerunProfitRequest()
    {
        \DB::beginTransaction();
        \App\investorBalance::where('investor_id', $this->investor_id)->first()->DecreasePendingByReRunProfit($this->amount);
        $this->update(['status' => 4]);
        \DB::commit();
    }

    public function acceptRequest($request)
    {
        \DB::beginTransaction();
        \App\investorBalance::where('investor_id', $this->investor_id)->first()->DecreasePendingByReRunProfit($this->amount);
        \App\investorBalance::where('investor_id', $this->investor_id)->first()->DecreaseProfitByReRunProfit($this->amount);
        $balance = \App\balance::createNewBalanceForInvestorByReRunProfit(array_merge($request->toArray(), $this->attributes));
        \App\transaction::createTransactionFromRunProfit($balance);
        $this->update(['status' => 2]);
        \DB::commit();
    }

    public function investor()
    {
        return $this->belongsTo(\App\Investor::class, 'investor_id', 'id');
    }
}
