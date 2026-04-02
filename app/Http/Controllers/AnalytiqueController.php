<?php

namespace App\Http\Controllers;

use App\Models\Immeuble;
use App\Models\Appartement;
use App\Models\Charge;
use App\Models\Paiement;
use App\Models\Depense;
use Carbon\Carbon;

class AnalytiqueController extends Controller
{
    public function index()
    {
        // Stats par ville
        $parVille = Immeuble::selectRaw('ville, COUNT(*) as nb_immeubles')
                             ->whereNotNull('ville')
                             ->groupBy('ville')
                             ->get();

        // Taux occupation
        $totalApparts  = Appartement::count();
        $totalOccupes  = Appartement::where('statut', 'occupé')->count();
        $totalVacants  = Appartement::where('statut', 'vacant')->count();
        $tauxOccupation = $totalApparts > 0
                          ? round(($totalOccupes / $totalApparts) * 100, 1)
                          : 0;

        // Paiements par mois (6 derniers mois)
        $paiementsParMois = collect();
        for ($i = 5; $i >= 0; $i--) {
            $mois = Carbon::now()->subMonths($i);
            $total = Paiement::whereYear('date_paiement', $mois->year)
                              ->whereMonth('date_paiement', $mois->month)
                              ->sum('montant');
            $paiementsParMois->push([
                'mois'  => $mois->format('M Y'),
                'total' => $total,
            ]);
        }

        // Top impayés par immeuble
        $topImpayes = Immeuble::withCount(['appartements as nb_impayes' => function($q) {
                                    $q->whereHas('charges', function($q2) {
                                        $q2->where('statut', '!=', 'payée');
                                    });
                                }])
                               ->orderByDesc('nb_impayes')
                               ->take(5)
                               ->get();

        // Dépenses par catégorie
        $depensesParCategorie = Depense::selectRaw('categorie, SUM(montant) as total')
                                        ->groupBy('categorie')
                                        ->get();

        // Revenus vs Dépenses (6 derniers mois)
        $revenusVsDepenses = collect();
        for ($i = 5; $i >= 0; $i--) {
            $mois     = Carbon::now()->subMonths($i);
            $revenus  = Paiement::whereYear('date_paiement', $mois->year)
                                 ->whereMonth('date_paiement', $mois->month)
                                 ->sum('montant');
            $depenses = Depense::whereYear('date', $mois->year)
                                ->whereMonth('date', $mois->month)
                                ->sum('montant');
            $revenusVsDepenses->push([
                'mois'     => $mois->format('M Y'),
                'revenus'  => $revenus,
                'depenses' => $depenses,
                'solde'    => $revenus - $depenses,
            ]);
        }

        return view('analytique.index', compact(
            'parVille', 'totalApparts', 'totalOccupes', 'totalVacants',
            'tauxOccupation', 'paiementsParMois', 'topImpayes',
            'depensesParCategorie', 'revenusVsDepenses'
        ));
    }
}