<?php

namespace App\Http\Controllers;

use App\Models\Occupant;
use App\Models\Appartement;
use Illuminate\Http\Request;

class OccupantController extends Controller
{
    public function index(Request $request)
    {
        $query = Occupant::with('appartement.immeuble');

        if ($request->type) {
            $query->where('type', $request->type);
        }
        if ($request->search) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        $occupants = $query->latest()->paginate(10);
        return view('occupants.index', compact('occupants'));
    }

    public function create(Request $request)
    {
        $appartements = Appartement::where('statut', 'vacant')
                                    ->with('immeuble')
                                    ->get();
        $selectedAppartement = $request->appartement_id;
        return view('occupants.create', compact('appartements', 'selectedAppartement'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'appartement_id' => 'required|exists:appartements,id',
            'nom'            => 'required|string|max:100',
            'telephone'      => 'nullable|string|min:8|max:15',
            'email'          => 'nullable|email|max:150',
            'type'           => 'required|in:propriétaire,locataire',
            'date_entree'    => 'nullable|date',
        ]);


        Occupant::create($request->all());

        
        $appartement = Appartement::find($request->appartement_id);
        $appartement->update(['statut' => 'occupé']);

        return redirect()->route('occupants.index')
                         ->with('success', 'Occupant ajouté avec succès !');
    }

    public function show(Occupant $occupant)
    {
        $occupant->load('appartement.immeuble', 'paiements.charge');
        return view('occupants.show', compact('occupant'));
    }

    public function edit(Occupant $occupant)
    {
        $appartements = Appartement::with('immeuble')
                                    ->where(function($q) use ($occupant) {
                                        $q->where('statut', 'vacant')
                                          ->orWhere('id', $occupant->appartement_id);
                                    })->get();
        return view('occupants.edit', compact('occupant', 'appartements'));
    }

    public function update(Request $request, Occupant $occupant)
    {
        $request->validate([
            'appartement_id' => 'required|exists:appartements,id',
            'nom'            => 'required|string|max:100',
            'telephone'      => 'nullable|string|min:8|max:15',
            'email'          => 'nullable|email|max:150',
            'type'           => 'required|in:propriétaire,locataire',
            'date_entree'    => 'nullable|date',
        ]);

        
        if ($occupant->appartement_id != $request->appartement_id) {
            
            Appartement::find($occupant->appartement_id)
                        ->update(['statut' => 'vacant']);
           
            Appartement::find($request->appartement_id)
                        ->update(['statut' => 'occupé']);
        }

        $occupant->update($request->all());

        return redirect()->route('occupants.index')
                         ->with('success', 'Occupant modifié avec succès !');
    }

    public function destroy(Occupant $occupant)
    {
        $occupant->appartement->update(['statut' => 'vacant']);
        $occupant->delete();

        return redirect()->route('occupants.index')
                         ->with('success', 'Occupant supprimé, appartement libéré !');
    }
}