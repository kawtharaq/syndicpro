@extends('layouts.app')

@section('title', 'Ajouter un appartement')
@section('breadcrumb', 'Accueil / Appartements / Ajouter')

@section('content')

<div>
    <h3>Nouvel appartement</h3>

    <form action="{{ route('appartements.store') }}" method="POST">
        @csrf

        {{-- Immeuble --}}
        <div>
            <label>Immeuble *</label>
            <select name="immeuble_id">
                <option value="">-- Sélectionner un immeuble --</option>
                @foreach($immeubles as $imm)
                    <option value="{{ $imm->id }}"
                        {{ (old('immeuble_id', $selectedImmeuble) == $imm->id) ? 'selected' : '' }}>
                        {{ $imm->nom }}
                    </option>
                @endforeach
            </select>
            @error('immeuble_id')
                <p>{{ $message }}</p>
            @enderror
        </div>

        {{-- Numéro + Étage --}}
        <div>
            <label>Numéro *</label>
            <input type="text" name="numero" value="{{ old('numero') }}" placeholder="Ex: A1, 201, RDC">
            @error('numero')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Étage</label>
            <input type="number" name="etage" value="{{ old('etage') }}">
        </div>

        {{-- Superficie + Statut --}}
        <div>
            <label>Superficie (m²)</label>
            <input type="number" name="superficie" value="{{ old('superficie') }}" step="0.01" min="0">
        </div>

        <div>
            <label>Statut *</label>
            <select name="statut">
                <option value="vacant" {{ old('statut') == 'vacant' ? 'selected' : '' }}>Vacant</option>
                <option value="occupé" {{ old('statut') == 'occupé' ? 'selected' : '' }}>Occupé</option>
            </select>
            @error('statut')
                <p>{{ $message }}</p>
            @enderror
        </div>

        {{-- Buttons --}}
        <div>
            <button type="submit">Enregistrer</button>
            <a href="{{ route('appartements.index') }}">Annuler</a>
        </div>

    </form>
</div>

@endsection