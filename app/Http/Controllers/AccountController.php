<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function create(Request $request)
    {
        $inputs = $request->all();

        if(isset($inputs['document'])) {
            $inputs['document'] = str_replace(['.', '-'], '', $inputs['document']);
        }
        if(isset($inputs['social_reason'])) {
            $inputs['social_reason'] = str_replace(['.', '-'], '', $inputs['social_reason']);
        }
        if(isset($inputs['number'])) {
            $inputs['number'] = str_replace(['.', '-', ' '], '', $inputs['number']);
        }

        if(!in_array($inputs['type'], ['Person', 'Company'])) {
            return response([
                'message' => 'Invalid account type'
            ], 400);
        }

        Validator::make($inputs, [
            'agency' => ['required'],
            'number' => ['required'],
            'digit' => ['required'],
            'type' => ['required'],
            'name' => ['required'],
            'document' => ['required', 'unique:accounts,document'],
            'fk_user' => ['required', 'exists:users,id']
        ])->validate();

        if($inputs['type'] == 'Person') {
            unset($inputs['social_reason']);
        }

        if(count(\App\Account::where('fk_user', '=', $inputs['fk_user'])->where('type', '=', $inputs['type'])->get()) > 0) {
            return response([
                'message' => 'Each user can have only one account per type'
            ], 400);
        }

        if($inputs['type'] === 'Company' && (!isset($inputs['social_reason']) || empty($inputs['social_reason'])) ) {
            return response([
                'message' => 'Account type "Company" needs the social reason'
            ], 400);
        }

        $account = \App\Account::create($inputs);

        return response($account);
    }

    public function index(Request $request, $accountId) {
        $result = \App\Account::where('id', '=', $accountId)->with(['owner', 'transactions'])->get()->toarray();
        if(count($result) == 0) {
            return response([
                'message' => 'Account not found'
            ], 404);
        }

        return response($result[0]);
    }
}
