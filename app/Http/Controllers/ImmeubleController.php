<?php

namespace App\Http\Controllers;

use App\Models\Immeuble;
use Illuminate\Http\Request;

class ImmeubleController extends Controller
{
    public function index(Request $request)
{
    $villes        = Immeuble::villes();
    $tousImmeubles = Immeuble::withCount('appartements')->get();
    $query         = Immeuble::withCount('appartements');

    if ($request->ville) {
        $query->where('ville', $request->ville);
    }
    if ($request->nom_search) {
        $query->where('id', $request->nom_search);
    }

    $immeubles = $query->latest()->paginate(10);

    return view('immeubles.index', compact(
        'immeubles', 'villes', 'tousImmeubles'
    ));
}

    public function create()
    {
        $villes = Immeuble::villes();
        return view('immeubles.create', compact('villes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'             => 'required|string|max:150',
            'adresse'         => 'required|string',
            'ville'           => 'required|string|max:100',
            'nb_etages'       => 'nullable|integer|min:0',
            'nb_appartements' => 'nullable|integer|min:0',
        ]);

        Immeuble::create($request->all());

        return redirect()->route('immeubles.index')
                         ->with('success', 'Immeuble ajouté avec succès !');
    }

    public function show(Immeuble $immeuble)
    {
        $appartements = $immeuble->appartements()->with('occupants')->get();
        return view('immeubles.show', compact('immeuble', 'appartements'));
    }

    public function edit(Immeuble $immeuble)
    {
        $villes = Immeuble::villes();
        return view('immeubles.edit', compact('immeuble', 'villes'));
    }

    public function update(Request $request, Immeuble $immeuble)
    {
        $request->validate([
            'nom'             => 'required|string|max:150',
            'adresse'         => 'required|string',
            'ville'           => 'required|string|max:100',
            'nb_etages'       => 'nullable|integer|min:0',
            'nb_appartements' => 'nullable|integer|min:0',
        ]);

        $immeuble->update($request->all());

        return redirect()->route('immeubles.index')
                         ->with('success', 'Immeuble modifié avec succès !');
    }

    public function destroy(Immeuble $immeuble)
    {
        $immeuble->delete();
        return redirect()->route('immeubles.index')
                         ->with('success', 'Immeuble supprimé avec succès !');
    }
}