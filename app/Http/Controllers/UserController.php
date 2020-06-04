<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{

    function authenticate(Request $request) {

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->input('username'))->first();

        if ($user->password === $request->input('password')) {
            $token = base64_encode(Str::random(40));
            User::where('username', $request->input('username'))->update(['token' => $token]);
            return response()->json(User::where('username', $request->input('username'))->first());
        }

        else {
            return response()->json('Failed', 401);
        }

    }

    function subscribe(Request $request) {

    }

}
