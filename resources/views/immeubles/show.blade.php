@extends('layouts.app')
@section('title', $immeuble->nom)
@section('breadcrumb', 'Accueil / Immeubles / ' . $immeuble->nom)

@section('content')

<div class="bg-white rounded-xl shadow p-6 mb-6">
    <div class="flex justify-between items-start">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $immeuble->nom }}</h3>
            <p class="text-gray-500 mt-1"><i class="fas fa-map-marker-alt mr-1"></i>{{ $immeuble->adresse }}</p>
        </div>
        <a href="{{ route('immeubles.edit', $immeuble) }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-edit mr-1"></i> Modifier
        </a>
    </div>
    <div class="grid grid-cols-3 gap-4 mt-6">
        <div class="bg-blue-50 rounded-lg p-4 text-center">
            <p class="text-2xl font-bold text-blue-600">{{ $immeuble->nb_etages ?? '—' }}</p>
            <p class="text-sm text-gray-500">Étages</p>
        </div>
        <div class="bg-green-50 rounded-lg p-4 text-center">
            <p class="text-2xl font-bold text-green-600">{{ $appartements->where('statut', 'occupé')->count() }}</p>
            <p class="text-sm text-gray-500">Occupés</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4 text-center">
            <p class="text-2xl font-bold text-gray-600">{{ $appartements->where('statut', 'vacant')->count() }}</p>
            <p class="text-sm text-gray-500">Vacants</p>
        </div>
    </div>
</div>

{{-- Liste des appartements --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b flex justify-between items-center">
        <h4 class="font-semibold text-gray-700">Appartements de cet immeuble</h4>
        <a href="{{ route('appartements.create') }}?immeuble_id={{ $immeuble->id }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm">
            <i class="fas fa-plus mr-1"></i> Ajouter
        </a>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-3 text-gray-500">Numéro</th>
                <th class="text-left px-6 py-3 text-gray-500">Étage</th>
                <th class="text-left px-6 py-3 text-gray-500">Superficie</th>
                <th class="text-left px-6 py-3 text-gray-500">Statut</th>
                <th class="text-left px-6 py-3 text-gray-500">Occupant</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($appartements as $appart)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 font-semibold">{{ $appart->numero }}</td>
                <td class="px-6 py-3">{{ $appart->etage ?? '—' }}</td>
                <td class="px-6 py-3">{{ $appart->superficie ? $appart->superficie . ' m²' : '—' }}</td>
                <td class="px-6 py-3">
                    @if($appart->statut === 'occupé')
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">● Occupé</span>
                    @else
                        <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded-full text-xs font-semibold">○ Vacant</span>
                    @endif
                </td>
                <td class="px-6 py-3 text-gray-600">
                    {{ $appart->occupants->first()->nom ?? '—' }}
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-6 text-center text-gray-400">Aucun appartement dans cet immeuble.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection