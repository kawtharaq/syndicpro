@extends('layouts.app')
@section('title', 'Ajouter un immeuble')
@section('breadcrumb', 'Accueil / Immeubles / Ajouter')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">
        <i class="fas fa-plus-circle text-blue-500 mr-2"></i>Nouvel immeuble
    </h3>

    <form action="{{ route('immeubles.store') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Nom --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nom <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nom" value="{{ old('nom') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nom') border-red-400 @enderror"
                   placeholder="Ex: Résidence Al Amal">
            @error('nom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Adresse --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Adresse <span class="text-red-500">*</span>
            </label>
            <textarea name="adresse" rows="2"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('adresse') border-red-400 @enderror"
                      placeholder="Ex: 12 Rue Hassan II">{{ old('adresse') }}</textarea>
            @error('adresse')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Ville --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Ville <span class="text-red-500">*</span>
            </label>
            <input type="text" name="ville" value="{{ old('ville') }}"
                   list="villes-list"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('ville') border-red-400 @enderror"
                   placeholder="Ex: Oujda, Casablanca...">
            <datalist id="villes-list">
                @foreach($villes as $v)
                    <option value="{{ $v }}">
                @endforeach
            </datalist>
            @error('ville')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Étages + Appartements --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre d'étages</label>
                <input type="number" name="nb_etages" value="{{ old('nb_etages') }}" min="0"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                       placeholder="Ex: 5">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre d'appartements</label>
                <input type="number" name="nb_appartements" value="{{ old('nb_appartements') }}" min="0"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                       placeholder="Ex: 20">
            </div>
        </div>

        {{-- Boutons --}}
        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-save mr-1"></i> Enregistrer
            </button>
            <a href="{{ route('immeubles.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg transition">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection