<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\MillAccounts;
use Faker\Generator as Faker;

$factory->define(MillAccounts::class, function (Faker $faker) {
    return [
        'user_id' =>2,
        'expense_type' =>1,
        'expense_item_type'=>1,
        'expense_amount'=>600,
        'due_pay_type'=>1,
        'due_pay_amount' =>400,
    ];
});
