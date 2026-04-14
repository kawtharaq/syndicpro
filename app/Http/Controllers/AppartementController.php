<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use App\Models\Immeuble;
use Illuminate\Http\Request;

class AppartementController extends Controller
{
    public function index(Request $request)
    {
        $immeubles = Immeuble::all();
        $query = Appartement::with('immeuble', 'occupants');

        if ($request->immeuble_id) {
            $query->where('immeuble_id', $request->immeuble_id);
        }
        if ($request->statut) {
            $query->where('statut', $request->statut);
        }

        $appartements = $query->latest()->paginate(10);
        return view('appartements.index', compact('appartements', 'immeubles'));
    }

    public function create(Request $request)
    {
        $immeubles = Immeuble::all();
        $selectedImmeuble = $request->immeuble_id;
        return view('appartements.create', compact('immeubles', 'selectedImmeuble'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'immeuble_id' => 'required|exists:immeubles,id',
            'numero'      => 'required|string|max:10',
            'etage'       => 'nullable|integer',
            'superficie'  => 'nullable|numeric|min:0',
            'statut'      => 'required|in:occupé,vacant',
        ]);

        Appartement::create($request->all());

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
            'immeuble_id' => 'required|exists:immeubles,id',
            'numero'      => 'required|string|max:10',
            'etage'       => 'nullable|integer',
            'superficie'  => 'nullable|numeric|min:0',
            'statut'      => 'required|in:occupé,vacant',
        ]);

        $appartement->update($request->all());

        return redirect()->route('appartements.index')
                         ->with('success', 'Appartement modifié avec succès !');
    }

    public function destroy(Appartement $appartement)
    {
        // Vérifier si appartement a un occupant actif
        if ($appartement->occupants()->count() > 0) {
            return redirect()->route('appartements.index')
                             ->with('error', 'Impossible de supprimer : cet appartement a un occupant actif !');
        }

        $appartement->delete();
        return redirect()->route('appartements.index')
                         ->with('success', 'Appartement supprimé avec succès !');
    }
}