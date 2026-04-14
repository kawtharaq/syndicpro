<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appartement extends Model
{
    protected $fillable = ['immeuble_id', 'numero', 'etage', 'superficie', 'statut'];

    public function immeuble()
    {
        return $this->belongsTo(Immeuble::class);
    }

    public function occupants()
    {
        return $this->hasMany(Occupant::class);
    }

    public function charges()
    {
        return $this->hasMany(Charge::class);
    }
}