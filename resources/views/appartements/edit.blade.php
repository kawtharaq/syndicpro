@extends('layouts.app')

@section('title', 'Modifier l\'appartement')
@section('breadcrumb', 'Accueil / Appartements / Modifier')

@section('content')

<div>
    <h3>Modifier : Appartement {{ $appartement->numero }}</h3>

    <form action="{{ route('appartements.update', $appartement) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Immeuble --}}
        <div>
            <label>Immeuble *</label>
            <select name="immeuble_id">
                @foreach($immeubles as $imm)
                    <option value="{{ $imm->id }}"
                        {{ old('immeuble_id', $appartement->immeuble_id) == $imm->id ? 'selected' : '' }}>
                        {{ $imm->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Numéro + Étage --}}
        <div>
            <label>Numéro *</label>
            <input type="text"
                   name="numero"
                   value="{{ old('numero', $appartement->numero) }}">
        </div>

        <div>
            <label>Étage</label>
            <input type="number"
                   name="etage"
                   value="{{ old('etage', $appartement->etage) }}">
        </div>

        {{-- Superficie + Statut --}}
        <div>
            <label>Superficie (m²)</label>
            <input type="number"
                   name="superficie"
                   step="0.01"
                   min="0"
                   value="{{ old('superficie', $appartement->superficie) }}">
        </div>

        <div>
            <label>Statut *</label>
            <select name="statut">
                <option value="vacant"
                    {{ old('statut', $appartement->statut) == 'vacant' ? 'selected' : '' }}>
                    Vacant
                </option>
                <option value="occupé"
                    {{ old('statut', $appartement->statut) == 'occupé' ? 'selected' : '' }}>
                    Occupé
                </option>
            </select>
        </div>

        {{-- Buttons --}}
        <div>
            <button type="submit">Mettre à jour</button>
            <a href="{{ route('appartements.index') }}">Annuler</a>
        </div>

    </form>
</div>

@endsection