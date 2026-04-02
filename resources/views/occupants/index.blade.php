@extends('layouts.app')
@section('title', 'Occupants')
@section('breadcrumb', 'Accueil / Occupants')

@section('content')

<form method="GET" action="{{ route('occupants.index') }}"
      class="bg-white rounded-xl shadow p-4 mb-6 flex flex-wrap gap-4 items-end">
    <div>
        <label class="block text-xs text-gray-500 mb-1">Recherche</label>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Nom de l'occupant..."
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <div>
        <label class="block text-xs text-gray-500 mb-1">Type</label>
        <select name="type"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Tous</option>
            <option value="propriétaire" {{ request('type') == 'propriétaire' ? 'selected' : '' }}>Propriétaire</option>
            <option value="locataire"    {{ request('type') == 'locataire'    ? 'selected' : '' }}>Locataire</option>
        </select>
    </div>
    <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
        <i class="fas fa-filter mr-1"></i> Filtrer
    </button>
    <a href="{{ route('occupants.index') }}"
       class="text-gray-400 hover:text-gray-600 text-sm py-2">Réinitialiser</a>
</form>

<div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-semibold text-gray-700">
        Liste des occupants
        <span class="text-sm font-normal text-gray-400">({{ $occupants->total() }} au total)</span>
    </h3>
    <a href="{{ route('occupants.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
        <i class="fas fa-plus"></i> Ajouter un occupant
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Nom</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Type</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Appartement</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium col-optional">Immeuble</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium col-optional">Téléphone</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium col-optional">Date entrée</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($occupants as $occupant)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-4 font-semibold text-gray-800">{{ $occupant->nom }}</td>
                <td class="px-4 py-4">
                    @if($occupant->type === 'propriétaire')
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-semibold">🏠 Proprio</span>
                    @else
                        <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full text-xs font-semibold">🔑 Locataire</span>
                    @endif
                </td>
                <td class="px-4 py-4 text-gray-600">{{ $occupant->appartement->numero }}</td>
                <td class="px-4 py-4 text-gray-600 col-optional">{{ $occupant->appartement->immeuble->nom }}</td>
                <td class="px-4 py-4 text-gray-600 col-optional">{{ $occupant->telephone ?? '—' }}</td>
                <td class="px-4 py-4 text-gray-400 col-optional">
                    {{ $occupant->date_entree ? $occupant->date_entree->format('d/m/Y') : '—' }}
                </td>
                <td class="px-4 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('occupants.show', $occupant) }}"
                           class="text-blue-500 hover:text-blue-700"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('occupants.edit', $occupant) }}"
                           class="text-yellow-500 hover:text-yellow-700"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('occupants.destroy', $occupant) }}" method="POST"
                              onsubmit="return confirm('Supprimer cet occupant ?')">
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
                    <i class="fas fa-users text-4xl mb-2 block"></i>
                    Aucun occupant trouvé.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t">{{ $occupants->links() }}</div>
</div>

@endsection