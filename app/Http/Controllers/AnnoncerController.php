<?php

namespace App\Http\Controllers;

use App\Annonce;
use App\Annoncer;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AnnoncerController extends Controller
{

    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['status' => 'success', 'data', Annoncer::all(), 200]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validation = $this->validateRequest($request);

        if ($validation->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validation->errors()], 422);
        }
        $user = Auth::user();
        $annoncer = Annoncer::create($request->all());


        //link between User & Annoncer
        $user->annoncer()->save($annoncer);
        if ($annoncer->save()) {
            Annoncer::find($annoncer->id)->update(['email' => $user->email]);
            return response()->json(['status' => 'success', 'data' => $annoncer], 201);
        } else {
            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Annoncer $annoncer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $annoncer = Annoncer::findOrFail($id);
        if (empty($annoncer)) {
            return response()->json(['status' => 'error', 'message' => 'the annoncer is not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $annoncer], 200);
    }

    public function getUserAnnouncer()
    {
        $user = Auth::user();
        return response()->json($user->annoncer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Annoncer $annoncer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {        return response()->json($request->all());

        $announcer = Annoncer::findOrFail($id);
        if (Auth::id() == $announcer->user_id) {
            if (empty($announcer)) {
                return response()->json(['status' => 'error', 'message' => 'the announcer is not found'], 404);
            }
            $validation = $this->validateRequest($request);
            if ($validation->fails()) {
                return response()->json(['status' => 'error', 'errors' => $validation->errors()], 422);
            }
            else{
                $c = $this->annoncerFromRequest($request, $announcer);
                if ($c->update()) {
                    return response()->json(['status' => 'success', 'data' => $c], 201);
                }
                else {
                    return response()->json(['status' => 'error'], 500);
                }
            }
        } else {
            return response()->json(['status' => 'error'], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Annoncer $annoncer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $annoncer = Annoncer::findOrFail($id);
        if (empty($annoncer)) {
            return response()->json(['status' => 'error', 'message' => 'the annoncer is not found'], 404);
        } elseif ($annoncer->delete()) {
            return response()->json(['status' => 'success', 'data' => $annoncer], 200);
        } else {
            return response()->json(['status' => 'error'], 500);
        }
    }

    public function getAnnonces()
    {
        return response()->json(['status' => 'success', 'data' => Auth::user()->annoncer->annonces], 200);
    }

    private function validateRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'last_name' => 'required|max:100',
            'first_name' => 'required|max:100',
            'phone' => 'max:50',
            'city' => 'required|max:50',
        ]);
    }

    private function annoncerFromRequest($request, $annoncer)
    {
        $annoncer->last_name = $request->last_name;
        $annoncer->first_name = $request->first_name;
        $annoncer->phone = $request->phone;
        $annoncer->address = $request->address;
        $annoncer->city = $request->city;
        // $annoncer->email = $request->email;
           $this->uploadImage($request,$annoncer);
        $annoncer->date_of_birth = $request->date_of_birth;
        return $annoncer;
    }
    public function uploadImage(Request $request,$announcer)
    {
        $response = null;
        if ($request->hasFile('picture')) {
            $original_filename = $request->file('picture')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = 'assets/images/announcers';
            $image = 'U-' . time() . '.' . $file_ext;

            if ($request->file('picture')->move($destination_path, $image)) {
                $announcer->picture = 'assets/images/announcers' . $image;
                return $this->responseRequestSuccess($announcer);
            } else {
                $announcer->picture = 'hahaha';
                return $this->responseRequestError('Cannot upload file');
            }
        } else {
            $announcer->picture = 'mouhaha';
            return $this->responseRequestError('File not found');
        }
    }

    protected function responseRequestSuccess($ret)
    {
        return response()->json(['status' => 'success', 'data' => $ret], 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    protected function responseRequestError($message = 'Bad request', $statusCode = 200)
    {
        return response()->json(['status' => 'error', 'error' => $message], $statusCode)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}
