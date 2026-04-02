@extends('layouts.app')
@section('title', 'Appartement ' . $appartement->numero)
@section('breadcrumb', 'Accueil / Appartements / ' . $appartement->numero)

@section('content')

{{-- Info Card --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <div class="flex justify-between items-start">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Appartement {{ $appartement->numero }}</h3>
            <p class="text-gray-500 mt-1">{{ $appartement->immeuble->nom }} —
                {{ $appartement->etage !== null ? 'Étage ' . $appartement->etage : 'RDC' }}
            </p>
        </div>
        <div class="flex gap-2">
            @if($appartement->statut === 'occupé')
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">● Occupé</span>
            @else
                <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-sm font-semibold">○ Vacant</span>
            @endif
            <a href="{{ route('appartements.edit', $appartement) }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-1.5 rounded-lg text-sm">
                <i class="fas fa-edit mr-1"></i> Modifier
            </a>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 mt-6">
        <div class="bg-blue-50 rounded-lg p-4 text-center">
            <p class="text-2xl font-bold text-blue-600">{{ $appartement->superficie ? $appartement->superficie . ' m²' : '—' }}</p>
            <p class="text-sm text-gray-500">Superficie</p>
        </div>
        <div class="bg-green-50 rounded-lg p-4 text-center">
            <p class="text-2xl font-bold text-green-600">{{ $appartement->charges->where('statut', 'payée')->count() }}</p>
            <p class="text-sm text-gray-500">Charges payées</p>
        </div>
        <div class="bg-red-50 rounded-lg p-4 text-center">
            <p class="text-2xl font-bold text-red-600">{{ $appartement->charges->where('statut', '!=', 'payée')->count() }}</p>
            <p class="text-sm text-gray-500">Charges impayées</p>
        </div>
    </div>

    {{-- Description --}}
    @if($appartement->description)
    <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <p class="text-xs text-gray-400 mb-1"><i class="fas fa-info-circle mr-1"></i>Description</p>
        <p class="text-gray-700">{{ $appartement->description }}</p>
    </div>
    @endif

    {{-- Prix charge --}}
    @if($appartement->prix_charge)
    <div class="mt-3 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
        <p class="text-xs text-gray-400 mb-1"><i class="fas fa-money-bill mr-1"></i>Prix charge mensuel</p>
        <p class="text-yellow-700 font-bold text-lg">{{ number_format($appartement->prix_charge, 2) }} MAD</p>
    </div>
    @endif

</div>

{{-- Occupant actuel --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h4 class="font-semibold text-gray-700"><i class="fas fa-user mr-2 text-blue-500"></i>Occupant actuel</h4>
        <a href="{{ route('occupants.create') }}?appartement_id={{ $appartement->id }}"
           class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg">
            <i class="fas fa-plus mr-1"></i> Ajouter occupant
        </a>
    </div>
    @if($appartement->occupants->first())
        @php $occ = $appartement->occupants->first(); @endphp
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-blue-500 text-xl"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-800">{{ $occ->nom }}</p>
                <p class="text-sm text-gray-500">{{ ucfirst($occ->type) }} • {{ $occ->telephone ?? '—' }} • {{ $occ->email ?? '—' }}</p>
                <p class="text-xs text-gray-400">Depuis le {{ $occ->date_entree ? $occ->date_entree->format('d/m/Y') : '—' }}</p>
            </div>
        </div>
    @else
        <p class="text-gray-400 text-sm">Aucun occupant pour cet appartement.</p>
    @endif
</div>

{{-- Historique charges --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h4 class="font-semibold text-gray-700">
            <i class="fas fa-file-invoice-dollar mr-2 text-yellow-500"></i>Historique des charges
        </h4>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-3 text-gray-500">Mois</th>
                <th class="text-left px-6 py-3 text-gray-500">Montant</th>
                <th class="text-left px-6 py-3 text-gray-500">Description</th>
                <th class="text-left px-6 py-3 text-gray-500">Statut</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($appartement->charges->sortByDesc('mois') as $charge)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3">{{ $charge->mois->format('m/Y') }}</td>
                <td class="px-6 py-3 font-semibold">{{ number_format($charge->montant, 2) }} MAD</td>
                <td class="px-6 py-3 text-gray-500">{{ $charge->description ?? '—' }}</td>
                <td class="px-6 py-3">
                    @if($charge->statut === 'payée')
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">✓ Payée</span>
                    @elseif($charge->statut === 'en retard')
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold">⚠ En retard</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold">⏳ En attente</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-6 text-center text-gray-400">Aucune charge enregistrée.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection