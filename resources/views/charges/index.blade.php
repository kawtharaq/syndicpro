@extends('layouts.app')
@section('title', 'Charges')
@section('breadcrumb', 'Accueil / Charges')

@section('content')

{{-- Génération automatique --}}
<div class="bg-blue-50 border border-blue-200 rounded-xl p-5 mb-6">
    <h4 class="font-semibold text-blue-800 mb-3">
        <i class="fas fa-magic mr-2"></i>Générer les charges du mois
    </h4>

    <form method="POST" action="{{ route('charges.generer') }}"
          class="flex flex-wrap gap-4 items-end"
          onsubmit="return confirm('Générer les charges pour tous les appartements occupés ?')">
        @csrf

        <div>
            <label class="block text-xs text-blue-700 mb-1">Mois *</label>
            <input type="month" name="mois" value="{{ date('Y-m') }}"
                   class="border border-blue-300 rounded-lg px-3 py-2 text-sm">
        </div>

        <div>
            <label class="block text-xs text-blue-700 mb-1">Montant *</label>
            <input type="number" name="montant" min="0" step="0.01"
                   class="border border-blue-300 rounded-lg px-3 py-2 text-sm">
        </div>

        <div>
            <label class="block text-xs text-blue-700 mb-1">Description</label>
            <input type="text" name="description"
                   class="border border-blue-300 rounded-lg px-3 py-2 text-sm">
        </div>

        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm">
            Générer
        </button>
    </form>
</div>

{{-- Stats --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-yellow-400">
        <p class="text-xs text-gray-400">Total charges</p>
        <p class="text-2xl font-bold text-yellow-600">{{ number_format($totalCharges, 2) }} MAD</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-green-400">
        <p class="text-xs text-gray-400">Payées</p>
        <p class="text-2xl font-bold text-green-600">{{ number_format($totalPayees, 2) }} MAD</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-red-400">
        <p class="text-xs text-gray-400">Impayées</p>
        <p class="text-2xl font-bold text-red-600">{{ number_format($totalImpayes, 2) }} MAD</p>
    </div>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
        <tr>
            <th class="px-6 py-3 text-left">Appartement</th>
            <th class="px-6 py-3 text-left">Immeuble</th>
            <th class="px-6 py-3 text-left">Mois</th>
            <th class="px-6 py-3 text-left">Montant</th>
            <th class="px-6 py-3 text-left">Statut</th>
            <th class="px-6 py-3 text-left">Actions</th>
        </tr>
        </thead>

        <tbody>
        @foreach($charges as $charge)
            <tr class="border-t hover:bg-gray-50">

                <td class="px-6 py-4">{{ $charge->appartement->numero }}</td>
                <td class="px-6 py-4">{{ $charge->appartement->immeuble->nom }}</td>
                <td class="px-6 py-4">{{ $charge->mois->format('m/Y') }}</td>
                <td class="px-6 py-4">{{ number_format($charge->montant, 2) }} MAD</td>

                <td class="px-6 py-4">
                    @if($charge->statut === 'payée')
                        <span class="text-green-600 font-semibold">Payée</span>
                    @elseif($charge->statut === 'en retard')
                        <span class="text-red-600 font-semibold">En retard</span>
                    @else
                        <span class="text-yellow-600 font-semibold">Impayée</span>
                    @endif
                </td>

                {{-- ACTIONS --}}
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">

                        <a href="{{ route('charges.show', $charge) }}"
                           class="text-blue-500">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('charges.edit', $charge) }}"
                           class="text-yellow-500">
                            <i class="fas fa-edit"></i>
                        </a>

                        {{-- 💚 bouton paiement --}}
                        @if($charge->statut !== 'payée')
                            <a href="{{ route('paiements.create') }}?charge_id={{ $charge->id }}"
                               class="text-green-500">
                                <i class="fas fa-check-circle"></i>
                            </a>
                        @endif

                        {{-- 📧 bouton relance email --}}
                        @if($charge->statut !== 'payée')
                            @php
                                $occupant = $charge->appartement->occupants->first();
                            @endphp

                            @if($occupant && $occupant->email)
                                <form action="{{ route('charges.relance', $charge) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="text-purple-600 hover:text-purple-800"
                                            title="Envoyer relance email">
                                        <i class="fas fa-envelope"></i>
                                    </button>
                                </form>
                            @endif
                        @endif

                        {{-- delete --}}
                        <form action="{{ route('charges.destroy', $charge) }}"
                              method="POST"
                              onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                    </div>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="p-4">
        {{ $charges->links() }}
    </div>
</div>

@endsection