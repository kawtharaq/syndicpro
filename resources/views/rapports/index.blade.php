@extends('layouts.app')
@section('title', 'Rapports PDF')
@section('breadcrumb', 'Accueil / Rapports')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="bg-white rounded-xl shadow p-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-file-pdf text-red-500 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Générer un rapport mensuel</h3>
            <p class="text-gray-500 text-sm mt-2">
                Sélectionnez un mois et un immeuble pour télécharger le rapport financier complet en PDF.
            </p>
        </div>

        <form action="{{ route('rapports.pdf') }}" method="GET" class="space-y-5">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Mois <span class="text-red-500">*</span>
                </label>
                <input type="month" name="mois" value="{{ date('Y-m') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Immeuble <span class="text-red-500">*</span>
                </label>
                <select name="immeuble_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400 text-sm">
                    <option value="">-- Sélectionner un immeuble --</option>
                    @foreach($immeubles as $imm)
                        <option value="{{ $imm->id }}">{{ $imm->nom }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                <i class="fas fa-download"></i> Télécharger le rapport PDF
            </button>

        </form>
    </div>

    {{-- Info --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 mt-6">
        <h4 class="font-semibold text-blue-800 mb-2">
            <i class="fas fa-info-circle mr-2"></i>Ce rapport contient :
        </h4>
        <ul class="text-sm text-blue-700 space-y-1">
            <li>✅ Liste de toutes les charges du mois</li>
            <li>✅ Paiements reçus avec détails</li>
            <li>✅ Liste des impayés</li>
            <li>✅ Dépenses par catégorie</li>
            <li>✅ Solde net du mois</li>
        </ul>
    </div>

</div>

@endsection