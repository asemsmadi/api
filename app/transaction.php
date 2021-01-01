<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\balance;

class transaction extends Model
{
    protected $fillable = [
        'id',
        'amount',
        'Message',
        'type',
        'investor_id',
        'created_at',
    ];

    public static function CreateBalanceTransaction(balance $balance)
    {
        self::create([
            'amount' => $balance->amount,
            'Message' => 'تم اضافة رصيد الى حسابك',
            'type' => 1,
            'investor_id' => $balance->investor_id,
            'created_at' => now()
        ]);
    }

    public static function createDepositTransaction($deposit)
    {
        self::create([
            'amount' => $deposit['amount'],
            'Message' => '  تم اضافة رصيد الى حسابك بواسطة الابداع',
            'type' => 1,
            'investor_id' => $deposit['investor_id'],
            'created_at' => now()
        ]);
    }

    public static function DeleteBalanceForInvestorByAdmin($balance)
    {
        self::create([
            'amount' => $balance['amount'],
            'Message' => '  تم حذف رصيد من حسابك بواسطة مدير الموقع',
            'type' => 2,
            'investor_id' => $balance['investor_id'],
            'created_at' => now()
        ]);
    }

    public static function CreateNewTransactionByProfit($result)
    {
        $profit = $result['amountProfit'];
        $mainAmount = $result['amount'];
        self::create([
            'amount' => $result['amountProfit'],
            'Message' => "  تم اضافة رصيد ارباح بقيمة   $profit   الى حسابك عن المبلغ $mainAmount ",
            'type' => 1,
            'investor_id' => $result['investor_id'],
            'created_at' => now()
        ]);
    }

    public static function CreateTransferTransactionFromInvestor($transfer)
    {

        self::create([
            'amount' => $transfer['amount'],
            'Message' => "تم سحب رصيد من حسابك بواسطة التحويل الى مستخدم اخر",
            'type' => 3,
            'investor_id' => $transfer['investor_id_From'],
            'created_at' => now()
        ]);
    }

    public static function CreateTransferTransactionToInvestor($transfer)
    {

        self::create([
            'amount' => $transfer['amount'],
            'Message' => "تم ايداع رصيد الى حسابك بواسطة التحويل من مستخدم اخر",
            'type' => 4,
            'investor_id' => $transfer['investor_id_To'],
            'created_at' => now()
        ]);
    }

    public static function CreateNewTransactionByWithdrawal($withdrawal)
    {
        self::create([
            'amount' => $withdrawal['amount'],
            'Message' => "تم سحب مبلغ من حسابك",
            'type' => 2,
            'investor_id' => $withdrawal['investor_id'],
            'created_at' => now()
        ]);
    }

    public static function createTransactionFromRunProfit($balance)
    {
        self::TransactionDecreaseBalance($balance);
        self::TransactionIncreaseBalance($balance);
    }

    public static function TransactionDecreaseBalance($balance)
    {
        self::create([
            'amount' => $balance->amount,
            'Message' => " تم سحب مبلغ من حسابك بسبب اعادة نشغيل المبلغ",
            'type' => 2,
            'investor_id' => $balance->investor_id,
            'created_at' => now()
        ]);
    }

    public static function TransactionIncreaseBalance($balance)
    {
        self::create([
            'amount' => $balance->amount,
            'Message' => " تم اضافة رصيد جديد الى رصيد الاستثمار ",
            'type' => 2,
            'investor_id' => $balance->investor_id,
            'created_at' => now()
        ]);
    }
}
