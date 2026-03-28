<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Immeuble;
use App\Models\Appartement;
use App\Models\Occupant;
use App\Models\Charge;
use App\Models\Paiement;
use App\Models\Depense;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
      
        User::create([
            'name'     => 'Admin SyndicPro',
            'email'    => 'admin@syndicpro.ma',
            'password' => bcrypt('password'),
        ]);

        
        $imm1 = Immeuble::create([
            'nom'              => 'Résidence Al Amal',
            'adresse'          => '12 Rue Hassan II, Oujda',
            'nb_etages'        => 4,
            'nb_appartements'  => 8,
        ]);

        $imm2 = Immeuble::create([
            'nom'             => 'Résidence Nour',
            'adresse'         => '5 Avenue Mohammed V, Oujda',
            'nb_etages'       => 3,
            'nb_appartements' => 6,
        ]);

       
        $apparts = [];
        foreach (['A1','A2','B1','B2'] as $num) {
            $apparts[] = Appartement::create([
                'immeuble_id' => $imm1->id,
                'numero'      => $num,
                'etage'       => rand(1, 4),
                'superficie'  => rand(60, 120),
                'statut'      => 'occupé',
            ]);
        }

    
        $noms = ['Mohammed Alami', 'Fatima Benali', 'Youssef Idrissi', 'Aicha Karimi'];
        foreach ($apparts as $i => $appart) {
            $occ = Occupant::create([
                'appartement_id' => $appart->id,
                'nom'            => $noms[$i],
                'telephone'      => '066' . rand(1000000, 9999999),
                'email'          => strtolower(explode(' ', $noms[$i])[0]) . '@email.com',
                'type'           => $i % 2 === 0 ? 'propriétaire' : 'locataire',
                'date_entree'    => Carbon::now()->subMonths(rand(1, 12)),
            ]);

        
            $charge = Charge::create([
                'appartement_id' => $appart->id,
                'mois'           => Carbon::now()->startOfMonth(),
                'montant'        => 300,
                'description'    => 'Charges communes',
                'statut'         => $i < 2 ? 'payée' : 'impayée',
            ]);

        
            if ($i < 2) {
                Paiement::create([
                    'charge_id'     => $charge->id,
                    'occupant_id'   => $occ->id,
                    'date_paiement' => Carbon::now()->subDays(rand(1, 10)),
                    'montant'       => 300,
                    'mode'          => ['espèces', 'virement', 'chèque'][rand(0, 2)],
                ]);
            }
        }

       
        Depense::create([
            'immeuble_id' => $imm1->id,
            'date'        => Carbon::now()->subDays(5),
            'montant'     => 500,
            'categorie'   => 'nettoyage',
            'description' => 'Nettoyage parties communes',
        ]);
        Depense::create([
            'immeuble_id' => $imm1->id,
            'date'        => Carbon::now()->subDays(10),
            'montant'     => 1200,
            'categorie'   => 'réparation',
            'description' => 'Réparation ascenseur',
        ]);
    }
}