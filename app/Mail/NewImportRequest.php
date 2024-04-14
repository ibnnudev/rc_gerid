<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewImportRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    public $file_code;

    public function __construct($user, $file_code)
    {
        $this->user = $user;
        $this->file_code = $file_code;
    }

    /**
     * Build the message.
     */
    public function build(): Mailable
    {
        return $this
            ->from('rc_gerid@gmail.com')
            ->to($this->user->email)
            ->subject('Permintaan Import Baru')
            ->view('mail.new-import-request');
    }
}
