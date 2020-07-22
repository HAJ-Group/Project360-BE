<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VisitorController extends Controller
{

    function subscribe(Request $request) {

        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'birthday' => 'required',
            'address' => 'required',
            'city' => 'required',
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

}
