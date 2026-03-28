@extends('layouts.app')

@section('title', 'Ajouter une charge')
@section('breadcrumb', 'Accueil / Charges / Ajouter')

@section('content')

<h2>Nouvelle charge manuelle</h2>

<form action="{{ route('charges.store') }}" method="POST">
    @csrf

    <div>
        <label>Appartement *</label>
        <select name="appartement_id">
            <option value="">-- Sélectionner --</option>
            @foreach($appartements as $appart)
                <option value="{{ $appart->id }}"
                    {{ old('appartement_id') == $appart->id ? 'selected' : '' }}>
                    {{ $appart->immeuble->nom }} — Appart. {{ $appart->numero }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Mois *</label>
        <input type="month" name="mois" value="{{ old('mois', date('Y-m')) }}">
    </div>

    <div>
        <label>Montant (MAD) *</label>
        <input type="number" name="montant" step="0.01" min="0"
               value="{{ old('montant') }}" placeholder="Ex: 350.00">
    </div>

    <div>
        <label>Description</label>
        <input type="text" name="description" value="{{ old('description') }}">
    </div>

    <div>
        <label>Statut *</label>
        <select name="statut">
            <option value="impayée" {{ old('statut') == 'impayée' ? 'selected' : '' }}>Impayée</option>
            <option value="payée" {{ old('statut') == 'payée' ? 'selected' : '' }}>Payée</option>
            <option value="en retard" {{ old('statut') == 'en retard' ? 'selected' : '' }}>En retard</option>
        </select>
    </div>

    <button type="submit">Enregistrer</button>
    <a href="{{ route('charges.index') }}">Annuler</a>

</form>

@endsection