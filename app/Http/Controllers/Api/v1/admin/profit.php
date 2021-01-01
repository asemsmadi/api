<?php

namespace App\Http\Controllers\Api\v1\admin;

use App\balanceProfits;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\profit\calculateProfetAccept;
use App\transaction;
use Illuminate\Http\Request;
use \App\Http\Requests\admin\profit\calculateProfet;
use Illuminate\Support\Carbon;
use \App\Http\Resources\profitBalance as resource;

class profit extends Controller
{
    public function CalculateProfit(calculateProfet $request)
    {
        $balances = \App\balance::where('status', '<>', 6)->get();
        return $this->CreateResourceOfProfit($request->percent, $balances, $request->date);
    }

    public function getResultAfterCalculate($percent, $balance)
    {

        $startDatOfBalance = Carbon::parse($balance->DateRun)->day;
        $countDayForBalanceThatMadeAProfit = (30 - $startDatOfBalance) + 1;
        $rateOfProfit = (double)($percent / 100);
        $rateProfitForEachDay = (double)($rateOfProfit / 30);
        return [
            'startDatOfBalance' => $startDatOfBalance,
            'countDayForBalanceThatMadeAProfit' => $countDayForBalanceThatMadeAProfit,
            'amountProfit' => ((double)$countDayForBalanceThatMadeAProfit * (double)$rateProfitForEachDay * (double)$balance->amount),
        ];
    }

    public function CreateResourceOfProfit($percent, $balances, $date)
    {
        $array = array();
        foreach ($balances as $balance) {
            if (CheckIfBalanceIsMakeAProfitInThisMonth($balance->id, $date) == false) {
                $result = $this->getResultAfterCalculate($percent, $balance);
                $array[] = array_merge($result, $balance->toArray());
            }

        }
        return resource::collection($array);
    }

    public function registerProfitInBalance(calculateProfetAccept $request, $id)
    {
        $balance = \App\balance::findOrFail($id);
        if (CheckIfBalanceIsMakeAProfitInThisMonth($balance->id, $request->date) == false) {
            $calculate = $this->getResultAfterCalculate($request->percent, $balance);
            $result = array_merge($calculate, $balance->toArray());
        } else {
            return response()->json(['error' => 'غير مسموح بهذه العمليه لانه تم حساب الارباح من قبل لهذا الرصيد او ان الرصيد تم حذفه'], '403');
        }
        \DB::beginTransaction();
        $balance->update(['DateRun'=>  Carbon::parse($balance->DateRun)->firstOfMonth()]);
        transaction::CreateNewTransactionByProfit($result);
        $investor = \App\Investor::findOrFail($result['user']['id']);
        $investorBalance = \App\investorBalance::where('investor_id', $investor->id)->first();
        $investorBalance->incrementProfit($result['amountProfit']);
        \App\balanceProfits::create([
            'balance_id' => $id,
            'created_at', $request->date
        ]);
        $investor->user->notify(new \App\Notifications\investor\profit\NewProfitBalance());
        \DB::commit();
        return response()->json(['success' => 'تم اضافة الارباح بنجاح']);
    }
}
