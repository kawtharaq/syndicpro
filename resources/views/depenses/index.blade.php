@extends('layouts.app')
@section('title', 'Dépenses')
@section('breadcrumb', 'Accueil / Dépenses')

@section('content')

{{-- Stats total + par catégorie --}}
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-orange-400 col-span-2 lg:col-span-1">
        <p class="text-xs text-gray-400">Total dépenses (filtre actuel)</p>
        <p class="text-2xl font-bold text-orange-600">{{ number_format($totalDepenses, 2) }} MAD</p>
    </div>
    @foreach($parCategorie as $cat)
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-gray-300">
        <p class="text-xs text-gray-400 capitalize">{{ $cat->categorie }}</p>
        <p class="text-xl font-bold text-gray-700">{{ number_format($cat->total, 2) }} MAD</p>
    </div>
    @endforeach
</div>

{{-- Filtres --}}
<form method="GET" action="{{ route('depenses.index') }}"
      class="bg-white rounded-xl shadow p-4 mb-6 flex flex-wrap gap-4 items-end">
    <div>
        <label class="block text-xs text-gray-500 mb-1">Mois</label>
        <input type="month" name="mois" value="{{ request('mois') }}"
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <div>
        <label class="block text-xs text-gray-500 mb-1">Immeuble</label>
        <select name="immeuble_id"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Tous</option>
            @foreach($immeubles as $imm)
                <option value="{{ $imm->id }}" {{ request('immeuble_id') == $imm->id ? 'selected' : '' }}>
                    {{ $imm->nom }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-xs text-gray-500 mb-1">Catégorie</label>
        <select name="categorie"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Toutes</option>
            @foreach(['nettoyage','réparation','gardien','électricité','autre'] as $cat)
                <option value="{{ $cat }}" {{ request('categorie') == $cat ? 'selected' : '' }}>
                    {{ ucfirst($cat) }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
        <i class="fas fa-filter mr-1"></i> Filtrer
    </button>
    <a href="{{ route('depenses.index') }}"
       class="text-gray-400 hover:text-gray-600 text-sm py-2">Réinitialiser</a>
</form>

{{-- Header --}}
<div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-semibold text-gray-700">
        Liste des dépenses
        <span class="text-sm font-normal text-gray-400">({{ $depenses->total() }} au total)</span>
    </h3>
    <a href="{{ route('depenses.create') }}"
       class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
        <i class="fas fa-plus"></i> Ajouter une dépense
    </a>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Date</th>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Immeuble</th>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Catégorie</th>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Description</th>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Montant</th>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($depenses as $depense)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-gray-600">{{ $depense->date->format('d/m/Y') }}</td>
                <td class="px-6 py-4 font-semibold text-gray-800">{{ $depense->immeuble->nom }}</td>
                <td class="px-6 py-4">
                    @php
                        $colors = [
                            'nettoyage'   => 'bg-blue-100 text-blue-700',
                            'réparation'  => 'bg-red-100 text-red-700',
                            'gardien'     => 'bg-green-100 text-green-700',
                            'électricité' => 'bg-yellow-100 text-yellow-700',
                            'autre'       => 'bg-gray-100 text-gray-700',
                        ];
                        $icons = [
                            'nettoyage'   => '🧹',
                            'réparation'  => '🔧',
                            'gardien'     => '👮',
                            'électricité' => '⚡',
                            'autre'       => '📦',
                        ];
                    @endphp
                    <span class="{{ $colors[$depense->categorie] ?? 'bg-gray-100 text-gray-700' }} px-2 py-1 rounded-full text-xs font-semibold">
                        {{ $icons[$depense->categorie] ?? '' }} {{ ucfirst($depense->categorie) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-500">{{ $depense->description ?? '—' }}</td>
                <td class="px-6 py-4 font-semibold text-orange-600">
                    {{ number_format($depense->montant, 2) }} MAD
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('depenses.show', $depense) }}"
                           class="text-blue-500 hover:text-blue-700" title="Voir">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('depenses.edit', $depense) }}"
                           class="text-yellow-500 hover:text-yellow-700" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('depenses.destroy', $depense) }}" method="POST"
                              onsubmit="return confirm('Supprimer cette dépense ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                    <i class="fas fa-receipt text-4xl mb-2 block"></i>
                    Aucune dépense trouvée.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t">
        {{ $depenses->links() }}
    </div>
</div>

@endsection