@extends('layouts.app')
@section('title', 'Détail dépense')
@section('breadcrumb', 'Accueil / Dépenses / Détail')

@section('content')

<h3>Détail de la dépense</h3>
<p>Ajoutée le {{ $depense->created_at->format('d/m/Y') }}</p>

<a href="{{ route('depenses.edit', $depense) }}">Modifier</a>

<hr>

<p><strong>Immeuble :</strong> {{ $depense->immeuble->nom }}</p>

<p><strong>Date :</strong> {{ $depense->date->format('d/m/Y') }}</p>

<p><strong>Catégorie :</strong> {{ ucfirst($depense->categorie) }}</p>

<p><strong>Description :</strong> {{ $depense->description ?? '—' }}</p>

<p>
    <strong>Montant :</strong>
    {{ number_format($depense->montant, 2) }} MAD
</p>

<hr>

<a href="{{ route('depenses.index') }}">← Retour à la liste</a>

<form action="{{ route('depenses.destroy', $depense) }}" method="POST"
      onsubmit="return confirm('Supprimer cette dépense ?')">
    @csrf
    @method('DELETE')

    <button type="submit">Supprimer</button>
</form>

@endsection