@extends('layouts.app')
@section('title', 'Paiements')
@section('breadcrumb', 'Accueil / Paiements')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-400">
        <p class="text-xs text-gray-400">Total encaissé (filtre actuel)</p>
        <p class="text-2xl font-bold text-green-600">{{ number_format($totalEncaisse, 2) }} MAD</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-400">
        <p class="text-xs text-gray-400">Nombre de paiements</p>
        <p class="text-2xl font-bold text-blue-600">{{ $paiements->total() }}</p>
    </div>
</div>

{{-- Filtres --}}
<form method="GET" action="{{ route('paiements.index') }}"
      class="bg-white rounded-xl shadow p-4 mb-6 flex flex-wrap gap-4 items-end">
    <div>
        <label class="block text-xs text-gray-500 mb-1">Mois</label>
        <input type="month" name="mois" value="{{ request('mois') }}"
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <div>
        <label class="block text-xs text-gray-500 mb-1">Recherche occupant</label>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Nom de l'occupant..."
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
        <i class="fas fa-filter mr-1"></i> Filtrer
    </button>
    <a href="{{ route('paiements.index') }}"
       class="text-gray-400 hover:text-gray-600 text-sm py-2">Réinitialiser</a>
</form>

{{-- Header --}}
<div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-semibold text-gray-700">
        Historique des paiements
        <span class="text-sm font-normal text-gray-400">({{ $paiements->total() }} au total)</span>
    </h3>
    <a href="{{ route('paiements.create') }}"
       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
        <i class="fas fa-plus"></i> Enregistrer un paiement
    </a>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Occupant</th>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Appartement</th>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Immeuble</th>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Mois charge</th>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Montant</th>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Mode</th>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Date</th>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($paiements as $paiement)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-semibold text-gray-800">{{ $paiement->occupant->nom }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $paiement->charge->appartement->numero }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $paiement->charge->appartement->immeuble->nom }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $paiement->charge->mois->format('m/Y') }}</td>
                <td class="px-6 py-4 font-semibold text-green-600">
                    {{ number_format($paiement->montant, 2) }} MAD
                </td>
                <td class="px-6 py-4">
                    @if($paiement->mode)
                        <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">
                            {{ ucfirst($paiement->mode) }}
                        </span>
                    @else
                        <span class="text-gray-400">—</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-gray-500">
                    {{ $paiement->date_paiement->format('d/m/Y') }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('paiements.show', $paiement) }}"
                           class="text-blue-500 hover:text-blue-700" title="Voir">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('paiements.edit', $paiement) }}"
                           class="text-yellow-500 hover:text-yellow-700" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('paiements.destroy', $paiement) }}" method="POST"
                              onsubmit="return confirm('Supprimer ce paiement ?')">
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
                <td colspan="8" class="px-6 py-8 text-center text-gray-400">
                    <i class="fas fa-money-bill-wave text-4xl mb-2 block"></i>
                    Aucun paiement trouvé.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t">
        {{ $paiements->links() }}
    </div>
</div>

@endsection