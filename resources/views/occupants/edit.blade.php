@extends('layouts.app')

@section('title', 'Modifier l\'occupant')
@section('breadcrumb', 'Accueil / Occupants / Modifier')

@section('content')

<h3>Modifier : {{ $occupant->nom }}</h3>

<form action="{{ route('occupants.update', $occupant) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Appartement *</label>
        <select name="appartement_id">
            @foreach($appartements as $appart)
                <option value="{{ $appart->id }}"
                    {{ old('appartement_id', $occupant->appartement_id) == $appart->id ? 'selected' : '' }}>
                    {{ $appart->immeuble->nom }} — Appart. {{ $appart->numero }}
                    {{ $appart->id == $occupant->appartement_id ? '(actuel)' : '' }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Nom complet *</label>
        <input type="text" name="nom" value="{{ old('nom', $occupant->nom) }}">
    </div>

    <div>
        <label>Téléphone</label>
        <input type="text" name="telephone" value="{{ old('telephone', $occupant->telephone) }}">
    </div>

    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $occupant->email) }}">
    </div>

    <div>
        <label>Type *</label>
        <select name="type">
            <option value="propriétaire" {{ old('type', $occupant->type) == 'propriétaire' ? 'selected' : '' }}>
                Propriétaire
            </option>
            <option value="locataire" {{ old('type', $occupant->type) == 'locataire' ? 'selected' : '' }}>
                Locataire
            </option>
        </select>
    </div>

    <div>
        <label>Date d'entrée</label>
        <input type="date" name="date_entree"
               value="{{ old('date_entree', $occupant->date_entree?->format('Y-m-d')) }}">
    </div>

    <button type="submit">Mettre à jour</button>
    <a href="{{ route('occupants.index') }}">Annuler</a>
</form>

@endsection