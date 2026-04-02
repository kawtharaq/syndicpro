@extends('layouts.app')
@section('title', 'Immeubles')
@section('breadcrumb', 'Accueil / Immeubles')

@section('content')

<form method="GET" action="{{ route('immeubles.index') }}"
      class="bg-white rounded-xl shadow p-4 mb-6 flex flex-wrap gap-4 items-end">
    <div>
        <label class="block text-xs text-gray-500 mb-1">Ville</label>
        <input type="text" name="ville" value="{{ request('ville') }}"
               list="villes-list"
               placeholder="Ex: Oujda..."
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        <datalist id="villes-list">
            @foreach($villes as $v)
                <option value="{{ $v }}">
            @endforeach
        </datalist>
    </div>
    <div>
        <label class="block text-xs text-gray-500 mb-1">Immeuble</label>
        <input type="text" name="nom_immeuble" value="{{ request('nom_immeuble') }}"
               list="immeubles-list"
               placeholder="Ex: Résidence Al Amal..."
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        <datalist id="immeubles-list">
            @foreach($tousImmeubles as $imm)
                <option value="{{ $imm->nom }}">
            @endforeach
        </datalist>
    </div>
    <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
        <i class="fas fa-filter mr-1"></i> Filtrer
    </button>
    <a href="{{ route('immeubles.index') }}"
       class="text-gray-400 hover:text-gray-600 text-sm py-2">Réinitialiser</a>
</form>

<div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-semibold text-gray-700">
        Liste des immeubles
        <span class="text-sm font-normal text-gray-400">({{ $immeubles->total() }} au total)</span>
    </h3>
    <a href="{{ route('immeubles.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
        <i class="fas fa-plus"></i> Ajouter un immeuble
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">#</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Nom</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Ville</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium col-optional">Adresse</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium col-optional">Étages</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Apparts</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium col-optional">Ajouté le</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($immeubles as $immeuble)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-4 text-gray-400">{{ $immeuble->id }}</td>
                <td class="px-4 py-4 font-semibold text-gray-800">{{ $immeuble->nom }}</td>
                <td class="px-4 py-4">
                    <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded-full text-xs font-semibold">
                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $immeuble->ville ?? '—' }}
                    </span>
                </td>
                <td class="px-4 py-4 text-gray-600 col-optional">{{ $immeuble->adresse }}</td>
                <td class="px-4 py-4 text-gray-600 col-optional">{{ $immeuble->nb_etages ?? '—' }}</td>
                <td class="px-4 py-4">
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-semibold">
                        {{ $immeuble->appartements_count }} appart.
                    </span>
                </td>
                <td class="px-4 py-4 text-gray-400 col-optional">
                    {{ $immeuble->created_at->format('d/m/Y') }}
                </td>
                <td class="px-4 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('immeubles.show', $immeuble) }}"
                           class="text-blue-500 hover:text-blue-700"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('immeubles.edit', $immeuble) }}"
                           class="text-yellow-500 hover:text-yellow-700"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('immeubles.destroy', $immeuble) }}" method="POST"
                              onsubmit="return confirm('Supprimer cet immeuble ?')">
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
                    <i class="fas fa-building text-4xl mb-2 block"></i>
                    Aucun immeuble trouvé.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t">{{ $immeubles->links() }}</div>
</div>

@endsection