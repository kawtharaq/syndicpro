<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    protected $fillable = ['appartement_id', 'mois', 'montant', 'description', 'statut'];

    protected $casts = ['mois' => 'date'];

    public function appartement()
    {
        return $this->belongsTo(Appartement::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}
