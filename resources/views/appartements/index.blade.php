@extends('layouts.app')
@section('title', 'Appartements')
@section('breadcrumb', 'Accueil / Appartements')

@section('content')

<form method="GET" action="{{ route('appartements.index') }}" id="filtreForm"
      class="bg-white rounded-xl shadow p-4 mb-6 flex flex-wrap gap-4 items-end">

    {{-- Ville --}}
    <div>
        <label class="block text-xs text-gray-500 mb-1">Ville</label>
        <select name="ville" id="filtreVille"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Toutes les villes</option>
            @foreach($villes as $ville)
                <option value="{{ $ville }}" {{ request('ville') == $ville ? 'selected' : '' }}>
                    {{ $ville }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Immeuble (filtré par ville via JS) --}}
    <div>
        <label class="block text-xs text-gray-500 mb-1">Immeuble</label>
        <select name="immeuble_id" id="filtreImmeuble"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Tous les immeubles</option>
            @foreach($immeubles as $imm)
                <option value="{{ $imm->id }}"
                        data-ville="{{ $imm->ville }}"
                        {{ request('immeuble_id') == $imm->id ? 'selected' : '' }}>
                    {{ $imm->nom }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Étage --}}
    <div>
        <label class="block text-xs text-gray-500 mb-1">Étage</label>
        <select name="etage"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Tous les étages</option>
            @foreach($etages as $etage)
                <option value="{{ $etage }}" {{ request('etage') == $etage ? 'selected' : '' }}>
                    Étage {{ $etage }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Statut --}}
    <div>
        <label class="block text-xs text-gray-500 mb-1">Statut</label>
        <select name="statut"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Tous</option>
            <option value="occupé" {{ request('statut') == 'occupé' ? 'selected' : '' }}>● Occupé</option>
            <option value="vacant" {{ request('statut') == 'vacant' ? 'selected' : '' }}>○ Vacant</option>
        </select>
    </div>

    {{-- Charges --}}
    <div>
        <label class="block text-xs text-gray-500 mb-1">Charges</label>
        <select name="charges_payees"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Toutes</option>
            <option value="1" {{ request('charges_payees') === '1' ? 'selected' : '' }}>✓ Payées</option>
            <option value="0" {{ request('charges_payees') === '0' ? 'selected' : '' }}>✗ Impayées</option>
        </select>
    </div>

    <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
        <i class="fas fa-filter mr-1"></i> Filtrer
    </button>
    <a href="{{ route('appartements.index') }}"
       class="text-gray-400 hover:text-gray-600 text-sm py-2">Réinitialiser</a>
</form>

<div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-semibold text-gray-700">
        Liste des appartements
        <span class="text-sm font-normal text-gray-400">({{ $appartements->total() }} au total)</span>
    </h3>
    <a href="{{ route('appartements.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
        <i class="fas fa-plus"></i> Ajouter un appartement
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Numéro</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Immeuble</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium col-optional">Ville</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium col-optional">Étage</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium col-optional">Prix charge</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Statut</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Charges</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium col-optional">Occupant</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($appartements as $appart)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-4 font-semibold text-gray-800">{{ $appart->numero }}</td>
                <td class="px-4 py-4 text-gray-600">{{ $appart->immeuble->nom }}</td>
                <td class="px-4 py-4 col-optional">
                    <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded-full text-xs">
                        {{ $appart->immeuble->ville ?? '—' }}
                    </span>
                </td>
                <td class="px-4 py-4 text-gray-600 col-optional">{{ $appart->etage ?? '—' }}</td>
                <td class="px-4 py-4 col-optional">
                    <span class="font-semibold text-gray-700">
                        {{ $appart->prix_charge ? number_format($appart->prix_charge, 2) . ' MAD' : '—' }}
                    </span>
                </td>
                <td class="px-4 py-4">
                    @if($appart->statut === 'occupé')
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">● Occupé</span>
                    @else
                        <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded-full text-xs font-semibold">○ Vacant</span>
                    @endif
                </td>
                <td class="px-4 py-4">
                    @if($appart->charges_payees)
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">✓ Payées</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold">✗ Impayées</span>
                    @endif
                </td>
                <td class="px-4 py-4 text-gray-600 col-optional">{{ $appart->occupants->first()->nom ?? '—' }}</td>
                <td class="px-4 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('appartements.show', $appart) }}"
                           class="text-blue-500 hover:text-blue-700"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('appartements.edit', $appart) }}"
                           class="text-yellow-500 hover:text-yellow-700"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('appartements.destroy', $appart) }}" method="POST"
                              onsubmit="return confirm('Supprimer ?')">
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
                <td colspan="9" class="px-6 py-8 text-center text-gray-400">
                    <i class="fas fa-door-open text-4xl mb-2 block"></i>
                    Aucun appartement trouvé.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t">{{ $appartements->links() }}</div>
</div>

{{-- JavaScript cascade ville → immeuble --}}
<script>
document.getElementById('filtreVille').addEventListener('change', function() {
    const villeSelectionnee = this.value;
    const immeubleSelect   = document.getElementById('filtreImmeuble');
    const options          = immeubleSelect.querySelectorAll('option');

    options.forEach(option => {
        if (option.value === '') return; // garder "Tous les immeubles"
        if (!villeSelectionnee || option.dataset.ville === villeSelectionnee) {
            option.style.display = '';
        } else {
            option.style.display = 'none';
        }
    });

    // Reset immeuble si ville changée
    immeubleSelect.value = '';
});
</script>

@endsection