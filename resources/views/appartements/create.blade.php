@extends('layouts.app')
@section('title', 'Ajouter un appartement')
@section('breadcrumb', 'Accueil / Appartements / Ajouter')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">
        <i class="fas fa-plus-circle text-blue-500 mr-2"></i>Nouvel appartement
    </h3>

    <form action="{{ route('appartements.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Immeuble <span class="text-red-500">*</span>
            </label>
            <select name="immeuble_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('immeuble_id') border-red-400 @enderror">
                <option value="">-- Sélectionner un immeuble --</option>
                @foreach($immeubles as $imm)
                    <option value="{{ $imm->id }}"
                        {{ (old('immeuble_id', $selectedImmeuble) == $imm->id) ? 'selected' : '' }}>
                        {{ $imm->nom }}
                    </option>
                @endforeach
            </select>
            @error('immeuble_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Numéro <span class="text-red-500">*</span>
                </label>
                <input type="text" name="numero" value="{{ old('numero') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('numero') border-red-400 @enderror"
                       placeholder="Ex: A1, 201, RDC">
                @error('numero')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Étage</label>
                <input type="number" name="etage" value="{{ old('etage') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                       placeholder="Ex: 2">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Superficie (m²)</label>
                <input type="number" name="superficie" value="{{ old('superficie') }}" step="0.01" min="0"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                       placeholder="Ex: 75.50">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Statut <span class="text-red-500">*</span>
                </label>
                <select name="statut"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('statut') border-red-400 @enderror">
                    <option value="vacant"  {{ old('statut') == 'vacant'  ? 'selected' : '' }}>Vacant</option>
                    <option value="occupé"  {{ old('statut') == 'occupé'  ? 'selected' : '' }}>Occupé</option>
                </select>
                @error('statut')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-save mr-1"></i> Enregistrer
            </button>
            <a href="{{ route('appartements.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg transition">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection