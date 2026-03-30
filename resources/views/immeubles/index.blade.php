@extends('layouts.app')
@section('title', 'Immeubles')
@section('breadcrumb', 'Accueil / Immeubles')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Liste des immeubles</h3>
    <a href="{{ route('immeubles.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
        <i class="fas fa-plus"></i> Ajouter un immeuble
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">#</th>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Nom</th>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Adresse</th>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Étages</th>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Appartements</th>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Ajouté le</th>
                <th class="text-left px-6 py-3 text-gray-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($immeubles as $immeuble)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-gray-400">{{ $immeuble->id }}</td>
                <td class="px-6 py-4 font-semibold text-gray-800">{{ $immeuble->nom }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $immeuble->adresse }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $immeuble->nb_etages ?? '—' }}</td>
                <td class="px-6 py-4">
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-semibold">
                        {{ $immeuble->appartements_count }} appart.
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-400">{{ $immeuble->created_at->format('d/m/Y') }}</td>
                <td class="px-6 py-4 flex items-center gap-2">
                    <a href="{{ route('immeubles.show', $immeuble) }}"
                       class="text-blue-500 hover:text-blue-700" title="Voir">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('immeubles.edit', $immeuble) }}"
                       class="text-yellow-500 hover:text-yellow-700" title="Modifier">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('immeubles.destroy', $immeuble) }}" method="POST"
                          onsubmit="return confirm('Supprimer cet immeuble ? Tous les appartements seront supprimés.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                    <i class="fas fa-building text-4xl mb-2 block"></i>
                    Aucun immeuble ajouté pour l'instant.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="px-6 py-4 border-t">
        {{ $immeubles->links() }}
    </div>
</div>

@endsection