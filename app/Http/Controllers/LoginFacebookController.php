<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Auth;
class LoginFacebookController extends Controller
{
   

    use AuthenticatesUsers;
    

    protected $redirectTo = RouteServiceProvider::HOME;

   
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider()
    {
        return response()->json(Socialite::driver('facebook')->stateless()->redirect());
    }

   
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->stateless()->user();
       // dd($user);

        $user=User::firstOrCreate([
            'name'=>$user->getName(),
            'email'=>$user->getEmail(),
            'provider_id'=>$user->getId(),
        ]);
        //Auth::Login($user,true);
        return response()->json($user);

        // $user->token;
    }
}

