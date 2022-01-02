<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendCredentialsEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $LeaderName;
    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($LeaderName,$email)
    {
        $this->LeaderName=$LeaderName;
        $this->email=$email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from_email='info@puriurbanruralcoop.com';
        return $this->from($from_email)
            ->subject('Cloud Travel - Login Details')
            ->view('emails.login-credentials');
    }
}
