<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {

//        $this->nama = $nama;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('admin@better.com')
            ->view('emailtest')
            ->subject('Reset Password')
            ->with(
                [
                    'nama' => 'Reset Password Better Ping Account',
                    'token' => $this->token,
                    'link' => "www.facebook.com"
                ]);


//        return $this->view('view.name');
    }
}
