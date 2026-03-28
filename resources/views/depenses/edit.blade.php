@extends('layouts.app')
@section('title', 'Modifier la dépense')
@section('breadcrumb', 'Accueil / Dépenses / Modifier')

@section('content')

<h3>Modifier la dépense</h3>

<form action="{{ route('depenses.update', $depense) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Immeuble --}}
    <div>
        <label>Immeuble *</label>
        <select name="immeuble_id">
            @foreach($immeubles as $imm)
                <option value="{{ $imm->id }}"
                    {{ old('immeuble_id', $depense->immeuble_id) == $imm->id ? 'selected' : '' }}>
                    {{ $imm->nom }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Date + Montant --}}
    <div>
        <label>Date</label>
        <input type="date" name="date"
               value="{{ old('date', $depense->date->format('Y-m-d')) }}">

        @error('date')
            <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label>Montant (MAD)</label>
        <input type="number" name="montant"
               value="{{ old('montant', $depense->montant) }}"
               step="0.01" min="0.01">

        @error('montant')
            <p>{{ $message }}</p>
        @enderror
    </div>

    {{-- Catégorie --}}
    <div>
        <label>Catégorie</label>
        <select name="categorie">
            @foreach($categories as $cat)
                <option value="{{ $cat }}"
                    {{ old('categorie', $depense->categorie) == $cat ? 'selected' : '' }}>
                    {{ ucfirst($cat) }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Description --}}
    <div>
        <label>Description</label>
        <textarea name="description" rows="3">{{ old('description', $depense->description) }}</textarea>
    </div>

    <button type="submit">Mettre à jour</button>
    <a href="{{ route('depenses.index') }}">Annuler</a>

</form>

@endsection