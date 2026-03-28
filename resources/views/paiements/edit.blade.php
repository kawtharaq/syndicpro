@extends('layouts.app')
@section('title', 'Modifier le paiement')
@section('breadcrumb', 'Accueil / Paiements / Modifier')

@section('content')

<h3>Modifier le paiement</h3>

<form action="{{ route('paiements.update', $paiement) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Charge --}}
    <div>
        <label>Charge</label>
        <select name="charge_id">
            @foreach($charges as $charge)
                <option value="{{ $charge->id }}"
                    {{ old('charge_id', $paiement->charge_id) == $charge->id ? 'selected' : '' }}>
                    Appart. {{ $charge->appartement->numero }} —
                    {{ $charge->mois->format('m/Y') }} —
                    {{ number_format($charge->montant, 2) }} MAD
                </option>
            @endforeach
        </select>
    </div>

    {{-- Occupant --}}
    <div>
        <label>Occupant</label>
        <select name="occupant_id">
            @foreach($occupants as $occupant)
                <option value="{{ $occupant->id }}"
                    {{ old('occupant_id', $paiement->occupant_id) == $occupant->id ? 'selected' : '' }}>
                    {{ $occupant->nom }} — Appart. {{ $occupant->appartement->numero }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Montant + Date --}}
    <div>
        <label>Montant (MAD)</label>
        <input type="number" name="montant"
               value="{{ old('montant', $paiement->montant) }}"
               step="0.01" min="0.01">

        @error('montant')
            <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label>Date de paiement</label>
        <input type="date" name="date_paiement"
               value="{{ old('date_paiement', $paiement->date_paiement->format('Y-m-d')) }}">
    </div>

    {{-- Mode --}}
    <div>
        <label>Mode de paiement</label>
        <select name="mode">
            <option value="">-- Sélectionner --</option>
            <option value="espèces" {{ old('mode', $paiement->mode) == 'espèces' ? 'selected' : '' }}>Espèces</option>
            <option value="virement" {{ old('mode', $paiement->mode) == 'virement' ? 'selected' : '' }}>Virement</option>
            <option value="chèque" {{ old('mode', $paiement->mode) == 'chèque' ? 'selected' : '' }}>Chèque</option>
        </select>
    </div>

    <button type="submit">Mettre à jour</button>
    <a href="{{ route('paiements.index') }}">Annuler</a>

</form>

@endsection