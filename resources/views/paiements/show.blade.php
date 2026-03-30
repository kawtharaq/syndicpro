@extends('layouts.app')
@section('title', 'Détail paiement')
@section('breadcrumb', 'Accueil / Paiements / Détail')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">

    <div class="flex justify-between items-start mb-6">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Reçu de paiement</h3>
            <p class="text-gray-400 text-sm mt-1">Enregistré le {{ $paiement->created_at->format('d/m/Y à H:i') }}</p>
        </div>
        <a href="{{ route('paiements.edit', $paiement) }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">
            <i class="fas fa-edit mr-1"></i> Modifier
        </a>
    </div>

    <div class="space-y-4">
        <div class="flex justify-between py-3 border-b">
            <span class="text-gray-500">Occupant</span>
            <span class="font-semibold text-gray-800">{{ $paiement->occupant->nom }}</span>
        </div>
        <div class="flex justify-between py-3 border-b">
            <span class="text-gray-500">Appartement</span>
            <span class="font-semibold text-gray-800">
                {{ $paiement->charge->appartement->numero }} —
                {{ $paiement->charge->appartement->immeuble->nom }}
            </span>
        </div>
        <div class="flex justify-between py-3 border-b">
            <span class="text-gray-500">Mois de la charge</span>
            <span class="font-semibold text-gray-800">{{ $paiement->charge->mois->format('F Y') }}</span>
        </div>
        <div class="flex justify-between py-3 border-b">
            <span class="text-gray-500">Date de paiement</span>
            <span class="font-semibold text-gray-800">{{ $paiement->date_paiement->format('d/m/Y') }}</span>
        </div>
        <div class="flex justify-between py-3 border-b">
            <span class="text-gray-500">Mode</span>
            <span class="font-semibold text-gray-800">{{ ucfirst($paiement->mode ?? '—') }}</span>
        </div>
        <div class="flex justify-between py-4 bg-green-50 rounded-lg px-4">
            <span class="text-gray-600 font-medium">Montant payé</span>
            <span class="text-2xl font-bold text-green-600">
                {{ number_format($paiement->montant, 2) }} MAD
            </span>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('paiements.index') }}"
           class="text-blue-500 hover:text-blue-700 text-sm">
            <i class="fas fa-arrow-left mr-1"></i> Retour à la liste
        </a>
    </div>
</div>

@endsection