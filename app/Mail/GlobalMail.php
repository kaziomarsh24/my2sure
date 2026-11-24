<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GlobalMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($to,$subject,$message)
    {
        //
        $this->general = [
            'to'        => $to,
            'subject'   => $subject,
            'message'   => $message,
        ];
    }


    public function build()
    {
        return $this->markdown('email.index')->subject($this->general['subject'])->with(['objData'=>$this->general]);
    }
}
