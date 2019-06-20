<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MillAccounts extends Model
{
    //
    protected $fillable = [
        'user_id', 'expense_type','expense_item_type','expense_amount','due_pay_type','due_pay_amount',
    ];
    public function addNewAccount($request)
    {
        $request->validate([
            'expense_type' => 'required',
            'expense_item_type' => 'required',
            'expense_amount' => 'required',
        ]);
        $attribute = [
            'user_id' => 1,
            'expense_type' =>$request->expense_type,
            'expense_item_type' =>$request->expense_item_type,
            'expense_amount' =>$request->expense_amount,
            'due_pay_type' =>$request->due_pay_type,
            'due_pay_amount' =>$request->due_pay_amount,
        ];
        $accountId = MillAccounts::create($attribute)->id;
        return $accountId;
    }

    public function updateNewAccount($request){
        $request->validate([
            'expense_type' => 'required',
            'expense_item_type' => 'required',
            'expense_amount' => 'required',
        ]);
        $attribute = [
            'user_id' => 1,
            'expense_type' =>$request->expense_type,
            'expense_item_type' =>$request->expense_item_type,
            'expense_amount' =>$request->expense_amount,
            'due_pay_type' =>$request->due_pay_type,
            'due_pay_amount' =>$request->due_pay_amount,
        ];
        $accountId = MillAccounts::update($attribute)->id;
        return $accountId;
    }

    
}
