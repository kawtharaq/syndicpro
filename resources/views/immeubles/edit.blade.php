@extends('layouts.app')
@section('title', 'Modifier l\'immeuble')
@section('breadcrumb', 'Accueil / Immeubles / Modifier')

@section('content')

<div>
    <h3>Modifier : {{ $immeuble->nom }}</h3>

    <form action="{{ route('immeubles.update', $immeuble) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Nom *</label><br>
            <input type="text" name="nom" value="{{ old('nom', $immeuble->nom) }}">
            @error('nom')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label>Adresse *</label><br>
            <textarea name="adresse" rows="2">{{ old('adresse', $immeuble->adresse) }}</textarea>
            @error('adresse')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label>Nombre d'étages</label><br>
            <input type="number" name="nb_etages" value="{{ old('nb_etages', $immeuble->nb_etages) }}" min="0">
        </div>

        <br>

        <div>
            <label>Nombre d'appartements</label><br>
            <input type="number" name="nb_appartements" value="{{ old('nb_appartements', $immeuble->nb_appartements) }}" min="0">
        </div>

        <br><br>

        <div>
            <button type="submit">Mettre à jour</button>
            <a href="{{ route('immeubles.index') }}">Annuler</a>
        </div>

    </form>
</div>

@endsection