<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyndicPro — @yield('title')</title>
    <script src="https://cdn.tailwindcss.com/3.4.1"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        @media (max-width: 768px) {
            .col-optional { display: none; }
        }
        aside {
            min-width: 256px;
        }
        main {
            min-width: 0;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-blue-900 text-white flex flex-col fixed h-full z-10 shrink-0">

        {{-- Logo --}}
        <div class="p-6 border-b border-blue-700">
            <h1 class="text-2xl font-bold tracking-wide">🏢 SyndicPro</h1>
            <p class="text-blue-300 text-xs mt-1">Gestion de Syndic</p>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('dashboard') ? 'bg-blue-700' : '' }}">
                <i class="fas fa-chart-pie w-5"></i> Dashboard
            </a>

            <a href="{{ route('immeubles.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('immeubles.*') ? 'bg-blue-700' : '' }}">
                <i class="fas fa-building w-5"></i> Immeubles
            </a>

            <a href="{{ route('appartements.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('appartements.*') ? 'bg-blue-700' : '' }}">
                <i class="fas fa-door-open w-5"></i> Appartements
            </a>

            <a href="{{ route('occupants.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('occupants.*') ? 'bg-blue-700' : '' }}">
                <i class="fas fa-users w-5"></i> Occupants
            </a>

            <a href="{{ route('charges.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('charges.*') ? 'bg-blue-700' : '' }}">
                <i class="fas fa-file-invoice-dollar w-5"></i> Charges
                @php
                    $impayesCount = \App\Models\Charge::where('statut', 'impayée')->orWhere('statut', 'en retard')->count();
                @endphp
                @if($impayesCount > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-0.5">{{ $impayesCount }}</span>
                @endif
            </a>

            <a href="{{ route('paiements.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('paiements.*') ? 'bg-blue-700' : '' }}">
                <i class="fas fa-money-bill-wave w-5"></i> Paiements
            </a>

            <!-- ✅ HADI ZADNAHA -->
            <a href="{{ route('suivi.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('suivi.*') ? 'bg-blue-700' : '' }}">
                <i class="fas fa-tasks w-5"></i> Suivi paiements
            </a>

            <a href="{{ route('depenses.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('depenses.*') ? 'bg-blue-700' : '' }}">
                <i class="fas fa-receipt w-5"></i> Dépenses
            </a>

            <a href="{{ route('rapports.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('rapports.*') ? 'bg-blue-700' : '' }}">
                <i class="fas fa-file-pdf w-5"></i> Rapports PDF
            </a>

            <a href="{{ route('analytique.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('analytique.*') ? 'bg-blue-700' : '' }}">
                <i class="fas fa-chart-line w-5"></i> Analytique
            </a>
        </nav>

        {{-- User + Logout --}}
        <div class="p-4 border-t border-blue-700">
            <p class="text-sm text-blue-300">{{ Auth::user()->name }}</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="mt-2 text-sm text-red-300 hover:text-red-100 transition">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </form>
        </div>

    </aside>

    {{-- MAIN CONTENT --}}
    <main class="ml-64 flex-1 overflow-y-auto">

        {{-- Header --}}
        <header class="bg-white shadow px-8 py-4 flex items-center justify-between sticky top-0 z-10">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">@yield('title')</h2>
                <p class="text-sm text-gray-400">@yield('breadcrumb')</p>
            </div>
            <span class="text-sm text-gray-500">{{ now()->format('d/m/Y') }}</span>
        </header>

        {{-- Alerts --}}
        <div class="px-8 pt-4">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif
        </div>

        {{-- Page Content --}}
        <div class="px-8 py-4">
            @yield('content')
        </div>

    </main>
</div>

</body>
</html>