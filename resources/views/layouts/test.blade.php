<?php

namespace App\Http\Controllers;

use App\Models\Immeuble;
use App\Models\Appartement;
use App\Models\Charge;
use App\Models\Paiement;
use App\Models\Depense;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $moisActuel = Carbon::now()->startOfMonth();

        // Stats générales
        $totalImmeubles    = Immeuble::count();
        $totalAppartements = Appartement::count();
        $totalOccupes      = Appartement::where('statut', 'occupé')->count();
        $totalVacants      = Appartement::where('statut', 'vacant')->count();

        // Finances du mois
        $totalCharges    = Charge::whereYear('mois', now()->year)
                                  ->whereMonth('mois', now()->month)
                                  ->sum('montant');

        $totalPaiements  = Paiement::whereYear('date_paiement', now()->year)
                                    ->whereMonth('date_paiement', now()->month)
                                    ->sum('montant');

        $totalImpayes    = Charge::where('statut', '!=', 'payée')
                                  ->whereYear('mois', now()->year)
                                  ->whereMonth('mois', now()->month)
                                  ->sum('montant');

        $totalDepenses   = Depense::whereYear('date', now()->year)
                                   ->whereMonth('date', now()->month)
                                   ->sum('montant');

        $solde = $totalPaiements - $totalDepenses;

        // 5 derniers paiements
        $derniersPaiements = Paiement::with(['occupant', 'charge.appartement'])
                                      ->latest()
                                      ->take(5)
                                      ->get();

        // Occupants en retard
        $occupantsEnRetard = Charge::with(['appartement.occupants'])
                                    ->where('statut', 'en retard')
                                    ->get();

        return view('dashboard', compact(
            'totalImmeubles', 'totalAppartements', 'totalOccupes', 'totalVacants',
            'totalCharges', 'totalPaiements', 'totalImpayes', 'totalDepenses',
            'solde', 'derniersPaiements', 'occupantsEnRetard'
        ));
    }
}