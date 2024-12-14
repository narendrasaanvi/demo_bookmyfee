<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TournamentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tournament;

    public function __construct($tournament)
    {
        $this->tournament = $tournament;
    }

    public function build()
    {
        return $this->subject('Please Check New Tournamnet Details')
                    ->view('emails.tournament');
    }
}
