<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Occupant extends Model
{
    protected $fillable = ['appartement_id', 'nom', 'telephone', 'email', 'type', 'date_entree'];

    protected $casts = ['date_entree' => 'date'];

    public function appartement()
    {
        return $this->belongsTo(Appartement::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}