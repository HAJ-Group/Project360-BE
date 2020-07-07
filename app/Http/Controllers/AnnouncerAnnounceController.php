<?php

namespace App\Http\Controllers;

use App\Annonce;
use App\Annoncer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class AnnonceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'getPremiumAnnonces', 'store2']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['status' => 'success', 'data', Annonce::where('premium', 0)->get(), 200]);
    }


    public function getPremiumAnnonces()
    {
        $annonces = Annonce::where('premium', 1)->get()->toArray();
        $rows = count($annonces) % 2 == 0 ? count($annonces) / 2 : (count($annonces) / 2) + 1;
        $tab = [];
        $j = 0;
        for($i = 0; $i<intval($rows); $i++ ){
            $row = array_slice($annonces, $j, 2);
            $tab[] = $row;
            $j+=2;
        }
//        return $tab;
        return response()->json(['status' => 'success', 'data', $tab , 200]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $username)
    {
//        return $request->all();
        $validation = $this->validateRequest($request);

        if ($validation->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validation->errors()], 422);
        }
        $annoncer = Auth::user()->annoncer;

        $annonce = $this->annonceFromRequest($request, new Annonce());

        //link between User & Annonce

        $annonce->annoncer()->associate($annoncer);
        if ($annonce->save()) {
            return response()->json(['status' => 'success', 'data' => $annonce], 201);
        } else {
            return response()->json(['status' => 'error'], 500);
        }
    }

    public function store2(Request $request, $username)
    {

        // Finding the user using username
        $user = User::where('username', $username)->first();

        // Finding the specific announcer
        $announcer = Annoncer::where('user_id', $user->id)->first();

        // Validate request and return request->all()
        $validation = $this->validateRequest($request);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Filling the announcer_id and premium of the announce
        $announce = $this->annonceFromRequest($request, new Annonce());

        $announce->annoncer_id = $announcer->id;
        $announce->premium = $announcer->premium;

        $announceCreated = Annonce::create($request->all()); //columns that are not belong will have truncated

        return Response()->json(['data' => $announceCreated], Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Annonce $annonce
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $annonce = Annonce::findOrFail($id);
        if (empty($annonce)) {
            return response()->json(['status' => 'error', 'message' => 'the annonce is not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $annonce], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Annonce $annonce
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $annonce = Annonce::findOrFail($id);
        if (empty($annonce)) {
            return response()->json(['status' => 'error', 'message' => 'the annonce is not found'], 404);
        }

        $validation = $this->validateRequest($request);

        if ($validation->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validation->errors()], 422);
        }

        $c = $this->annonceFromRequest($request, $annonce);

        if ($c->update()) {
            return response()->json(['status' => 'success', 'data' => $c], 201);
        } else {
            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Annonce $annonce
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $annonce = Annonce::findOrFail($id);
        if (empty($annonce)) {
            return response()->json(['status' => 'error', 'message' => 'the annonce is not found'], 404);
        } elseif ($annonce->delete()) {
            return response()->json(['status' => 'success', 'data' => $annonce], 200);
        } else {
            return response()->json(['status' => 'error'], 500);
        }
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
        return Validator::make($request->all(), [
            'title' => 'required|max:100',
            'type' => 'required|max:100',
            'description' => 'required|max:100000',
            'city' => 'required|max:50',
            'status' => 'required',
            'rent' => 'required|max:100',
        ]);
    }
}
