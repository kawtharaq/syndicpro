<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    protected $fillable = ['immeuble_id', 'date', 'montant', 'categorie', 'description'];

    protected $casts = ['date' => 'date'];

    public function immeuble()
    {
        return $this->belongsTo(Immeuble::class);
    }
}
