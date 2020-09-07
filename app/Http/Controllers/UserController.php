<?php


namespace App\Http\Controllers;

use App\Mail\ConfirmationEmail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use const http\Client\Curl\AUTH_ANY;

class UserController extends Controller {

    /**
     * Method for regular user authentication
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
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
                    if($account->active === 1) {
                        return response()->json(User::where('email', $request->username)->first()->token);
                    } else {
                        return response()->json('Email is not confirmed!', 401);
                    }
                }
                else {
                    User::where('username', $request->username)->update(['token' => $token]);
                    if($account->active === 1) {
                        $user = User::where('username', $request->username)->first();
                        return response()->json(['token' => $user->token, 'role' => $user->role]);
                    } else {
                        return response()->json('Email is not confirmed! Check your mail for confirmation', 401);
                    }
                }
            }
            else {
                return response()->json('Failed', 401);
            }
        } else {
            return response()->json('Account not found', 401);
        }
    }

    function getUser() {
        return Auth::user();
    }


    /**
     * Method for regular user subscription
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
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
            // Sending mail confirmation
            $this->sendEmailConfirmation($account->username);
            return response()->json([$account, $account->id]);
        } else {
            return response()->json('Passwords not match', 401);
        }
    }

    /**
     * Confirmation email using illuminate Mail middleware
     * @param $account_id
     * @return \Illuminate\Http\JsonResponse
     */
    function sendEmailConfirmation($username) {
        $account = User::where('username', $username)->first();
        if($account->active == '0') {
            $_SESSION['username'] = $account->username;
            $_SESSION['code'] = rand ( 10000 , 99999 );
            User::where('username', $account->username)->update(['code' => $_SESSION['code']]);
            Mail::to($account->email)->send(new ConfirmationEmail());
            return response()->json('Email Confirmation sent');
        } else {
            return response()->json('Email already confirmed', 401);
        }
    }

    /**
     * @param $username
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    function confirmEmail($username, $code) {
        $account = User::where('username', $username)->first();
        if($account->code === null) return response()->json('Something wrong resend email verification', 401);
        if($account->code === $code) {
            User::where('username', $username)->update(['active' => '1']);
            return response()->json('Email is confirmed successfully!');
        }
        return response()->json('Code is not correct', 401);
    }

    function cancelCode($id) {
        $user = User::find($id);
        $user->update(['code' => 0]);
        return response()->json($user);
    }

}
