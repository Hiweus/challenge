<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function create(Request $request)
    {   
        $inputs = $request->validate([
            'value' => ['required'],
            'fk_account' => ['required', 'exists:accounts,id'],
            'type' => ['required']
        ]);


        if(!in_array($inputs['type'], ['Payment', 'Deposit', 'Transfer', 'Recharge', 'Purchase'])) {
            return response([
                'message' => 'Invalid type of transaction, should be one of these "Payment, Deposit, Transfer, Recharge, Purchase"'
            ], 400);
        }

        $transaction = \App\Transaction::create($inputs);
        return response($transaction);
    }
}
