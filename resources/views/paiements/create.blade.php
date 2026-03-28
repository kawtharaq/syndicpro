@extends('layouts.app')
@section('title', 'Enregistrer un paiement')
@section('breadcrumb', 'Accueil / Paiements / Enregistrer')

@section('content')

<h3>Nouveau paiement</h3>

<form action="{{ route('paiements.store') }}" method="POST">
    @csrf

    <div>
        <label>Charge concernée *</label>
        <select name="charge_id" id="charge_id" onchange="this.form.submit()">
            <option value="">-- Sélectionner une charge impayée --</option>
            @foreach($charges as $charge)
                <option value="{{ $charge->id }}"
                    {{ old('charge_id', $selectedCharge) == $charge->id ? 'selected' : '' }}>
                    Appart. {{ $charge->appartement->numero }} —
                    {{ $charge->appartement->immeuble->nom }} —
                    {{ $charge->mois->format('m/Y') }} —
                    {{ number_format($charge->montant, 2) }} MAD
                </option>
            @endforeach
        </select>

        @error('charge_id')
            <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label>Occupant *</label>
        <select name="occupant_id">
            <option value="">-- Sélectionner l'occupant --</option>
            @foreach($occupants as $occupant)
                <option value="{{ $occupant->id }}"
                    {{ old('occupant_id', $occupantCharge?->id) == $occupant->id ? 'selected' : '' }}>
                    {{ $occupant->nom }} — Appart. {{ $occupant->appartement->numero }}
                </option>
            @endforeach
        </select>

        @error('occupant_id')
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

    <div>
        <label>Date de paiement *</label>
        <input type="date" name="date_paiement"
               value="{{ old('date_paiement', date('Y-m-d')) }}">

        @error('date_paiement')
            <p>{{ $message }}</p>
        @enderror
    </div>

 
    <div>
        <label>Mode de paiement</label>
        <select name="mode">
            <option value="">-- Sélectionner --</option>
            <option value="espèces" {{ old('mode') == 'espèces' ? 'selected' : '' }}>Espèces</option>
            <option value="virement" {{ old('mode') == 'virement' ? 'selected' : '' }}>Virement</option>
            <option value="chèque" {{ old('mode') == 'chèque' ? 'selected' : '' }}>Chèque</option>
        </select>
    </div>

    <button type="submit">Enregistrer</button>
    <a href="{{ route('paiements.index') }}">Annuler</a>

</form>

@endsection