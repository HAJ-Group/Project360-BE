<?php


namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JokesEveryday extends Mailable
{
    use Queueable, SerializesModels;

    //build the message.
    public function build() {
        return $this->view('mailTemplate');
    }

}
