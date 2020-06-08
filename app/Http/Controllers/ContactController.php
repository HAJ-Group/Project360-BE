<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\ContactEmail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller {

    function contact(Request $request) {
        
        $this->validate($request, [
            'subject' => 'required|min:5',
            'comment' => 'required|min:10|max:70',
            'email' => 'required|email|max:100'
        ]);

        $_SESSION['subject'] = $request->subject;
        $_SESSION['comment'] = $request->comment;
        $_SESSION['email'] = $request->email;
        Mail::to(env('MAIL_USERNAME'))->send(new ContactEmail());
        return response()->json('Message Sended');
        


    }

    

}