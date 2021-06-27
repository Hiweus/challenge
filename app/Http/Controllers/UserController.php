<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function create(Request $request)
    {
        $inputs = $request->all();
        if(isset($inputs['cpf'])) {
            $inputs['cpf'] = str_replace(['.', '-'], '', $inputs['cpf']);
        }
        if(isset($inputs['password'])) {
            $inputs['password'] = hash("sha256", $inputs['password']);
        }

        $inputs = Validator::make($inputs, [
            'name' => ['required'],
            'cpf' => ['required', 'unique:\App\User,cpf'],
            'phone' => ['required'],
            'email' => ['required', 'unique:\App\User,email', 'email'],
            'password' => ['required']
        ])->validate();

        $user = \App\User::create($inputs);

        return response($user);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        return response(\App\User::where('name', 'like', $query.'%')->orWhere('cpf', 'like', $query.'%')->get()->toarray());
    }

    public function index(Request $request, $userId)
    {
        $result = \App\User::where('id', '=', $userId)->with('accounts')->get()->toarray();
        if(count($result) == 0) {
            return response([
                'message' => 'User not found'
            ], 404);
        }
        
        return response($result[0]);
    }
}
