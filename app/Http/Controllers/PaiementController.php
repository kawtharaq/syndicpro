<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Charge;
use App\Models\Occupant;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaiementController extends Controller
{
    public function index(Request $request)
    {
        $query = Paiement::with('charge.appartement.immeuble', 'occupant');

        if ($request->mois) {
            $query->whereYear('date_paiement', Carbon::parse($request->mois)->year)
                  ->whereMonth('date_paiement', Carbon::parse($request->mois)->month);
        }
        if ($request->search) {
            $query->whereHas('occupant', function($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->search . '%');
            });
        }

        $paiements     = $query->latest()->paginate(15);
        $totalEncaisse = $query->sum('montant');

        return view('paiements.index', compact('paiements', 'totalEncaisse'));
    }

    public function create(Request $request)
    {
        $charges = Charge::with('appartement.immeuble')
                          ->whereIn('statut', ['impayée', 'en retard'])
                          ->get();

        $occupants       = Occupant::with('appartement')->get();
        $selectedCharge  = $request->charge_id;

        $occupantCharge = null;
        if ($selectedCharge) {
            $charge = Charge::with('appartement.occupants')->find($selectedCharge);
            $occupantCharge = $charge?->appartement?->occupants?->first();
        }

        return view('paiements.create', compact(
            'charges', 'occupants', 'selectedCharge', 'occupantCharge'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'charge_id'      => 'required|exists:charges,id',
            'occupant_id'    => 'required|exists:occupants,id',
            'date_paiement'  => 'required|date',
            'montant'        => 'required|numeric|min:0.01',
            'mode'           => 'nullable|in:espèces,virement,chèque',
        ]);

        $charge = Charge::find($request->charge_id);

        $dejaPaye  = $charge->paiements()->sum('montant');
        $resteDu   = $charge->montant - $dejaPaye;

        if ($request->montant > $resteDu) {
            return back()->withErrors([
                'montant' => "Le montant saisi ({$request->montant} MAD) dépasse le reste dû ({$resteDu} MAD)."
            ])->withInput();
        }


        Paiement::create($request->all());

        $totalPaye = $charge->paiements()->sum('montant') + $request->montant;
        if ($totalPaye >= $charge->montant) {
            $charge->update(['statut' => 'payée']);
        }

        return redirect()->route('paiements.index')
                         ->with('success', 'Paiement enregistré avec succès !');
    }

    public function show(Paiement $paiement)
    {
        $paiement->load('charge.appartement.immeuble', 'occupant');
        return view('paiements.show', compact('paiement'));
    }

    public function edit(Paiement $paiement)
    {
        $charges   = Charge::with('appartement.immeuble')->get();
        $occupants = Occupant::with('appartement')->get();
        return view('paiements.edit', compact('paiement', 'charges', 'occupants'));
    }

    public function update(Request $request, Paiement $paiement)
    {
        $request->validate([
            'charge_id'     => 'required|exists:charges,id',
            'occupant_id'   => 'required|exists:occupants,id',
            'date_paiement' => 'required|date',
            'montant'       => 'required|numeric|min:0.01',
            'mode'          => 'nullable|in:espèces,virement,chèque',
        ]);

        $paiement->update($request->all());

        $charge    = Charge::find($request->charge_id);
        $totalPaye = $charge->paiements()->sum('montant');
        $statut    = $totalPaye >= $charge->montant ? 'payée' : 'impayée';
        $charge->update(['statut' => $statut]);

        return redirect()->route('paiements.index')
                         ->with('success', 'Paiement modifié avec succès !');
    }

    public function destroy(Paiement $paiement)
    {
        $charge = $paiement->charge;
        $paiement->delete();

        $totalPaye = $charge->paiements()->sum('montant');
        if ($totalPaye < $charge->montant) {
            $charge->update(['statut' => 'impayée']);
        }

        return redirect()->route('paiements.index')
                         ->with('success', 'Paiement supprimé avec succès !');
    }
}