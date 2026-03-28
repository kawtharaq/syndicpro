@extends('layouts.app')
@section('title', 'Ajouter un immeuble')
@section('breadcrumb', 'Accueil / Immeubles / Ajouter')

@section('content')

<div>
    <h3>Nouvel immeuble</h3>

    <form action="{{ route('immeubles.store') }}" method="POST">
        @csrf

        <div>
            <label>Nom *</label><br>
            <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Ex: Résidence Al Amal">
            @error('nom')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label>Adresse *</label><br>
            <textarea name="adresse" rows="2" placeholder="Ex: 12 Rue Hassan II, Oujda">{{ old('adresse') }}</textarea>
            @error('adresse')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label>Nombre d'étages</label><br>
            <input type="number" name="nb_etages" value="{{ old('nb_etages') }}" min="0" placeholder="Ex: 5">
        </div>

        <br>

        <div>
            <label>Nombre d'appartements</label><br>
            <input type="number" name="nb_appartements" value="{{ old('nb_appartements') }}" min="0" placeholder="Ex: 20">
        </div>

        <br><br>

        <div>
            <button type="submit">Enregistrer</button>
            <a href="{{ route('immeubles.index') }}">Annuler</a>
        </div>

    </form>
</div>

@endsection