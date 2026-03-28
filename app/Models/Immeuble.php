<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Immeuble extends Model
{
    protected $fillable = ['nom', 'adresse', 'nb_etages', 'nb_appartements'];

    public function appartements()
    {
        return $this->hasMany(Appartement::class);
    }

    public function depenses()
    {
        return $this->hasMany(Depense::class);
    }
}
