@extends('layouts.app')
@section('title', 'Modifier l\'immeuble')
@section('breadcrumb', 'Accueil / Immeubles / Modifier')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">
        <i class="fas fa-edit text-yellow-500 mr-2"></i>Modifier : {{ $immeuble->nom }}
    </h3>

    <form action="{{ route('immeubles.update', $immeuble) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
            <input type="text" name="nom" value="{{ old('nom', $immeuble->nom) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nom') border-red-400 @enderror">
            @error('nom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Adresse <span class="text-red-500">*</span></label>
            <textarea name="adresse" rows="2"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('adresse', $immeuble->adresse) }}</textarea>
            @error('adresse')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre d'étages</label>
                <input type="number" name="nb_etages" value="{{ old('nb_etages', $immeuble->nb_etages) }}" min="0"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre d'appartements</label>
                <input type="number" name="nb_appartements" value="{{ old('nb_appartements', $immeuble->nb_appartements) }}" min="0"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-save mr-1"></i> Mettre à jour
            </button>
            <a href="{{ route('immeubles.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg transition">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection