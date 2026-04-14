@extends('layouts.app')
@section('title', 'Ajouter une charge')
@section('breadcrumb', 'Accueil / Charges / Ajouter')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">
        <i class="fas fa-plus-circle text-blue-500 mr-2"></i>Nouvelle charge manuelle
    </h3>

    <form action="{{ route('charges.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Appartement <span class="text-red-500">*</span>
            </label>
            <select name="appartement_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('appartement_id') border-red-400 @enderror">
                <option value="">-- Sélectionner --</option>
                @foreach($appartements as $appart)
                    <option value="{{ $appart->id }}" {{ old('appartement_id') == $appart->id ? 'selected' : '' }}>
                        {{ $appart->immeuble->nom }} — Appart. {{ $appart->numero }}
                    </option>
                @endforeach
            </select>
            @error('appartement_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Mois <span class="text-red-500">*</span>
                </label>
                <input type="month" name="mois" value="{{ old('mois', date('Y-m')) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('mois') border-red-400 @enderror">
                @error('mois')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Montant (MAD) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="montant" value="{{ old('montant') }}" step="0.01" min="0"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('montant') border-red-400 @enderror"
                       placeholder="Ex: 350.00">
                @error('montant')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <input type="text" name="description" value="{{ old('description') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                   placeholder="Ex: Charges communes, gardien...">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Statut <span class="text-red-500">*</span>
            </label>
            <select name="statut"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="impayée"   {{ old('statut') == 'impayée'   ? 'selected' : '' }}>⏳ Impayée</option>
                <option value="payée"     {{ old('statut') == 'payée'     ? 'selected' : '' }}>✓ Payée</option>
                <option value="en retard" {{ old('statut') == 'en retard' ? 'selected' : '' }}>⚠ En retard</option>
            </select>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-save mr-1"></i> Enregistrer
            </button>
            <a href="{{ route('charges.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg transition">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection