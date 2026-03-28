@extends('layouts.app')
@section('title', 'Paiements')
@section('breadcrumb', 'Accueil / Paiements')

@section('content')

<h3>Statistiques</h3>

<p>Total encaissé (filtre actuel) : {{ number_format($totalEncaisse, 2) }} MAD</p>
<p>Nombre de paiements : {{ $paiements->total() }}</p>

<hr>

<h3>Filtres</h3>

<form method="GET" action="{{ route('paiements.index') }}">
    <label>Mois</label>
    <input type="month" name="mois" value="{{ request('mois') }}">

    <label>Recherche occupant</label>
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom de l'occupant...">

    <button type="submit">Filtrer</button>

    <a href="{{ route('paiements.index') }}">Réinitialiser</a>
</form>

<hr>

<h3>
    Historique des paiements
    ({{ $paiements->total() }} au total)
</h3>

<a href="{{ route('paiements.create') }}">Enregistrer un paiement</a>

<hr>

<table border="1" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>Occupant</th>
            <th>Appartement</th>
            <th>Immeuble</th>
            <th>Mois charge</th>
            <th>Montant</th>
            <th>Mode</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($paiements as $paiement)
        <tr>
            <td>{{ $paiement->occupant->nom }}</td>
            <td>{{ $paiement->charge->appartement->numero }}</td>
            <td>{{ $paiement->charge->appartement->immeuble->nom }}</td>
            <td>{{ $paiement->charge->mois->format('m/Y') }}</td>
            <td>{{ number_format($paiement->montant, 2) }} MAD</td>
            <td>
                @if($paiement->mode)
                    {{ ucfirst($paiement->mode) }}
                @else
                    -
                @endif
            </td>
            <td>{{ $paiement->date_paiement->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('paiements.show', $paiement) }}">Voir</a> |
                <a href="{{ route('paiements.edit', $paiement) }}">Modifier</a> |

                <form action="{{ route('paiements.destroy', $paiement) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Supprimer ce paiement ?')">
                        Supprimer
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8">Aucun paiement trouvé.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div>
    {{ $paiements->links() }}
</div>

@endsection