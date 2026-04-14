<?php

namespace App\Mail;

use App\Models\Occupant;
use App\Models\Charge;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RelanceImpaye extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Occupant $occupant,
        public Charge   $charge
    ) {}

    public function build()
    {
        return $this->subject('Rappel de paiement — SyndicPro')
                    ->view('emails.relance');
    }
}