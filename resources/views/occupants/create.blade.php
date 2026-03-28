@extends('layouts.app')

@section('title', 'Ajouter un occupant')
@section('breadcrumb', 'Accueil / Occupants / Ajouter')

@section('content')

<div>
    <h3>Nouvel occupant</h3>

    <form action="{{ route('occupants.store') }}" method="POST">
        @csrf

        {{-- Appartement --}}
        <div>
            <label>Appartement *</label>
            <select name="appartement_id">
                <option value="">-- Sélectionner un appartement vacant --</option>
                @foreach($appartements as $appart)
                    <option value="{{ $appart->id }}"
                        {{ old('appartement_id', $selectedAppartement) == $appart->id ? 'selected' : '' }}>
                        {{ $appart->immeuble->nom }} — Appart. {{ $appart->numero }}
                    </option>
                @endforeach
            </select>
            @error('appartement_id')
                <p>{{ $message }}</p>
            @enderror
        </div>

        {{-- Nom --}}
        <div>
            <label>Nom complet *</label>
            <input type="text" name="nom" value="{{ old('nom') }}">
            @error('nom')
                <p>{{ $message }}</p>
            @enderror
        </div>

        {{-- Contact --}}
        <div>
            <label>Téléphone</label>
            <input type="text" name="telephone" value="{{ old('telephone') }}">
            @error('telephone')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}">
            @error('email')
                <p>{{ $message }}</p>
            @enderror
        </div>

        {{-- Type + Date --}}
        <div>
            <label>Type *</label>
            <select name="type">
                <option value="">-- Sélectionner --</option>
                <option value="propriétaire" {{ old('type') == 'propriétaire' ? 'selected' : '' }}>
                    Propriétaire
                </option>
                <option value="locataire" {{ old('type') == 'locataire' ? 'selected' : '' }}>
                    Locataire
                </option>
            </select>
            @error('type')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Date d'entrée</label>
            <input type="date" name="date_entree" value="{{ old('date_entree') }}">
        </div>

        {{-- Buttons --}}
        <div>
            <button type="submit">Enregistrer</button>
            <a href="{{ route('occupants.index') }}">Annuler</a>
        </div>

    </form>
</div>

@endsection