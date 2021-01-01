<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class profitBalance extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->resource['id'],
            'accountID' => $this->resource['user']['id'],
            'username' => $this->resource['user']['user']['name'],
            'amount' => $this->resource['amount'],
            'DateRun' => $this->resource['DateRun'],
            'startDatOfBalance' => $this->resource['startDatOfBalance'],
            'countDayForBalanceThatMadeAProfit' => $this->resource['countDayForBalanceThatMadeAProfit'],
            'amountProfit' => $this->resource['amountProfit'],

        ];
    }
}
