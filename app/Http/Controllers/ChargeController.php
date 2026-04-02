<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\Appartement;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ChargeController extends Controller
{
    public function index(Request $request)
    {
        $query = Charge::with('appartement.immeuble');

        if ($request->mois) {
            $query->whereYear('mois', Carbon::parse($request->mois)->year)
                  ->whereMonth('mois', Carbon::parse($request->mois)->month);
        }
        if ($request->statut) {
            $query->where('statut', $request->statut);
        }

        $charges = $query->latest()->paginate(15);

        // Totaux
        $totalCharges  = $query->sum('montant');
        $totalPayees   = (clone $query)->where('statut', 'payée')->sum('montant');
        $totalImpayes  = (clone $query)->where('statut', '!=', 'payée')->sum('montant');

        return view('charges.index', compact('charges', 'totalCharges', 'totalPayees', 'totalImpayes'));
    }

    public function create()
    {
        $appartements = Appartement::with('immeuble')->where('statut', 'occupé')->get();
        return view('charges.create', compact('appartements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'appartement_id' => 'required|exists:appartements,id',
            'mois'           => 'required|date',
            'montant'        => 'required|numeric|min:0',
            'description'    => 'nullable|string|max:255',
            'statut'         => 'required|in:payée,impayée,en retard',
        ]);

        Charge::create($request->all());

        return redirect()->route('charges.index')
                         ->with('success', 'Charge ajoutée avec succès !');
    }

    public function show(Charge $charge)
    {
        $charge->load('appartement.immeuble', 'paiements.occupant');
        return view('charges.show', compact('charge'));
    }

    public function edit(Charge $charge)
    {
        $appartements = Appartement::with('immeuble')->get();
        return view('charges.edit', compact('charge', 'appartements'));
    }

    public function update(Request $request, Charge $charge)
    {
        $request->validate([
            'appartement_id' => 'required|exists:appartements,id',
            'mois'           => 'required|date',
            'montant'        => 'required|numeric|min:0',
            'description'    => 'nullable|string|max:255',
            'statut'         => 'required|in:payée,impayée,en retard',
        ]);

        $charge->update($request->all());

        return redirect()->route('charges.index')
                         ->with('success', 'Charge modifiée avec succès !');
    }

    public function destroy(Charge $charge)
    {
        $charge->delete();
        return redirect()->route('charges.index')
                         ->with('success', 'Charge supprimée avec succès !');
    }

    public function generer(Request $request)
{
    $request->validate([
        'mois'    => 'required|date',
        'montant' => 'nullable|numeric|min:0',
    ]);

    $mois         = Carbon::parse($request->mois)->startOfMonth();
    $appartements = Appartement::where('statut', 'occupé')->get();
    $count        = 0;

    foreach ($appartements as $appart) {
        $existe = Charge::where('appartement_id', $appart->id)
                        ->whereYear('mois', $mois->year)
                        ->whereMonth('mois', $mois->month)
                        ->exists();

        if (!$existe) {
            // ✅ Automatique: prix_charge dial appart, sinon montant saisi
            $montant = $appart->prix_charge ?? $request->montant ?? 0;

            Charge::create([
                'appartement_id' => $appart->id,
                'mois'           => $mois,
                'montant'        => $montant,
                'description'    => $request->description ?? 'Charges communes',
                'statut'         => 'impayée',
            ]);
            $count++;
        }
    }

    return redirect()->route('charges.index')
                     ->with('success', "{$count} charges générées pour " . $mois->format('m/Y') . " !");
}

    public static function mettreAJourStatuts()
    {
        $limite = Carbon::now()->subMonth()->day(15);

        Charge::where('statut', 'impayée')
              ->where('mois', '<', $limite)
              ->update(['statut' => 'en retard']);
    }
}