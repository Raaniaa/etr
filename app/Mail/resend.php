<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class resend extends Mailable
{
    use Queueable, SerializesModels;
    public $verifyUser;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($verifyUser)
    {
        $this->$verifyUser = $verifyUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('resend');
    }
}
