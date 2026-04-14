@extends('layouts.app')
@section('title', 'Détail charge')
@section('breadcrumb', 'Accueil / Charges / Détail')

@section('content')

<div class="bg-white rounded-xl shadow p-6 mb-6">
    <div class="flex justify-between items-start">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">
                Charge — Appart. {{ $charge->appartement->numero }}
            </h3>
            <p class="text-gray-500 mt-1">
                {{ $charge->appartement->immeuble->nom }} •
                {{ $charge->mois->format('F Y') }}
            </p>
        </div>
        <div class="flex gap-2 items-center">
            @if($charge->statut === 'payée')
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">✓ Payée</span>
            @elseif($charge->statut === 'en retard')
                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">⚠ En retard</span>
            @else
                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">⏳ Impayée</span>
            @endif
            <a href="{{ route('charges.edit', $charge) }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-1.5 rounded-lg text-sm">
                <i class="fas fa-edit mr-1"></i> Modifier
            </a>
            @if($charge->statut !== 'payée')
            <a href="{{ route('paiements.create') }}?charge_id={{ $charge->id }}"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded-lg text-sm">
                <i class="fas fa-check mr-1"></i> Enregistrer paiement
            </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 mt-6">
        <div class="bg-yellow-50 rounded-lg p-4 text-center">
            <p class="text-2xl font-bold text-yellow-600">{{ number_format($charge->montant, 2) }} MAD</p>
            <p class="text-sm text-gray-500">Montant total</p>
        </div>
        <div class="bg-green-50 rounded-lg p-4 text-center">
            <p class="text-2xl font-bold text-green-600">
                {{ number_format($charge->paiements->sum('montant'), 2) }} MAD
            </p>
            <p class="text-sm text-gray-500">Montant payé</p>
        </div>
        <div class="bg-red-50 rounded-lg p-4 text-center">
            <p class="text-2xl font-bold text-red-600">
                {{ number_format($charge->montant - $charge->paiements->sum('montant'), 2) }} MAD
            </p>
            <p class="text-sm text-gray-500">Reste à payer</p>
        </div>
    </div>
</div>

{{-- Paiements liés --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h4 class="font-semibold text-gray-700">
            <i class="fas fa-money-bill-wave mr-2 text-green-500"></i>Paiements enregistrés
        </h4>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-3 text-gray-500">Occupant</th>
                <th class="text-left px-6 py-3 text-gray-500">Date</th>
                <th class="text-left px-6 py-3 text-gray-500">Montant</th>
                <th class="text-left px-6 py-3 text-gray-500">Mode</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($charge->paiements as $paiement)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 font-semibold">{{ $paiement->occupant->nom }}</td>
                <td class="px-6 py-3">{{ $paiement->date_paiement->format('d/m/Y') }}</td>
                <td class="px-6 py-3 text-green-600 font-semibold">{{ number_format($paiement->montant, 2) }} MAD</td>
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