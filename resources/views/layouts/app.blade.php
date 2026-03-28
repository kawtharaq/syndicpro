<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SyndicPro — @yield('title')</title>
</head>
<body>
    <div>
          <aside>

            <div>
               <h1> SyndicPro</h1>
               <p>Gestion de Syndic</p>
            </div>

            <nav>
                <a href="{{ route('dashboard') }}"> Dashboard</a>
                <a href="{{ route('immeubles.index') }}">Immeubles</a>
                <a href="{{ route('appartements.index') }}">Appartements</a>
                <a href="{{ route('occupants.index') }}">Occupants</a>
                <a href="{{ route('charges.index') }}">
                Charges
                @php
                    $impayesCount = \App\Models\Charge::where('statut', 'impayée')->orWhere('statut', 'en retard')->count();
                @endphp
                @if($impayesCount > 0)
                    <span>{{ $impayesCount }}</span>
                @endif
                </a>
                <a href="{{ route('paiements.index') }}"> Paiements </a>
                <a href="{{ route('depenses.index') }}">Dépenses</a>
                <a href="{{ route('rapports.index') }}">Rapports PDF</a>
            </nav>

            <div>
                <p>{{ Auth::user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                @csrf
                   <button>
                      Déconnexion
                   </button>
                 </form>
            </div>

          </aside>

          <main>
             <header>
                 <div>
                    <h2>@yield('title')</h2>
                    <p>@yield('breadcrumb')</p>
                 </div>
                 <span>{{ now()->format('d/m/Y') }}</span>
             </header>
               <div>
                     @if(session('success'))
                    <div>
                    {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div>
                    {{ session('error') }}
                    </div>
                    @endif
               </div>

               <div>
                  @yield('content')
              </div>
                          
          </main>

    </div>

</body>
</html>