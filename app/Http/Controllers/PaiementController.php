<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Charge;
use App\Models\Occupant;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaiementController extends Controller
{
    public function index()
    {
        $paiements = Paiement::with('charge.appartement.immeuble', 'occupant')
            ->latest()
            ->paginate(15);

        $totalEncaisse = Paiement::sum('montant');

        return view('paiements.index', compact('paiements', 'totalEncaisse'));
    }

    public function create()
    {
        $charges = Charge::with('appartement.immeuble')
            ->where('statut', '!=', 'payée')
            ->get();

        $occupants = Occupant::with('appartement')->get();

        return view('paiements.create', compact('charges', 'occupants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'charge_id' => 'required|exists:charges,id',
            'occupant_id' => 'required|exists:occupants,id',
            'montant' => 'required|numeric|min:0.01',
            'date_paiement' => 'required|date',
            'mode' => 'nullable',
        ]);

        $paiement = Paiement::create($request->all());

        $this->updateChargeStatus($paiement->charge);

        return redirect()->route('paiements.index')
            ->with('success', 'Paiement ajouté avec succès');
    }

    public function update(Request $request, Paiement $paiement)
    {
        $paiement->update($request->all());

        $this->updateChargeStatus($paiement->charge);

        return redirect()->route('paiements.index')
            ->with('success', 'Paiement modifié');
    }

    public function show(Paiement $paiement)
    {
        $paiement->load('charge.appartement.immeuble', 'occupant');
        return view('paiements.show', compact('paiement'));
    }

    public function destroy(Paiement $paiement)
    {
        $charge = $paiement->charge;
        $paiement->delete();

        $this->updateChargeStatus($charge);

        return redirect()->route('paiements.index')
            ->with('success', 'Paiement supprimé');
    }

    private function updateChargeStatus($charge)
    {
        $total = $charge->paiements()->sum('montant');
        $days  = $charge->mois->diffInDays(now());

        if ($total >= $charge->montant) {
            $charge->update(['statut' => 'payée']);
            return;
        }

        if ($days >= 30) {
            $charge->update(['statut' => 'en retard']);
            return;
        }

        $charge->update(['statut' => 'impayée']);
    }
}