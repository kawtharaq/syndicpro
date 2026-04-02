<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Immeuble extends Model
{
    protected $fillable = [
        'nom', 'adresse', 'ville', 'nb_etages', 'nb_appartements'
    ];

    public function appartements()
    {
        return $this->hasMany(Appartement::class);
    }

    public function depenses()
    {
        return $this->hasMany(Depense::class);
    }

    // Helper — liste des villes distinctes
    public static function villes()
    {
        return self::whereNotNull('ville')
                   ->distinct()
                   ->pluck('ville')
                   ->sort()
                   ->values();
    }
}