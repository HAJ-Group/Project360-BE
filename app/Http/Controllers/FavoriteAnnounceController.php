<?php

namespace App\Http\Controllers;

use App\Annonce;
use App\Annoncer;
use App\Favorite;
use App\User;
use Illuminate\Http\Request;

class FavoriteAnnounceController extends Controller
{
    public function index($username)
    {
        // Finding the user by username
        $user = User::where('username', $username)->first();

        if($user){
            // Finding the specific announcer
            $announcer = Annoncer::where('user_id', $user->id)->first();
            $fav_announces= Favorite::where('annoncer_id',$announcer->id)->get();
            $list_announces = collect();
            foreach ($fav_announces as $fav_announce){
                $announce = Annonce::with('images')->where('id',$fav_announce->annonce_id)->first();
                $list_announces->add($announce);
            }
            if($list_announces->count()>0)
                return Response()->json($list_announces, 200);
            else
                return Response()->json(['error' => "Does not exist any favorite announce for this announcer"], 404);
        }
        return Response()->json(['error' => "the specific user does not exist "], 404);
    }
}
