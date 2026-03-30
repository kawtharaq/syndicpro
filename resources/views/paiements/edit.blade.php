@extends('layouts.app')
@section('title', 'Modifier le paiement')
@section('breadcrumb', 'Accueil / Paiements / Modifier')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">
        <i class="fas fa-edit text-yellow-500 mr-2"></i>Modifier le paiement
    </h3>

    <form action="{{ route('paiements.update', $paiement) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Charge</label>
            <select name="charge_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
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

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Occupant</label>
            <select name="occupant_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                @foreach($occupants as $occupant)
                    <option value="{{ $occupant->id }}"
                        {{ old('occupant_id', $paiement->occupant_id) == $occupant->id ? 'selected' : '' }}>
                        {{ $occupant->nom }} — Appart. {{ $occupant->appartement->numero }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Montant (MAD)</label>
                <input type="number" name="montant"
                       value="{{ old('montant', $paiement->montant) }}"
                       step="0.01" min="0.01"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('montant')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date de paiement</label>
                <input type="date" name="date_paiement"
                       value="{{ old('date_paiement', $paiement->date_paiement->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mode de paiement</label>
            <select name="mode"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Sélectionner --</option>
                <option value="espèces"  {{ old('mode', $paiement->mode) == 'espèces'  ? 'selected' : '' }}>💵 Espèces</option>
                <option value="virement" {{ old('mode', $paiement->mode) == 'virement' ? 'selected' : '' }}>🏦 Virement</option>
                <option value="chèque"   {{ old('mode', $paiement->mode) == 'chèque'   ? 'selected' : '' }}>📝 Chèque</option>
            </select>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-save mr-1"></i> Mettre à jour
            </button>
            <a href="{{ route('paiements.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg transition">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection