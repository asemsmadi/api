<?php

namespace App;

use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Database\Eloquent\Model;

class balance extends Model
{
    protected $fillable = [
        'id',
        'amount',
        'note',
        'DateRun',
        'status',
        'investor_id',
        'created_at',
        'updated_at',
    ];
    protected $with = [
        'user'
    ];


    public function user()
    {
        return $this->belongsTo(\App\Investor::class, 'investor_id', 'id');
    }

    public function balanceProfit()
    {
        return $this->hasMany(\App\balanceProfits::class, 'balance_id', 'id');
    }

    public function AddBalanceForInvestor($request)
    {
        \DB::beginTransaction();
        $data = $request->all();
        $data['created_at'] = now();
        $data['status'] = 1;
        $balance = $this->create($data);
        \App\transaction::CreateBalanceTransaction($balance);
        \DB::commit();
        return $balance->id;
    }


    public static function createNewBalanceForInvestorByDeposit($deposit, $request)
    {
        \DB::beginTransaction();
        $data = $request->all();
        $data['amount'] = $deposit['amount'];
        $data['status'] = 1;
        $data['investor_id'] = $deposit['investor_id'];
        $data['created_at'] = now();
        $balance = self::create($data);;
        \DB::commit();
    }

    public function deleteBalance()
    {
        \DB::beginTransaction();
        $this->update(['status' => 6]);
        \App\transaction::DeleteBalanceForInvestorByAdmin($this->attributes);
        \DB::commit();
    }

    public static function createNewBalanceForInvestorByReRunProfit($array)
    {
        return self::create([
            'amount' => $array['amount'],
            'DateRun' => $array['DateRun'],
            'status' => 4,
            'note' => $array['note'],
            'investor_id' => $array['investor_id'],
            'created_at' => now(),
        ]);
    }
}
