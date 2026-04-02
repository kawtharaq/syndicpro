@extends('layouts.app')
@section('title', 'Analytique')
@section('breadcrumb', 'Accueil / Analytique')

@section('content')

{{-- KPI Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-500">
        <p class="text-xs text-gray-400">Total Immeubles</p>
        <p class="text-3xl font-bold text-blue-600">{{ $parVille->sum('nb_immeubles') }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-500">
        <p class="text-xs text-gray-400">Taux d'occupation</p>
        <p class="text-3xl font-bold text-green-600">{{ $tauxOccupation }}%</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-yellow-500">
        <p class="text-xs text-gray-400">Apparts occupés</p>
        <p class="text-3xl font-bold text-yellow-600">{{ $totalOccupes }} / {{ $totalApparts }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-gray-400">
        <p class="text-xs text-gray-400">Apparts vacants</p>
        <p class="text-3xl font-bold text-gray-600">{{ $totalVacants }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- Graphique paiements par mois --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold text-gray-700 mb-4">
            <i class="fas fa-chart-bar text-green-500 mr-2"></i>Paiements — 6 derniers mois
        </h4>
        <canvas id="chartPaiements" height="200"></canvas>
    </div>

    {{-- Revenus vs Dépenses --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold text-gray-700 mb-4">
            <i class="fas fa-chart-line text-blue-500 mr-2"></i>Revenus vs Dépenses
        </h4>
        <canvas id="chartRevenus" height="200"></canvas>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Stats par ville --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold text-gray-700 mb-4">
            <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>Immeubles par ville
        </h4>
        <div class="space-y-3">
            @forelse($parVille as $v)
            <div class="flex justify-between items-center">
                <span class="text-gray-600">{{ $v->ville }}</span>
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $v->nb_immeubles }} immeuble(s)
                </span>
            </div>
            @empty
            <p class="text-gray-400 text-sm">Aucune ville enregistrée.</p>
            @endforelse
        </div>
    </div>

    {{-- Dépenses par catégorie --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold text-gray-700 mb-4">
            <i class="fas fa-receipt text-orange-500 mr-2"></i>Dépenses par catégorie
        </h4>
        <canvas id="chartDepenses" height="220"></canvas>
    </div>

    {{-- Top impayés --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold text-gray-700 mb-4">
            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>Top impayés par immeuble
        </h4>
        <div class="space-y-3">
            @forelse($topImpayes as $imm)
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-semibold text-gray-700 text-sm">{{ $imm->nom }}</p>
                    <p class="text-xs text-gray-400">{{ $imm->ville ?? '' }}</p>
                </div>
                <span class="{{ $imm->nb_impayes > 0 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }} px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $imm->nb_impayes }} impayé(s)
                </span>
            </div>
            @empty
            <p class="text-gray-400 text-sm text-center">
                <i class="fas fa-check-circle text-green-400"></i> Aucun impayé !
            </p>
            @endforelse
        </div>
    </div>

</div>

{{-- Tableau Revenus vs Dépenses --}}
<div class="bg-white rounded-xl shadow overflow-x-auto">
    <div class="px-6 py-4 border-b">
        <h4 class="font-semibold text-gray-700">
            <i class="fas fa-table text-gray-500 mr-2"></i>Détail mensuel — Revenus vs Dépenses
        </h4>
    </div>
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-3 text-gray-500">Mois</th>
                <th class="text-left px-6 py-3 text-gray-500">Revenus</th>
                <th class="text-left px-6 py-3 text-gray-500">Dépenses</th>
                <th class="text-left px-6 py-3 text-gray-500">Solde</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($revenusVsDepenses as $row)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 font-semibold text-gray-700">{{ $row['mois'] }}</td>
                <td class="px-6 py-3 text-green-600 font-semibold">{{ number_format($row['revenus'], 2) }} MAD</td>
                <td class="px-6 py-3 text-red-600 font-semibold">{{ number_format($row['depenses'], 2) }} MAD</td>
                <td class="px-6 py-3 font-bold {{ $row['solde'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $row['solde'] >= 0 ? '+' : '' }}{{ number_format($row['solde'], 2) }} MAD
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Paiements par mois
    new Chart(document.getElementById('chartPaiements'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($paiementsParMois->pluck('mois')) !!},
            datasets: [{
                label: 'Paiements (MAD)',
                data: {!! json_encode($paiementsParMois->pluck('total')) !!},
                backgroundColor: 'rgba(34,197,94,0.7)',
                borderRadius: 6,
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    // Revenus vs Dépenses
    new Chart(document.getElementById('chartRevenus'), {
        type: 'line',
        data: {
            labels: {!! json_encode($revenusVsDepenses->pluck('mois')) !!},
            datasets: [
                {
                    label: 'Revenus',
                    data: {!! json_encode($revenusVsDepenses->pluck('revenus')) !!},
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34,197,94,0.1)',
                    tension: 0.4, fill: true,
                },
                {
                    label: 'Dépenses',
                    data: {!! json_encode($revenusVsDepenses->pluck('depenses')) !!},
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239,68,68,0.1)',
                    tension: 0.4, fill: true,
                }
            ]
        },
        options: { responsive: true }
    });

    // Dépenses par catégorie
    new Chart(document.getElementById('chartDepenses'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($depensesParCategorie->pluck('categorie')) !!},
            datasets: [{
                data: {!! json_encode($depensesParCategorie->pluck('total')) !!},
                backgroundColor: ['#3b82f6','#ef4444','#22c55e','#f59e0b','#8b5cf6'],
            }]
        },
        options: { responsive: true }
    });
</script>

@endsection