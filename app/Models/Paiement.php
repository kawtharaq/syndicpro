<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = ['charge_id', 'occupant_id', 'date_paiement', 'montant', 'mode'];

    protected $casts = ['date_paiement' => 'date'];

    public function charge()
    {
        return $this->belongsTo(Charge::class);
    }

    public function occupant()
    {
        return $this->belongsTo(Occupant::class);
    }
}
