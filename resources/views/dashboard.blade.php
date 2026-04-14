@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Accueil / Dashboard')

@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">
        <p class="text-gray-500 text-sm">Immeubles</p>
        <p class="text-3xl font-bold text-blue-600">{{ $totalImmeubles }}</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">
        <p class="text-gray-500 text-sm">Appartements occupés</p>
        <p class="text-3xl font-bold text-green-600">{{ $totalOccupes }} / {{ $totalAppartements }}</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">
        <p class="text-gray-500 text-sm">Charges ce mois</p>
        <p class="text-3xl font-bold text-yellow-600">{{ number_format($totalCharges, 2) }} MAD</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-purple-500">
        <p class="text-gray-500 text-sm">Paiements encaissés</p>
        <p class="text-3xl font-bold text-purple-600">{{ number_format($totalPaiements, 2) }} MAD</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-red-500">
        <p class="text-gray-500 text-sm">Impayés ce mois</p>
        <p class="text-3xl font-bold text-red-600">{{ number_format($totalImpayes, 2) }} MAD</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-orange-500">
        <p class="text-gray-500 text-sm">Dépenses ce mois</p>
        <p class="text-3xl font-bold text-orange-600">{{ number_format($totalDepenses, 2) }} MAD</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6 border-l-4 {{ $solde >= 0 ? 'border-green-500' : 'border-red-500' }} col-span-2">
        <p class="text-gray-500 text-sm">Solde disponible</p>
        <p class="text-3xl font-bold {{ $solde >= 0 ? 'text-green-600' : 'text-red-600' }}">
            {{ number_format($solde, 2) }} MAD
        </p>
    </div>

</div>

{{-- Tables --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Derniers Paiements --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">
            <i class="fas fa-money-bill-wave text-green-500 mr-2"></i>Derniers paiements
        </h3>

        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-3 py-2 text-gray-500">Occupant</th>
                    <th class="text-left px-3 py-2 text-gray-500">Appart.</th>
                    <th class="text-left px-3 py-2 text-gray-500">Montant</th>
                    <th class="text-left px-3 py-2 text-gray-500">Date</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($derniersPaiements as $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-2">{{ $p->occupant->nom ?? '—' }}</td>
                    <td class="px-3 py-2">{{ $p->charge->appartement->numero ?? '—' }}</td>
                    <td class="px-3 py-2 font-semibold text-green-600">
                        {{ number_format($p->montant, 2) }} MAD
                    </td>
                    <td class="px-3 py-2 text-gray-400">
                        {{ $p->date_paiement->format('d/m/Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-3 py-4 text-center text-gray-400">
                        Aucun paiement ce mois
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Charges en retard --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">
            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>Impayés en retard
        </h3>

        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-3 py-2 text-gray-500">Appartement</th>
                    <th class="text-left px-3 py-2 text-gray-500">Mois</th>
                    <th class="text-left px-3 py-2 text-gray-500">Montant</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($chargesEnRetard as $c)
                <tr class="hover:bg-red-50">
                    <td class="px-3 py-2">{{ $c->appartement->numero ?? '—' }}</td>
                    <td class="px-3 py-2">
                        {{ $c->mois ? $c->mois->format('m/Y') : '—' }}
                    </td>
                    <td class="px-3 py-2 font-semibold text-red-600">
                        {{ number_format($c->montant, 2) }} MAD
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-3 py-4 text-center text-gray-400">
                        <i class="fas fa-check-circle text-green-400"></i>
                        Aucun retard 
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection