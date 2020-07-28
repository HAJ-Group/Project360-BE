<?php

namespace App\Http\Controllers;

use App\Annonce;
use App\Annoncer;
use App\Image;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use function count;

class AnnouncerAnnounceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($username)
    {
        // Finding the user by username
        $user = User::where('username', $username)->first();

        if($user){
            // Finding the specific announcer
            $announcer = Annoncer::where('user_id', $user->id)->first();

            if($announcer){
                $announces = $announcer->annonces;
                if(count($announces) > 0){

                    foreach ($announces as $announce){
                       $announce->images;
                    }
                    return Response()->json($announces, 200);
                }
                return Response()->json(['error' => "Does not exist any announce for this announcer"], 404);
            }
            return Response()->json(['error' => "the specific announcer does not exist "], 404);
        }
        return Response()->json(['error' => "the specific user does not exist "], 404);

    }

    /**
     * download images for a specific announce the specified resource.
     *
     * @param $username
     * @param $announce_id
     * @return BinaryFileResponse
     */
    public function downloadImages(){
        return Response()->download('1.png', 'image');
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

        // Finding the user by username
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
                        'position_map' => $request->get('positionMap'),
                        'status' => $request->get('status'),
                        'rent' => $request->get('rent'),
                        'surface' => $request->get('surface'),
                        'pieces' => $request->get('pieces'),
                        'rooms' => $request->get('rooms'),
                        'premium' => $announcer->premium,
                        'annoncer_id' => $announcer->id,
                    ]
                );

                $this->storeImages($request, $username, $announce->id);

                return Response()->json(['data' => $announce, 'message' => "the announce {$announce->id} was created successfully and attached with the announcer {$announcer->id} "], 201);
            }
            return Response()->json(['error' => "the specific announcer does not exist "], 404);
        }
        return Response()->json(['error' => "the specific user does not exist "], 404);

    }


    public function storeImages(Request $request, $username, $announce_id){
        $uploadPath = "announces-images/" . $username . "/" . $announce_id;
        $i = 1;
        while ($request->hasFile('image'.$i)){

            /*--------- Store image in public/images folder ---------*/

            $file = $request->file('image' . $i);
            $imageName = $file->getClientOriginalName();
            $file->move($uploadPath, $imageName);


            /*--------- Storing the information of the image in the database ---------*/

            // => Getting the extension of the image
            $extension = $file->getClientOriginalExtension();
            $imageType = 1;
            if($extension == 'png' || $extension == 'jpeg' || $extension == 'gif')
                $imageType = 2;

            $image = Image::create(
                [
                    'name' => $imageName,
                    'type' => $imageType,
                    'annonce_id' => $announce_id
                ]
            );

            $i ++;
        }

        if ($i != 1 )
            return Response()->json(['message' => 'images was uploaded successfully and stored in the database !']);
        else
            return Response()->json(['message' => 'An error has occurred !']);

    }


    /**
     * Display the specified resource.
     *
     * @param $username
     * @param $id
     * @return void
     */
    public function show($username = null, $id)
    {
        // Finding the user by username
       /* $user = User::where('username', $username)->first();*/
        $user = Auth::user();

        if($user) {
            // Finding the specific announcer
            $announcer = Annoncer::where('user_id', $user->id)->first();

            if ($announcer) {
                $announce = $announcer->annonces()->find($id);
                if ($announce){
                    $announce->images;
                    return Response()->json($announce);
                }
                return Response()->json(['error' => "the specific announce with id = ${id} does not exist ", 'code' => 404], 404);
            }
            return Response()->json(['error' => "the specific announcer does not exist "], 404);
        }
        return Response()->json(['error' => "You should authenticate !"], 401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $username
     * @param $id
     * @return void
     */
    public function update(Request $request, $username, $id)
    {

        // Finding the user by username
        $user = User::where('username', $username)->first();

        if($user){
            // Finding the specific announcer
            $announcer = Annoncer::where('user_id', $user->id)->first();

            if($announcer){
                $announce = $announcer->annonces()->find($id);
                if($announce){


                    // Validate the data send in the request object
                    $this->validateRequest($request);

                    // Delete old images associated with the announce from the database
                    $announce->images()->delete();

                    // Delete old images from public folder
                    $this->deleteImagesForAnnounce($username, $id);

                    // Fill the announce with the new data
                    $announce->fill($request->all());

                    // Save changes
                    $announce->save();

                    // Store the new images for the announce
                    $this->storeImages($request, $username, $announce->id);

                    return Response()->json(['data' => $announce, 'message' => "the announce {$announce->id} was updated successfully for the announcer : {$announcer->first_name} "], 201);
                }
                return Response()->json(['error' => "Does not exist any announce with id = {$id} for the announcer {$announcer->first_name}"], 404);
            }
            return Response()->json(['error' => "the specific announcer does not exist "], 404);
        }
        return Response()->json(['error' => "the specific user does not exist "], 404);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param $username
     * @param $id
     * @return void
     */
    public function destroy($username, $id)
    {
        // Finding the user by username
        $user = User::where('username', $username)->first();

        if($user) {

            // Finding the specific announcer
            $announcer = Annoncer::where('user_id', $user->id)->first();

            if ($announcer) {
                $announce = $announcer->annonces()->find($id);

                if ($announce){

                    // Delete the images associated with the announce from the database
                    $announce->images()->delete();

                    // Delete images from public folder
                    $this->deleteImagesForAnnounce($username, $id);

                    // Delete the announce
                    $announce->delete();

                    return Response()->json(['message' => "the announce owned by {$username} and with id = {$id} has deleted successfully !", 'code' => 204], 204);

                }
                return Response()->json(['error' => "the announcer {$announcer->id} does not have this announce with id = {$id}"], 404);
            }
            return Response()->json(['error' => "the specific announcer {$announcer->id} does not exist "], 404);
        }
        return Response()->json(['error' => "the specific user does not exist "], 404);
    }

    public function deleteImagesForAnnounce($username, $id){
        // Delete the whole folder of the announce that contains images
        $announcePath = "announces-images/" . $username . "/" . $id;
        File::deleteDirectory($announcePath);
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
            'surface' => 'required|numeric|max:4',
            'pieces' => 'required|numeric|min:0',
            'rooms' => 'required|numeric|min:0'
        ];

        $this->validate($request, $rules);
    }
}
