<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeactivateUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this
            ->from('rcgerid@mail.com')
            ->to($this->user->email)
            ->subject('Pengguna Berhasil Dinonaktifkan')
            ->view('mail.deactivate-user');
    }
}
