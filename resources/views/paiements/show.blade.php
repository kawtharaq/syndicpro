@extends('layouts.app')
@section('title', 'Détail paiement')
@section('breadcrumb', 'Accueil / Paiements / Détail')

@section('content')

<h3>Reçu de paiement</h3>

<p>Enregistré le {{ $paiement->created_at->format('d/m/Y à H:i') }}</p>

<a href="{{ route('paiements.edit', $paiement) }}">Modifier</a>

<hr>

<p><strong>Occupant :</strong> {{ $paiement->occupant->nom }}</p>

<p>
    <strong>Appartement :</strong>
    {{ $paiement->charge->appartement->numero }} —
    {{ $paiement->charge->appartement->immeuble->nom }}
</p>

<p>
    <strong>Mois de la charge :</strong>
    {{ $paiement->charge->mois->format('F Y') }}
</p>

<p>
    <strong>Date de paiement :</strong>
    {{ $paiement->date_paiement->format('d/m/Y') }}
</p>

<p>
    <strong>Mode :</strong>
    {{ ucfirst($paiement->mode ?? '—') }}
</p>

<h3>
    Montant payé :
    {{ number_format($paiement->montant, 2) }} MAD
</h3>

<hr>

<a href="{{ route('paiements.index') }}">← Retour à la liste</a>

@endsection