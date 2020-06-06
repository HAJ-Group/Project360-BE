<?php

namespace App\Http\Controllers;

use App\Annonce;
use App\Annoncer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['status' => 'success', 'data', Annonce::all(), 200]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function store(Request $request)
    {
        $validation = $this->validateRequest($request);

        if ($validation->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validation->errors()], 422);
        }
        $annoncer = Auth::user()->annoncer;
        $annonce = Annonce::create($request->all());
        //link between User & Annonce

        $annonce->annoncer()->associate($annoncer);
        if ($annonce->save()) {
            return response()->json(['status' => 'success', 'data' => $annonce], 201);
        } else {
            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Annonce  $annonce
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Annonce $annonce)
    {
        if (empty($annoncer)) {
            return response()->json(['status' => 'error', 'message' => 'the annoncer is not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $annoncer], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Annonce  $annonce
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Annonce $annonce)
    {
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
     * @param  \App\Annonce  $annonce
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Annonce $annonce)
    {
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
    }

    private function validateRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'title' => 'required|max:100',
            'type' => 'required|max:100',
            'description' => 'required',
            'price' => 'required',
            'address' => 'required',
            'city' => 'required|max:50',
            'status' => 'required',
            'rent' => 'required|max:100',
        ]);
    }
}
