<?php

namespace App\Http\Controllers;

use App\Models\Immeuble;
use App\Models\Charge;
use App\Models\Paiement;
use App\Models\Depense;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class RapportController extends Controller
{
    public function index()
    {
        $immeubles = Immeuble::all();
        return view('rapports.index', compact('immeubles'));
    }

    public function exportPdf(Request $request)
    {
        $request->validate([
            'mois'        => 'required|date',
            'immeuble_id' => 'required|exists:immeubles,id',
        ]);

        $mois      = Carbon::parse($request->mois);
        $immeuble  = Immeuble::with('appartements.occupants')->find($request->immeuble_id);

        $charges = Charge::with('appartement', 'paiements.occupant')
                          ->whereHas('appartement', function($q) use ($immeuble) {
                              $q->where('immeuble_id', $immeuble->id);
                          })
                          ->whereYear('mois', $mois->year)
                          ->whereMonth('mois', $mois->month)
                          ->get();

        $paiements = Paiement::with('occupant', 'charge.appartement')
                              ->whereHas('charge.appartement', function($q) use ($immeuble) {
                                  $q->where('immeuble_id', $immeuble->id);
                              })
                              ->whereYear('date_paiement', $mois->year)
                              ->whereMonth('date_paiement', $mois->month)
                              ->get();

        $depenses = Depense::where('immeuble_id', $immeuble->id)
                            ->whereYear('date', $mois->year)
                            ->whereMonth('date', $mois->month)
                            ->get();

        $totalCharges   = $charges->sum('montant');
        $totalPaiements = $paiements->sum('montant');
        $totalImpayes   = $charges->where('statut', '!=', 'payée')->sum('montant');
        $totalDepenses  = $depenses->sum('montant');
        $soldeNet       = $totalPaiements - $totalDepenses;

        $pdf = Pdf::loadView('rapports.pdf', compact(
            'immeuble', 'mois', 'charges', 'paiements',
            'depenses', 'totalCharges', 'totalPaiements',
            'totalImpayes', 'totalDepenses', 'soldeNet'
        ));

        $pdf->setPaper('A4', 'portrait');

        $filename = 'rapport_' . $immeuble->nom . '_' . $mois->format('m-Y') . '.pdf';
        return $pdf->download($filename);
    }
}