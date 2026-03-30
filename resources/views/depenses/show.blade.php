@extends('layouts.app')
@section('title', 'Détail dépense')
@section('breadcrumb', 'Accueil / Dépenses / Détail')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">

    <div class="flex justify-between items-start mb-6">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Détail de la dépense</h3>
            <p class="text-gray-400 text-sm mt-1">Ajoutée le {{ $depense->created_at->format('d/m/Y') }}</p>
        </div>
        <a href="{{ route('depenses.edit', $depense) }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">
            <i class="fas fa-edit mr-1"></i> Modifier
        </a>
    </div>

    <div class="space-y-4">
        <div class="flex justify-between py-3 border-b">
            <span class="text-gray-500">Immeuble</span>
            <span class="font-semibold text-gray-800">{{ $depense->immeuble->nom }}</span>
        </div>
        <div class="flex justify-between py-3 border-b">
            <span class="text-gray-500">Date</span>
            <span class="font-semibold text-gray-800">{{ $depense->date->format('d/m/Y') }}</span>
        </div>
        <div class="flex justify-between py-3 border-b">
            <span class="text-gray-500">Catégorie</span>
            <span class="font-semibold text-gray-800 capitalize">{{ $depense->categorie }}</span>
        </div>
        <div class="flex justify-between py-3 border-b">
            <span class="text-gray-500">Description</span>
            <span class="font-semibold text-gray-800">{{ $depense->description ?? '—' }}</span>
        </div>
        <div class="flex justify-between py-4 bg-orange-50 rounded-lg px-4">
            <span class="text-gray-600 font-medium">Montant</span>
            <span class="text-2xl font-bold text-orange-600">
                {{ number_format($depense->montant, 2) }} MAD
            </span>
        </div>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('depenses.index') }}"
           class="text-blue-500 hover:text-blue-700 text-sm">
            <i class="fas fa-arrow-left mr-1"></i> Retour à la liste
        </a>
        <form action="{{ route('depenses.destroy', $depense) }}" method="POST"
              onsubmit="return confirm('Supprimer cette dépense ?')">
            @csrf @method('DELETE')
            <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                <i class="fas fa-trash mr-1"></i> Supprimer
            </button>
        </form>
    </div>
</div>

@endsection