<?php


namespace App\Http\Controllers;

use App\Mail\JokesEveryday;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller {


    function config(Request $request) {
        // Senders
        if($request->has('ss')){
            $_SESSION['sender'] = (integer)$request->ss;
        }
        if($request->has('rv')){
            $_SESSION['rotation_value'] = (integer)$request->rv;
        }
        if($request->has('sender-delivery')) {
            $_SESSION['sender-delivery'] = $request->senders;
        }
        // Compose
        if($request->has('from')) {
            $_SESSION['from'] = $request->from;
        }
        if($request->has('subject')) {
            $_SESSION['subject'] = $request->subject;
        }
        if($request->has('body')) {
            $_SESSION['body'] = $request->body;
        }
        return redirect('smtp?message=Mail Configuration is ready for use');
    }

    /**
     * @param $username
     * @return \Illuminate\Http\JsonResponse
     */
    function send(Request $request) {
        $target = $request->target;
        $sender = $_SESSION['sender'];
        // SENDING THE MAIL
        /*Mail::to($target)->send(new JokesEveryday());*/
        Mail::send('mailTemplate', [], function($message) use ($target) {
            $message->to($target, $_SESSION['from'])->subject($_SESSION['subject']);
        });
        $this->rotate();
        //return redirect('smtp?message=Sent To '.$target.' using Sender '.$_SESSION['sender'].'&code='.$_SESSION['from'].'-'.$_SESSION['subject'].'-'.$_SESSION['sender'].'-'.$target.'-'.date("h:i:sa"));
        return redirect('smtp?message=Sent To '.$target.' using Sender '.$sender.
        '&code='.$_SESSION['from'].'-'.$_SESSION['subject'].'-'.$sender.'-'.$target.'-'.date("h:i:sa"));
        //return response()->json('smtp?message='.$_SESSION['from'].'-'.$_SESSION['subject'].'-'.$_SESSION['sender'].'-'.$target);
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
        if ($_SESSION['rotation_counter'] >= $_SESSION['rotation_value']) {
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
