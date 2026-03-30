@extends('layouts.app')
@section('title', 'Enregistrer un paiement')
@section('breadcrumb', 'Accueil / Paiements / Enregistrer')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">
        <i class="fas fa-money-bill-wave text-green-500 mr-2"></i>Nouveau paiement
    </h3>

    <form action="{{ route('paiements.store') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Charge --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Charge concernée <span class="text-red-500">*</span>
            </label>
            <select name="charge_id" id="charge_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('charge_id') border-red-400 @enderror"
                    onchange="this.form.submit()">
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
            @error('charge_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Occupant --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Occupant <span class="text-red-500">*</span>
            </label>
            <select name="occupant_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('occupant_id') border-red-400 @enderror">
                <option value="">-- Sélectionner l'occupant --</option>
                @foreach($occupants as $occupant)
                    <option value="{{ $occupant->id }}"
                        {{ old('occupant_id', $occupantCharge?->id) == $occupant->id ? 'selected' : '' }}>
                        {{ $occupant->nom }} — Appart. {{ $occupant->appartement->numero }}
                    </option>
                @endforeach
            </select>
            @error('occupant_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            {{-- Montant --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Montant (MAD) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="montant" value="{{ old('montant') }}"
                       step="0.01" min="0.01"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('montant') border-red-400 @enderror"
                       placeholder="Ex: 300.00">
                @error('montant')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Date --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Date de paiement <span class="text-red-500">*</span>
                </label>
                <input type="date" name="date_paiement"
                       value="{{ old('date_paiement', date('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('date_paiement') border-red-400 @enderror">
                @error('date_paiement')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Mode --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mode de paiement</label>
            <select name="mode"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Sélectionner --</option>
                <option value="espèces"  {{ old('mode') == 'espèces'  ? 'selected' : '' }}>💵 Espèces</option>
                <option value="virement" {{ old('mode') == 'virement' ? 'selected' : '' }}>🏦 Virement</option>
                <option value="chèque"   {{ old('mode') == 'chèque'   ? 'selected' : '' }}>📝 Chèque</option>
            </select>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-save mr-1"></i> Enregistrer
            </button>
            <a href="{{ route('paiements.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg transition">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection