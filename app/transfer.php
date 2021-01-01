<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transfer extends Model
{
    protected $fillable = [
        'id',
        'amount',
        'note',
        'status',
        'investor_id_From',
        'investor_id_To',
        'created_at',
        'updated_at',
    ];
    protected $with = [
        'from', 'to'
    ];

    public function from()
    {
        return $this->belongsTo(\App\Investor::class, 'investor_id_From', 'id');
    }

    public function createTransfer($request)
    {
        \DB::beginTransaction();
        \App\investorBalance::where('investor_id', $request->investor_id_From)->first()->IncreasePendingBalanceByTransfer($request->amount);
        $data = $this->create([
            'amount' => $request->amount,
            'note' => $request->note,
            'status' => 1,
            'investor_id_From' => $request->investor_id_From,
            'investor_id_To' => $request->investor_id_To,
        ]);
        \DB::commit();
        return $data;
    }

    public function rejectTransfer()
    {
        \DB::beginTransaction();
        \App\investorBalance::where('investor_id', $this->investor_id_From)->first()->DecreasePendingBalanceByTransfer($this->amount);
        $this->update(['status' => 4]);
        \DB::commit();
    }

    public function acceptTransfer()
    {
        \DB::beginTransaction();
        \App\investorBalance::where('investor_id', $this->investor_id_From)->first()->DecreasePendingBalanceByTransfer($this->amount);
        \App\investorBalance::where('investor_id', $this->investor_id_From)->first()->DecreaseProfitBalanceByTransfer($this->amount);
        \App\transaction::CreateTransferTransactionFromInvestor($this->attributes);
        \App\investorBalance::where('investor_id', $this->investor_id_To)->first()->IncreaseProfitBalanceByTransfer($this->amount);
        \App\transaction::CreateTransferTransactionToInvestor($this->attributes);
        $this->update(['status' => 2]);
        \DB::commit();
    }

    public function updateTransfer($request)
    {
        $this->update($request->all());
    }

    public function createNewTransferRequestFromInvestor($request, $Investor_id)
    {
        $data = array();
        $data['amount'] = $request->amount;
        $data['investor_id_From'] = $Investor_id;
        $data['investor_id_To'] = $request->investor_id_to;
        $data['note'] = ' ';
        $data['status'] = 1;
        $data['created_at'] = now();
        \DB::beginTransaction();
        \App\investorBalance::where('investor_id', $Investor_id)->first()->IncreasePendingBalanceByTransfer($request->amount);
        $data = $this->create($data);
        \DB::commit();
        return $data;
    }

    public function to()
    {
        return $this->belongsTo(\App\Investor::class, 'investor_id_To', 'id');
    }
}
