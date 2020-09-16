<?php


namespace App\Http\Controllers;

use App\Mail\JokesEveryday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller {


    /**
     * @param $username
     * @return \Illuminate\Http\JsonResponse
     */
    function send(Request $request) {
        echo $request->target;
        $target = $request->target;
        Mail::to($target)->send(new JokesEveryday());
        $this->rotate();
        return redirect('smtp?email='.$target.'&message='.'Sent To ' . $target . ' Successfully | next sender = '.$_SESSION['sender']);
        //return response()->json('Sent To ' . $target . ' Successfully | next sender = '.$_SESSION['sender'], 200);
    }

    function init() {
        try {
            session_destroy();
            return redirect('smtp?message=initialized successfully');
            //return response()->json('Init +1 !!');
        } catch (\Exception $e) {
            //return response()->json('Session already destroyed');
        }
    }

    function rotate() {
        $_SESSION['full_counter']++;
        echo '<h1>-> FC = ' .$_SESSION['full_counter'].'</h1>';
        $_SESSION['rotation_counter']++;
        echo '<h1>-> RC = ' .$_SESSION['rotation_counter'].'</h1>';
        echo '<h1>-> RV = ' .$_SESSION['rotation_value'].'</h1>';
        echo '<h1>-> S = '.$_SESSION['sender'].'</h1>';
        echo '<h1>-> SL = '.$_SESSION['sender_length'].'</h1>';
        if ($_SESSION['rotation_counter'] === $_SESSION['rotation_value']) {
            if($_SESSION['sender'] < $_SESSION['sender_length'] - 1) {
                $_SESSION['sender']++;
            }
            else {
                $_SESSION['sender'] = 0;
            }
            $_SESSION['rotation_counter'] = 0;
            echo '<h1>==> S = '.$_SESSION['sender'].'</h1>';
            echo '<h1>==> RC = '.$_SESSION['rotation_counter'].'</h1>';
            echo '<h1> ** Finished **</h1>';
        }
    }


}
