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

        $user = Account::where('username', $request->input('username'))->first();

        if ($user->password === $request->input('password')) {
            $token = base64_encode(Str::random(40));
            Account::where('username', $request->input('username'))->update(['token' => $token]);
            return response()->json(Account::where('username', $request->input('username'))->first());
        }

        else {
            return response()->json('Failed', 401);
        }

    }

}
