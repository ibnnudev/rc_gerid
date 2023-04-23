<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusActivationImportRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $status;
    public $file_code;
    public $reason;
    public $user;

    public function __construct($status, $file_code, $reason, $user)
    {
        $this->status       = $status;
        $this->file_code    = $file_code;
        $this->reason       = $reason;
        $this->user         = $user;
    }

    public function build()
    {
        return $this
        ->to($this->user->email)
        ->from('rc_gerid@gmail.com')
        ->subject('Status Aktifasi Permintaan Import')
        ->view('mail.status-activation-import-request');
    }
}
