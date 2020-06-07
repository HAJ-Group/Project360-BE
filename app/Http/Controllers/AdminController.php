<?php

namespace App\Http\Controllers;

use App\Admin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminController extends Controller {

    function __construct()
    {
        $this->middleware('auth');
    }

    function all() {
        $account = Auth::user();
        if($account->role === '1') {
            return response()->json(Admin::all());
        }
        return response()->json('You have no right to access this data', 401);
    }

    function profile() {
        $account = Auth::user();
        if($account->role === '1'){
            $admin = $account->admin()->first();
            return response()->json($admin);
        }
        return response()->json('null');
    }

    /**
     * Super admin right to create another admin full account
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    function create(Request $request) {
        $current_account =  Auth::user();
        if($current_account->role === '1') {
            $current_admin = $current_account->admin()->first();
            // super admin action
            if($current_admin->super == '1') {
                // validating input data
                $this->validate($request, [
                    'username' => 'required|unique:users|min:5|max:100',
                    'email' => 'required|unique:users|unique:admins|email|max:100',
                    'password' => 'required|min:8|max:50|regex:"^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,32}$"',
                    'confirm_password' => 'required|min:8|max:50',
                    'first_name' => 'required|max:100',
                    'last_name' => 'required|max:100',
                    'address' => 'required|min:5|max:255',
                ]);
                // Password confirmation
                if($request->password === $request->confirm_password) {
                    // inserting data into users and admins table
                    $admin = Admin::create($request->all());
                    $account = User::create([
                        'username' => $request->username,
                        'email' => $request->email,
                        'password' => password_hash($request->password, 1),
                        'role' => '1'
                    ]);
                    // updating token
                    $token = base64_encode(Str::random(40));
                    User::where('username', $account->username)->update(['token' => $token]);
                    // Link users table with admins table with current foreign key
                    $account->admin()->save($admin);
                    return response()->json([$account, 'token' => $token, $admin]);
                } else {
                    return response()->json('Passwords not matching', 401);
                }
            }
        }
        return response()->json('You have no right to create a new admin', 401);
    }

    /*function superCreate(Request $request) {
        $this->validate($request, [
            'username' => 'required|unique:users',
            'email' => 'required|unique:admins|unique:users',
            'password' => 'required|min:8|max:32',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
        ]);
        $admin = Admin::create($request->all());
        $account = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => password_hash($request->password, 1),
            'role' => '1'
        ]);
        $token = base64_encode(Str::random(40));
        User::where('username', $account->username)->update(['token' => $token]);
        $account->admin()->save($admin);
        return response()->json([$account, 'token' => $token, $admin]);
    }*/

    function update(Request $request) {

    }

}
