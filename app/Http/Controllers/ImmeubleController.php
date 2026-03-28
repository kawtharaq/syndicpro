<?php

namespace App\Http\Controllers;

use App\Models\Immeuble;
use Illuminate\Http\Request;

class ImmeubleController extends Controller
{
    public function index()
    {
        $immeubles = Immeuble::withCount('appartements')->latest()->paginate(10);
        return view('immeubles.index', compact('immeubles'));
    }

    public function create()
    {
        return view('immeubles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'     => 'required|string|max:150',
            'adresse' => 'required|string',
            'nb_etages'        => 'nullable|integer|min:0',
            'nb_appartements'  => 'nullable|integer|min:0',
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
        return view('immeubles.edit', compact('immeuble'));
    }

    public function update(Request $request, Immeuble $immeuble)
    {
        $request->validate([
            'nom'     => 'required|string|max:150',
            'adresse' => 'required|string',
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