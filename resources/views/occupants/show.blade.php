@extends('layouts.app')

@section('title', $occupant->nom)
@section('breadcrumb', 'Accueil / Occupants / ' . $occupant->nom)

@section('content')

<h2>{{ $occupant->nom }}</h2>

@if($occupant->type === 'propriétaire')
    <p>Propriétaire</p>
@else
    <p>Locataire</p>
@endif

<a href="{{ route('occupants.edit', $occupant) }}">
    Modifier
</a>

<hr>

<h3>Informations</h3>

<p>Appartement : {{ $occupant->appartement->numero }}</p>
<p>Immeuble : {{ $occupant->appartement->immeuble->nom }}</p>
<p>Téléphone : {{ $occupant->telephone ?? '—' }}</p>
<p>Email : {{ $occupant->email ?? '—' }}</p>

<hr>

<h3>Historique des paiements</h3>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>Date</th>
            <th>Mois charge</th>
            <th>Montant</th>
            <th>Mode</th>
        </tr>
    </thead>

    <tbody>
        @forelse($occupant->paiements->sortByDesc('date_paiement') as $paiement)
            <tr>
                <td>{{ $paiement->date_paiement->format('d/m/Y') }}</td>
                <td>{{ $paiement->charge->mois->format('m/Y') }}</td>
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