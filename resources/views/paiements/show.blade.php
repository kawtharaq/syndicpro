@extends('layouts.app')
@section('title', 'Détail paiement')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 shadow rounded">

<h2>Détail paiement</h2>

<p>Occupant: {{ $paiement->occupant->nom }}</p>
<p>Appartement: {{ $paiement->charge->appartement->numero }}</p>
<p>Montant: {{ $paiement->montant }}</p>
<p>Date: {{ $paiement->date_paiement }}</p>

<a href="{{ route('paiements.index') }}">Retour</a>

</div>

@endsection