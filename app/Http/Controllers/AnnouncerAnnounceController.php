<?php

namespace App\Http\Controllers;

use App\Annonce;
use App\Annoncer;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Http\Response;

class AnnouncerAnnounceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['store', 'storeImage']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $username
     * @return JsonResponse
     */
    public function store(Request $request, $username)
    {

        // Finding the user using username
        $user = User::where('username', $username)->first();

        if($user){

            // Finding the specific announcer
            $announcer = Annoncer::where('user_id', $user->id)->first();

            if($announcer){
                $this->validateRequest($request);

                $announce = Annonce::create(
                    [
                        'title' => $request->get('title'),
                        'type' => $request->get('type'),
                        'description' => $request->get('description'),
                        'price' => $request->get('price'),
                        'address' => $request->get('address'),
                        'city' => $request->get('city'),
                        'position_map' => $request->get('position_map'),
                        'status' => $request->get('status'),
                        'rent' => $request->get('rent'),
                        'premium' => $announcer->premium,
                        'annoncer_id' => $announcer->id,
                    ]
                );

                return Response()->json(['data' => $announce, 'message' => "the announce {$announce->id} was created successfully and attached with the announcer {$announcer->id} "], 201);
            }
            return Response()->json(['error' => "the specific announcer {$announcer->id} does not exist "], 404);
        }
        return Response()->json(['error' => "the specific user does not exist "], 404);

    }

    public function storeImage(Request $request){
        $uploadPath = "images";
        $i = 1;
        while ($request->hasFile('image'.$i)){
            $file = $request->file('image' . $i);
            $imageName = $file->getClientOriginalName();
            $file->move($uploadPath, $imageName);
            $i ++;
        }

        if ($i != 1 )
            return Response()->json(['message' => 'images was uploaded successfully !']);
        else
            return Response()->json(['message' => 'An error has occurred !']);

    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return void
     */
    public function show($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return void
     */
    public function update(Request $request, $id)
    {

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Annonce $annonce
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {

    }



    private function annonceFromRequest(Request $request, Annonce $annonce)
    {
        $annonce->title = $request->title;
        $annonce->type = $request->type;
        $annonce->description = $request->description;
        $annonce->price = $request->price;
        $annonce->address = $request->address;
        $annonce->city = $request->city;
        $annonce->position_map = $request->position_map;
        $annonce->status = $request->status;
        $annonce->rent = $request->rent;
        $annonce->premium = $request->premium;
        return $annonce;
    }

    private function validateRequest(Request $request)
    {
        $rules = [
            'title' => 'required|max:100',
            'type' => 'required|max:100',
            'description' => 'required|max:100000',
            'city' => 'required|max:50',
            'status' => 'required',
            'rent' => 'required|max:100',
        ];

        $this->validate($request, $rules);
    }
}
