<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use App\Models\Immeuble;
use Illuminate\Http\Request;

class AppartementController extends Controller
{
    public function index(Request $request)
    {
        $villes    = Immeuble::villes();
        $immeubles = Immeuble::all();
        $query     = Appartement::with('immeuble', 'occupants');

        // Filtre par ville
        if ($request->ville) {
            $query->whereHas('immeuble', function($q) use ($request) {
                $q->where('ville', $request->ville);
            });
        }

        // Filtre par immeuble
        if ($request->immeuble_id) {
            $query->where('immeuble_id', $request->immeuble_id);
        }

        // Filtre par etage
        if ($request->etage !== null && $request->etage !== '') {
            $query->where('etage', $request->etage);
        }

        // Filtre par statut
        if ($request->statut) {
            $query->where('statut', $request->statut);
        }

        // Filtre par paiement
        if ($request->charges_payees !== null && $request->charges_payees !== '') {
            $query->where('charges_payees', $request->charges_payees);
        }

        $appartements = $query->latest()->paginate(10);
        $etages       = Appartement::distinct()->pluck('etage')->filter()->sort()->values();

        return view('appartements.index', compact(
            'appartements', 'immeubles', 'villes', 'etages'
        ));
    }

    public function create(Request $request)
    {
        $immeubles          = Immeuble::all();
        $selectedImmeuble   = $request->immeuble_id;
        return view('appartements.create', compact('immeubles', 'selectedImmeuble'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'immeuble_id'   => 'required|exists:immeubles,id',
            'numero'        => 'required|string|max:10',
            'etage'         => 'nullable|integer',
            'superficie'    => 'nullable|numeric|min:0',
            'description'   => 'nullable|string',
            'prix_charge'   => 'nullable|numeric|min:0',
            'charges_payees'=> 'nullable|boolean',
            'statut'        => 'required|in:occupé,vacant',
        ]);

        Appartement::create($request->merge([
            'charges_payees' => $request->has('charges_payees') ? 1 : 0
        ])->all());

        return redirect()->route('appartements.index')
                         ->with('success', 'Appartement ajouté avec succès !');
    }

    public function show(Appartement $appartement)
    {
        $appartement->load('immeuble', 'occupants', 'charges.paiements');
        return view('appartements.show', compact('appartement'));
    }

    public function edit(Appartement $appartement)
    {
        $immeubles = Immeuble::all();
        return view('appartements.edit', compact('appartement', 'immeubles'));
    }

    public function update(Request $request, Appartement $appartement)
    {
        $request->validate([
            'immeuble_id'    => 'required|exists:immeubles,id',
            'numero'         => 'required|string|max:10',
            'etage'          => 'nullable|integer',
            'superficie'     => 'nullable|numeric|min:0',
            'description'    => 'nullable|string',
            'prix_charge'    => 'nullable|numeric|min:0',
            'charges_payees' => 'nullable|boolean',
            'statut'         => 'required|in:occupé,vacant',
        ]);

        $appartement->update($request->merge([
            'charges_payees' => $request->has('charges_payees') ? 1 : 0
        ])->all());

        return redirect()->route('appartements.index')
                         ->with('success', 'Appartement modifié avec succès !');
    }

    public function destroy(Appartement $appartement)
    {
        if ($appartement->occupants()->count() > 0) {
            return redirect()->route('appartements.index')
                             ->with('error', 'Impossible : appartement a un occupant actif !');
        }
        $appartement->delete();
        return redirect()->route('appartements.index')
                         ->with('success', 'Appartement supprimé avec succès !');
    }
}