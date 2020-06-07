<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller {

    function authenticate(Request $request) {
        /*
         * Authentication using JWT
         * Either username or email is required to authenticate
         * Password is hashed with PHP default algorithm method
         * 2 Steps Tests 1st Email or Username Then The Password
         * HMZ
         * */
        $using_email = false;
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        $account = User::where('username', $request->username)->first();
        // If the user used email instead of username
        if($account === null) {
            $account = User::where('email', $request->username)->first();
            if($account !== null) $using_email = true;
        }
        if($account !== null) {
            if (password_verify($request->password, $account->password)) {
                $token = base64_encode(Str::random(40));
                if($using_email) {
                    User::where('email', $request->username)->update(['token' => $token]);
                    return response()->json(User::where('email', $request->username)->first());
                }
                else {
                    User::where('username', $request->username)->update(['token' => $token]);
                    return response()->json(User::where('username', $request->username)->first());
                }
            }
            else {
                return response()->json('Failed', 401);
            }
        } else {
            return response()->json('Username is not valid', 401);
        }
    }

    function subscribe(Request $request) {
        /*
             * Password Pattern
             * At least one digit [0-9]
             * At least one lowercase character [a-z]
             * At least one uppercase character [A-Z]
             * At least one special character [*.!@#$%^&(){}[]:;<>,.?/~_+-=|\]
             * At least 8 characters in length, but no more than 32.
         * HMZ
             * */
        $this->validate($request, [
            'username' => 'required|unique:users|min:5|max:100',
            'email' => 'required|unique:users|email|max:100',
            'password' => 'required|min:8|max:32|regex:"^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,32}$"',
            'confirm_password' => 'required|min:8|max:32'
        ]);
        // Password confirmation
        if($request->password === $request->confirm_password) {
            $account = User::create($request->all());
            $token = base64_encode(Str::random(40));
            // Update token and hashing password
            User::where('username', $account->username)->update(['token' => $token, 'password' => password_hash($account->password, 1)]);
            return response()->json([$account, 'token' => $token]);
        } else {
            return response()->json('Passwords not match', 401);
        }
    }

}
