<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $party;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user , $party)
    {
        $this->user = $user;
        $this->party = $party;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->user->email)->view('invite');
    }
}
