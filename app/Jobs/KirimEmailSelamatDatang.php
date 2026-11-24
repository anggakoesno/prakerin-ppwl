<?php

namespace App\Jobs;

use App\Mail\SelamatDatangMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class KirimEmailSelamatDatang implements ShouldQueue
{
    use Queueable;

    public $tries = 3;

    public function __construct(public User $user) {}

    public function handle(): void
    {
        Mail::to($this->user->email)->send(new SelamatDatangMail($this->user));
    }
}
