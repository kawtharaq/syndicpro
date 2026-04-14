@extends('layouts.app')
@section('title', 'Modifier l\'occupant')
@section('breadcrumb', 'Accueil / Occupants / Modifier')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">
        <i class="fas fa-user-edit text-yellow-500 mr-2"></i>Modifier : {{ $occupant->nom }}
    </h3>

    <form action="{{ route('occupants.update', $occupant) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Appartement <span class="text-red-500">*</span>
            </label>
            <select name="appartement_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                @foreach($appartements as $appart)
                    <option value="{{ $appart->id }}"
                        {{ old('appartement_id', $occupant->appartement_id) == $appart->id ? 'selected' : '' }}>
                        {{ $appart->immeuble->nom }} — Appart. {{ $appart->numero }}
                        {{ $appart->id == $occupant->appartement_id ? '(actuel)' : '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nom complet <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nom" value="{{ old('nom', $occupant->nom) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                <input type="text" name="telephone" value="{{ old('telephone', $occupant->telephone) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $occupant->email) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Type <span class="text-red-500">*</span>
                </label>
                <select name="type"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="propriétaire" {{ old('type', $occupant->type) == 'propriétaire' ? 'selected' : '' }}>🏠 Propriétaire</option>
                    <option value="locataire"    {{ old('type', $occupant->type) == 'locataire'    ? 'selected' : '' }}>🔑 Locataire</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date d'entrée</label>
                <input type="date" name="date_entree"
                       value="{{ old('date_entree', $occupant->date_entree?->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-save mr-1"></i> Mettre à jour
            </button>
            <a href="{{ route('occupants.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg transition">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection