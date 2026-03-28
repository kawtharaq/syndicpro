@extends('layouts.app')

@section('title', 'Détail charge')
@section('breadcrumb', 'Accueil / Charges / Détail')

@section('content')

<h2>
    Charge — Appart. {{ $charge->appartement->numero }}
</h2>

<p>
    {{ $charge->appartement->immeuble->nom }} •
    {{ $charge->mois->format('F Y') }}
</p>

@if($charge->statut === 'payée')
    <p>Statut : Payée</p>
@elseif($charge->statut === 'en retard')
    <p>Statut : En retard</p>
@else
    <p>Statut : Impayée</p>
@endif

<a href="{{ route('charges.edit', $charge) }}">Modifier</a>

@if($charge->statut !== 'payée')
    <a href="{{ route('paiements.create') }}?charge_id={{ $charge->id }}">
        Enregistrer paiement
    </a>
@endif

<hr>

<h3>Résumé</h3>

<p>Montant total : {{ number_format($charge->montant, 2) }} MAD</p>
<p>Montant payé : {{ number_format($charge->paiements->sum('montant'), 2) }} MAD</p>
<p>
    Reste à payer :
    {{ number_format($charge->montant - $charge->paiements->sum('montant'), 2) }} MAD
</p>

<hr>

<h3>Paiements enregistrés</h3>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>Occupant</th>
            <th>Date</th>
            <th>Montant</th>
            <th>Mode</th>
        </tr>
    </thead>

    <tbody>
        @forelse($charge->paiements as $paiement)
        <tr>
            <td>{{ $paiement->occupant->nom }}</td>
            <td>{{ $paiement->date_paiement->format('d/m/Y') }}</td>
            <td>{{ number_format($paiement->montant, 2) }} MAD</td>
            <td>{{ $paiement->mode ?? '—' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4">Aucun paiement enregistré</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection