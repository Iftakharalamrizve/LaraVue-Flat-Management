<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BillCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($bill){
                return [
                    'id' => $bill->id,
                    'user_id' => $bill->user_id,
                    'expense_type' => $bill->email,
                    'expense_item_type' => $bill->phone,
                    'expense_amount' => $bill->profile,
                    'due_pay_type' => $bill->role,
                    'due_pay_amount' => $bill->role,
                ];
            })
        ];
    }
}
