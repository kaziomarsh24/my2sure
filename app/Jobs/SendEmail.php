<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Mail;
use App\Mail\GlobalMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to;
    protected $subject;
    protected $message;

    public function __construct($to, $subject, $message)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
    }

    public function handle()
    {
        // Send the email using the GlobalMail Mailable class
        Mail::to($this->to)->send(new GlobalMail($this->subject, $this->message));
    }
}

