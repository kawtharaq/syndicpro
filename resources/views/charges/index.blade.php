@extends('layouts.app')
@section('title', 'Charges')
@section('breadcrumb', 'Accueil / Charges')

@section('content')

<div class="bg-blue-50 border border-blue-200 rounded-xl p-5 mb-6">
    <h4 class="font-semibold text-blue-800 mb-3">
        <i class="fas fa-magic mr-2"></i>Générer les charges du mois
    </h4>
    <form method="POST" action="{{ route('charges.generer') }}"
          class="flex flex-wrap gap-4 items-end"
          onsubmit="return confirm('Générer les charges pour tous les appartements occupés ?')">
        @csrf
        <div>
            <label class="block text-xs text-blue-700 mb-1">Mois</label>
            <input type="month" name="mois" value="{{ date('Y-m') }}"
                   class="border border-blue-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <div>
            <label class="block text-xs text-blue-700 mb-1">Montant par appart. (MAD)</label>
            <input type="number" name="montant" placeholder="Ex: 300" min="0" step="0.01"
                   class="border border-blue-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <div>
            <label class="block text-xs text-blue-700 mb-1">Description</label>
            <input type="text" name="description" placeholder="Ex: Charges communes"
                   class="border border-blue-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm transition">
            <i class="fas fa-bolt mr-1"></i> Générer
        </button>
    </form>
</div>

<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-yellow-400">
        <p class="text-xs text-gray-400">Total charges</p>
        <p class="text-2xl font-bold text-yellow-600">{{ number_format($totalCharges, 2) }} MAD</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-green-400">
        <p class="text-xs text-gray-400">Total payées</p>
        <p class="text-2xl font-bold text-green-600">{{ number_format($totalPayees, 2) }} MAD</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-red-400">
        <p class="text-xs text-gray-400">Total impayées</p>
        <p class="text-2xl font-bold text-red-600">{{ number_format($totalImpayes, 2) }} MAD</p>
    </div>
</div>

<form method="GET" action="{{ route('charges.index') }}"
      class="bg-white rounded-xl shadow p-4 mb-6 flex flex-wrap gap-4 items-end">
    <div>
        <label class="block text-xs text-gray-500 mb-1">Mois</label>
        <input type="month" name="mois" value="{{ request('mois') }}"
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <div>
        <label class="block text-xs text-gray-500 mb-1">Statut</label>
        <select name="statut"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Tous</option>
            <option value="payée"     {{ request('statut') == 'payée'     ? 'selected' : '' }}>✓ Payée</option>
            <option value="impayée"   {{ request('statut') == 'impayée'   ? 'selected' : '' }}>⏳ Impayée</option>
            <option value="en retard" {{ request('statut') == 'en retard' ? 'selected' : '' }}>⚠ En retard</option>
        </select>
    </div>
    <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
        <i class="fas fa-filter mr-1"></i> Filtrer
    </button>
    <a href="{{ route('charges.index') }}"
       class="text-gray-400 hover:text-gray-600 text-sm py-2">Réinitialiser</a>
</form>

<div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-semibold text-gray-700">
        Liste des charges
        <span class="text-sm font-normal text-gray-400">({{ $charges->total() }} au total)</span>
    </h3>
    <a href="{{ route('charges.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
        <i class="fas fa-plus"></i> Ajouter manuellement
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Appartement</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium col-optional">Immeuble</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Mois</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Montant</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium col-optional">Description</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Statut</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($charges as $charge)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-4 font-semibold text-gray-800">{{ $charge->appartement->numero }}</td>
                <td class="px-4 py-4 text-gray-600 col-optional">{{ $charge->appartement->immeuble->nom }}</td>
                <td class="px-4 py-4 text-gray-600">{{ $charge->mois->format('m/Y') }}</td>
                <td class="px-4 py-4 font-semibold text-gray-800">{{ number_format($charge->montant, 2) }} MAD</td>
                <td class="px-4 py-4 text-gray-500 col-optional">{{ $charge->description ?? '—' }}</td>
                <td class="px-4 py-4">
                    @if($charge->statut === 'payée')
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">✓ Payée</span>
                    @elseif($charge->statut === 'en retard')
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold">⚠ Retard</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold">⏳ Impayée</span>
                    @endif
                </td>
                <td class="px-4 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('charges.show', $charge) }}"
                           class="text-blue-500 hover:text-blue-700"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('charges.edit', $charge) }}"
                           class="text-yellow-500 hover:text-yellow-700"><i class="fas fa-edit"></i></a>
                        @if($charge->statut !== 'payée')
                        <a href="{{ route('paiements.create') }}?charge_id={{ $charge->id }}"
                           class="text-green-500 hover:text-green-700" title="Paiement">
                            <i class="fas fa-check-circle"></i>
                        </a>
                        @endif
                        <form action="{{ route('charges.destroy', $charge) }}" method="POST"
                              onsubmit="return confirm('Supprimer cette charge ?')">
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
                <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                    <i class="fas fa-file-invoice-dollar text-4xl mb-2 block"></i>
                    Aucune charge trouvée.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t">{{ $charges->links() }}</div>
</div>

@endsection