@extends('layouts.app')
@section('title', 'Ajouter un occupant')
@section('breadcrumb', 'Accueil / Occupants / Ajouter')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">
        <i class="fas fa-user-plus text-blue-500 mr-2"></i>Nouvel occupant
    </h3>

    <form action="{{ route('occupants.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Appartement <span class="text-red-500">*</span>
            </label>
            <select name="appartement_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('appartement_id') border-red-400 @enderror">
                <option value="">-- Sélectionner un appartement vacant --</option>
                @foreach($appartements as $appart)
                    <option value="{{ $appart->id }}"
                        {{ old('appartement_id', $selectedAppartement) == $appart->id ? 'selected' : '' }}>
                        {{ $appart->immeuble->nom }} — Appart. {{ $appart->numero }}
                    </option>
                @endforeach
            </select>
            @error('appartement_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nom complet <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nom" value="{{ old('nom') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nom') border-red-400 @enderror"
                   placeholder="Ex: Mohammed Alami">
            @error('nom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                <input type="text" name="telephone" value="{{ old('telephone') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('telephone') border-red-400 @enderror"
                       placeholder="Ex: 0661234567">
                @error('telephone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-400 @enderror"
                       placeholder="Ex: mohammed@email.com">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Type <span class="text-red-500">*</span>
                </label>
                <select name="type"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('type') border-red-400 @enderror">
                    <option value="">-- Sélectionner --</option>
                    <option value="propriétaire" {{ old('type') == 'propriétaire' ? 'selected' : '' }}>🏠 Propriétaire</option>
                    <option value="locataire"    {{ old('type') == 'locataire'    ? 'selected' : '' }}>🔑 Locataire</option>
                </select>
                @error('type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date d'entrée</label>
                <input type="date" name="date_entree" value="{{ old('date_entree') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-save mr-1"></i> Enregistrer
            </button>
            <a href="{{ route('occupants.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg transition">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection