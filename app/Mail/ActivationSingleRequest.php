<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivationSingleRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    public $status;

    public function __construct($user, $status)
    {
        $this->user = $user;
        $this->status = $status;
    }

    public function build()
    {
        return $this
            ->from('rc_gerid@gmail.com')
            ->to($this->user->email)
            ->subject('Status Aktifasi Permintaan')
            ->view('mail.activation-single-request');
    }
}
