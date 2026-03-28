@extends('layouts.app')
@section('title', 'Ajouter une dépense')
@section('breadcrumb', 'Accueil / Dépenses / Ajouter')

@section('content')

<h3>Nouvelle dépense</h3>

<form action="{{ route('depenses.store') }}" method="POST">
    @csrf

    {{-- Immeuble --}}
    <div>
        <label>Immeuble *</label>
        <select name="immeuble_id">
            <option value="">-- Sélectionner un immeuble --</option>
            @foreach($immeubles as $imm)
                <option value="{{ $imm->id }}" {{ old('immeuble_id') == $imm->id ? 'selected' : '' }}>
                    {{ $imm->nom }}
                </option>
            @endforeach
        </select>

        @error('immeuble_id')
            <p>{{ $message }}</p>
        @enderror
    </div>

    {{-- Date + Montant --}}
    <div>
        <label>Date *</label>
        <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}">

        @error('date')
            <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label>Montant (MAD) *</label>
        <input type="number" name="montant" step="0.01" min="0.01"
               value="{{ old('montant') }}">

        @error('montant')
            <p>{{ $message }}</p>
        @enderror
    </div>

    {{-- Catégorie --}}
    <div>
        <label>Catégorie *</label>
        <select name="categorie">
            <option value="">-- Sélectionner --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ old('categorie') == $cat ? 'selected' : '' }}>
                    {{ ucfirst($cat) }}
                </option>
            @endforeach
        </select>

        @error('categorie')
            <p>{{ $message }}</p>
        @enderror
    </div>

    {{-- Description --}}
    <div>
        <label>Description</label>
        <textarea name="description" rows="3">{{ old('description') }}</textarea>
    </div>

    <button type="submit">Enregistrer</button>
    <a href="{{ route('depenses.index') }}">Annuler</a>

</form>

@endsection