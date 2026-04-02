@extends('layouts.app')
@section('title', 'Modifier l\'appartement')
@section('breadcrumb', 'Accueil / Appartements / Modifier')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">
        <i class="fas fa-edit text-yellow-500 mr-2"></i>Modifier : Appart. {{ $appartement->numero }}
    </h3>

    <form action="{{ route('appartements.update', $appartement) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')

        {{-- Immeuble --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Immeuble <span class="text-red-500">*</span>
            </label>
            <select name="immeuble_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                @foreach($immeubles as $imm)
                    <option value="{{ $imm->id }}"
                        {{ old('immeuble_id', $appartement->immeuble_id) == $imm->id ? 'selected' : '' }}>
                        {{ $imm->nom }} — {{ $imm->ville }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Numéro + Étage --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Numéro <span class="text-red-500">*</span>
                </label>
                <input type="text" name="numero" value="{{ old('numero', $appartement->numero) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Étage</label>
                <input type="number" name="etage" value="{{ old('etage', $appartement->etage) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
        </div>

        {{-- Superficie + Statut --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Superficie (m²)</label>
                <input type="number" name="superficie" value="{{ old('superficie', $appartement->superficie) }}"
                       step="0.01" min="0"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Statut <span class="text-red-500">*</span>
                </label>
                <select name="statut"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="vacant" {{ old('statut', $appartement->statut) == 'vacant' ? 'selected' : '' }}>○ Vacant</option>
                    <option value="occupé" {{ old('statut', $appartement->statut) == 'occupé' ? 'selected' : '' }}>● Occupé</option>
                </select>
            </div>
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Description <span class="text-gray-400 text-xs">(optionnel)</span>
            </label>
            <textarea name="description" rows="2"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('description', $appartement->description) }}</textarea>
        </div>

        {{-- Prix charge + Charges payées --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Prix charge mensuel (MAD)
                    <span class="text-gray-400 text-xs">(optionnel)</span>
                </label>
                <input type="number" name="prix_charge"
                       value="{{ old('prix_charge', $appartement->prix_charge) }}"
                       step="0.01" min="0"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut charges</label>
                <div class="flex items-center gap-3 mt-2 p-3 border border-gray-300 rounded-lg">
                    <input type="checkbox" name="charges_payees" id="charges_payees" value="1"
                           {{ old('charges_payees', $appartement->charges_payees) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 rounded cursor-pointer">
                    <label for="charges_payees" class="text-sm text-gray-700 cursor-pointer">
                        ✓ Charges payées
                    </label>
                </div>
            </div>
        </div>

        {{-- Boutons --}}
        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-save mr-1"></i> Mettre à jour
            </button>
            <a href="{{ route('appartements.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg transition">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection