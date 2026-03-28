<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\Immeuble;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DepenseController extends Controller
{
    public function index(Request $request)
    {
        $immeubles = Immeuble::all();
        $query     = Depense::with('immeuble');

        if ($request->mois) {
            $query->whereYear('date', Carbon::parse($request->mois)->year)
                  ->whereMonth('date', Carbon::parse($request->mois)->month);
        }
        if ($request->immeuble_id) {
            $query->where('immeuble_id', $request->immeuble_id);
        }
        if ($request->categorie) {
            $query->where('categorie', $request->categorie);
        }

        $depenses      = $query->latest('date')->paginate(15);
        $totalDepenses = $query->sum('montant');

        // Total par catégorie
        $parCategorie = Depense::selectRaw('categorie, SUM(montant) as total')
                                ->when($request->mois, function($q) use ($request) {
                                    $q->whereYear('date', Carbon::parse($request->mois)->year)
                                      ->whereMonth('date', Carbon::parse($request->mois)->month);
                                })
                                ->groupBy('categorie')
                                ->get();

        return view('depenses.index', compact(
            'depenses', 'immeubles', 'totalDepenses', 'parCategorie'
        ));
    }

    public function create()
    {
        $immeubles  = Immeuble::all();
        $categories = ['nettoyage', 'réparation', 'gardien', 'électricité', 'autre'];
        return view('depenses.create', compact('immeubles', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'immeuble_id' => 'required|exists:immeubles,id',
            'date'        => 'required|date',
            'montant'     => 'required|numeric|min:0.01',
            'categorie'   => 'required|in:nettoyage,réparation,gardien,électricité,autre',
            'description' => 'nullable|string',
        ]);

        Depense::create($request->all());

        return redirect()->route('depenses.index')
                         ->with('success', 'Dépense ajoutée avec succès !');
    }

    public function show(Depense $depense)
    {
        return view('depenses.show', compact('depense'));
    }

    public function edit(Depense $depense)
    {
        $immeubles  = Immeuble::all();
        $categories = ['nettoyage', 'réparation', 'gardien', 'électricité', 'autre'];
        return view('depenses.edit', compact('depense', 'immeubles', 'categories'));
    }

    public function update(Request $request, Depense $depense)
    {
        $request->validate([
            'immeuble_id' => 'required|exists:immeubles,id',
            'date'        => 'required|date',
            'montant'     => 'required|numeric|min:0.01',
            'categorie'   => 'required|in:nettoyage,réparation,gardien,électricité,autre',
            'description' => 'nullable|string',
        ]);

        $depense->update($request->all());

        return redirect()->route('depenses.index')
                         ->with('success', 'Dépense modifiée avec succès !');
    }

    public function destroy(Depense $depense)
    {
        $depense->delete();
        return redirect()->route('depenses.index')
                         ->with('success', 'Dépense supprimée avec succès !');
    }
}