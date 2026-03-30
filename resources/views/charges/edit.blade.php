@extends('layouts.app')
@section('title', 'Modifier la charge')
@section('breadcrumb', 'Accueil / Charges / Modifier')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">
        <i class="fas fa-edit text-yellow-500 mr-2"></i>Modifier la charge
    </h3>

    <form action="{{ route('charges.update', $charge) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Appartement</label>
            <select name="appartement_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                @foreach($appartements as $appart)
                    <option value="{{ $appart->id }}"
                        {{ old('appartement_id', $charge->appartement_id) == $appart->id ? 'selected' : '' }}>
                        {{ $appart->immeuble->nom }} — Appart. {{ $appart->numero }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mois</label>
                <input type="month" name="mois"
                       value="{{ old('mois', $charge->mois->format('Y-m')) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Montant (MAD)</label>
                <input type="number" name="montant"
                       value="{{ old('montant', $charge->montant) }}" step="0.01" min="0"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <input type="text" name="description"
                   value="{{ old('description', $charge->description) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select name="statut"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="impayée"   {{ old('statut', $charge->statut) == 'impayée'   ? 'selected' : '' }}>⏳ Impayée</option>
                <option value="payée"     {{ old('statut', $charge->statut) == 'payée'     ? 'selected' : '' }}>✓ Payée</option>
                <option value="en retard" {{ old('statut', $charge->statut) == 'en retard' ? 'selected' : '' }}>⚠ En retard</option>
            </select>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-save mr-1"></i> Mettre à jour
            </button>
            <a href="{{ route('charges.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg transition">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection