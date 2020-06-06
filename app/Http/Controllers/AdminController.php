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

    function create(Request $request) {
        $current_account =  Auth::user();
        if($current_account->role === '1') {
            $current_admin = $current_account->admin()->first();
            if($current_admin->super == '1') {
                $this->validate($request, [
                    'username' => 'required|unique:users',
                    'password' => 'required',
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required|unique:admins',
                    'address' => 'required',
                ]);
                $admin = Admin::create($request->all());
                $account = User::create(['username' => $request->username, 'password' => $request->password, 'role' => '1']);
                $token = base64_encode(Str::random(40));
                User::where('username', $account->username)->update(['token' => $token]);
                $account->admin()->save($admin);
                return response()->json([$account, 'token' => $token, $admin]);
            }
        }
        return response()->json('You have no right to create a new admin', 401);
    }

    function update(Request $request) {

    }

}
