@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Accueil / Dashboard')

@section('content')

   <h2>Statistiques</h2>

<ul>
    <li>Immeubles : {{ $totalImmeubles }}</li>
    <li>Appartements occupés : {{ $totalOccupes }} / {{ $totalAppartements }}</li>
    <li>Charges ce mois : {{ number_format($totalCharges, 2) }} MAD</li>
    <li>Paiements encaissés : {{ number_format($totalPaiements, 2) }} MAD</li>
    <li>Impayés ce mois : {{ number_format($totalImpayes, 2) }} MAD</li>
    <li>Dépenses ce mois : {{ number_format($totalDepenses, 2) }} MAD</li>
    <li>Solde disponible : {{ number_format($solde, 2) }} MAD</li>
</ul>
    <h3>Derniers paiements</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Occupant</th>
            <th>Appartement</th>
            <th>Montant</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse($derniersPaiements as $p)
        <tr>
            <td>{{ $p->occupant->nom ?? '—' }}</td>
            <td>{{ $p->charge->appartement->numero ?? '—' }}</td>
            <td>{{ number_format($p->montant, 2) }} MAD</td>
            <td>{{ $p->date_paiement->format('d/m/Y') }}</td>
        </tr>
         @empty
        <tr>
            <td colspan="4">Aucun paiement ce mois</td>
        </tr>
        @endforelse
    </tbody>
</table>
<hr>

<h3>Impayés en retard</h3>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Appartement</th>
            <th>Mois</th>
            <th>Montant</th>
        </tr>
    </thead>
    <tbody>
        @forelse($occupantsEnRetard as $c)
        <tr>
            <td>{{ $c->appartement->numero ?? '—' }}</td>
            <td>{{ $c->mois->format('m/Y') }}</td>
            <td>{{ number_format($c->montant, 2) }} MAD</td>
        </tr>
        @empty
        <tr>
            <td colspan="3">Aucun retard</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection