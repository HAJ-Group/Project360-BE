<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AccountController extends Controller {

    function authenticate(Request $request) {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        $account = Account::where('username', $request->input('username'))->first();
        if ($account->password === $request->input('password')) {
            $token = base64_encode(Str::random(40));
            Account::where('username', $request->input('username'))->update(['token' => $token]);
            return response()->json(Account::where('username', $request->input('username'))->first());
        }
        else {
            return response()->json('Failed', 401);
        }
    }

    function subscribe(Request $request) {
        $this->validate($request, [
            'username' => 'required|unique:accounts',
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|unique:accounts',
            'birthday' => 'required',
            'address' => 'required',
            'city' => 'required',
            'password' => 'required',
        ]);
        $account = Account::create($request->all());
        $token = base64_encode(Str::random(40));
        Account::where('username', $account->username)->update(['token' => $token]);
        return response()->json([$account, 'token' => $token]);
    }

}
