<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class investorBalance extends Model
{
    protected $fillable = [
        'id',
        'pending',
        'profit',
        'investor_id'
    ];

    public function incrementProfit(float $amount)
    {
        $this->increment('profit', $amount);
    }

    public function IncreasePendingBalanceByTransfer(float $amount)
    {
        $this->increment('pending', $amount);
    }

    public function DecreasePendingBalanceByTransfer(float $amount)
    {
        $this->decrement('pending', $amount);
    }

    public function DecreaseProfitBalanceByTransfer(float $amount)
    {
        $this->decrement('profit', $amount);
    }

    public function IncreaseProfitBalanceByTransfer(float $amount)
    {
        $this->increment('profit', $amount);
    }


    public function IncreasePendingBalanceByWithdrawal(float $amount)
    {
        $this->increment('pending', $amount);
    }


    public function DecreasePendingBalanceByRejectWithdrawalRequest(float $amount)
    {
        $this->decrement('pending', $amount);
    }

    public function DecreaseProfitBalanceByRejectWithdrawalRequest(float $amount)
    {
        $this->decrement('profit', $amount);
    }

    public function IncreasePendingByReRunProfit(float $amount)
    {
        $this->increment('pending', $amount);
    }

    public function DecreasePendingByReRunProfit(float $amount)
    {
        $this->decrement('pending', $amount);
    }

    public function DecreaseProfitByReRunProfit(float $amount)
    {
        $this->decrement('profit', $amount);
    }


}
