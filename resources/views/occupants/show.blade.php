@extends('layouts.app')
@section('title', $occupant->nom)
@section('breadcrumb', 'Accueil / Occupants / ' . $occupant->nom)

@section('content')

{{-- Info Card --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <div class="flex justify-between items-start">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-blue-500 text-2xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $occupant->nom }}</h3>
                <p class="text-gray-500">
                    @if($occupant->type === 'propriétaire')
                        <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs font-semibold">🏠 Propriétaire</span>
                    @else
                        <span class="bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full text-xs font-semibold">🔑 Locataire</span>
                    @endif
                </p>
            </div>
        </div>
        <a href="{{ route('occupants.edit', $occupant) }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">
            <i class="fas fa-edit mr-1"></i> Modifier
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-400 mb-1">Appartement</p>
            <p class="font-semibold text-gray-700">{{ $occupant->appartement->numero }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-400 mb-1">Immeuble</p>
            <p class="font-semibold text-gray-700">{{ $occupant->appartement->immeuble->nom }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-400 mb-1">Téléphone</p>
            <p class="font-semibold text-gray-700">{{ $occupant->telephone ?? '—' }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-400 mb-1">Email</p>
            <p class="font-semibold text-gray-700 text-sm">{{ $occupant->email ?? '—' }}</p>
        </div>
    </div>
</div>

{{-- Historique paiements --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h4 class="font-semibold text-gray-700">
            <i class="fas fa-money-bill-wave mr-2 text-green-500"></i>Historique des paiements
        </h4>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-3 text-gray-500">Date</th>
                <th class="text-left px-6 py-3 text-gray-500">Mois charge</th>
                <th class="text-left px-6 py-3 text-gray-500">Montant</th>
                <th class="text-left px-6 py-3 text-gray-500">Mode</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($occupant->paiements->sortByDesc('date_paiement') as $paiement)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3">{{ $paiement->date_paiement->format('d/m/Y') }}</td>
                <td class="px-6 py-3">{{ $paiement->charge->mois->format('m/Y') }}</td>
                <td class="px-6 py-3 font-semibold text-green-600">{{ number_format($paiement->montant, 2) }} MAD</td>
                <td class="px-6 py-3 text-gray-500">{{ $paiement->mode ?? '—' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-6 text-center text-gray-400">Aucun paiement enregistré.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection