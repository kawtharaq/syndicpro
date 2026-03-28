@extends('layouts.app')

@section('title', 'Charges')
@section('breadcrumb', 'Accueil / Charges')

@section('content')

<h2>Générer les charges du mois</h2>

<form method="POST" action="{{ route('charges.generer') }}"
      onsubmit="return confirm('Générer les charges pour tous les appartements occupés ?')">
    @csrf

    <div>
        <label>Mois *</label>
        <input type="month" name="mois" value="{{ date('Y-m') }}">
    </div>

    <div>
        <label>Montant par appartement *</label>
        <input type="number" name="montant" min="0" step="0.01">
    </div>

    <div>
        <label>Description</label>
        <input type="text" name="description">
    </div>

    <button type="submit">Générer</button>
</form>

<hr>

<h3>Statistiques</h3>
<p>Total charges : {{ number_format($totalCharges, 2) }} MAD</p>
<p>Total payées : {{ number_format($totalPayees, 2) }} MAD</p>
<p>Total impayées : {{ number_format($totalImpayes, 2) }} MAD</p>

<hr>

<h3>Filtres</h3>

<form method="GET" action="{{ route('charges.index') }}">
    <div>
        <label>Mois</label>
        <input type="month" name="mois" value="{{ request('mois') }}">
    </div>

    <div>
        <label>Statut</label>
        <select name="statut">
            <option value="">Tous</option>
            <option value="payée" {{ request('statut') == 'payée' ? 'selected' : '' }}>Payée</option>
            <option value="impayée" {{ request('statut') == 'impayée' ? 'selected' : '' }}>Impayée</option>
            <option value="en retard" {{ request('statut') == 'en retard' ? 'selected' : '' }}>En retard</option>
        </select>
    </div>

    <button type="submit">Filtrer</button>
    <a href="{{ route('charges.index') }}">Réinitialiser</a>
</form>

<hr>

<h3>Liste des charges ({{ $charges->total() }})</h3>

<a href="{{ route('charges.create') }}">Ajouter une charge</a>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>Appartement</th>
            <th>Immeuble</th>
            <th>Mois</th>
            <th>Montant</th>
            <th>Description</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($charges as $charge)
        <tr>
            <td>{{ $charge->appartement->numero }}</td>
            <td>{{ $charge->appartement->immeuble->nom }}</td>
            <td>{{ $charge->mois->format('m/Y') }}</td>
            <td>{{ number_format($charge->montant, 2) }} MAD</td>
            <td>{{ $charge->description ?? '—' }}</td>
            <td>{{ $charge->statut }}</td>
            <td>
                <a href="{{ route('charges.show', $charge) }}">Voir</a> |
                <a href="{{ route('charges.edit', $charge) }}">Modifier</a> |

                @if($charge->statut !== 'payée')
                    <a href="{{ route('paiements.create') }}?charge_id={{ $charge->id }}">
                        Paiement
                    </a> |
                @endif

                <form action="{{ route('charges.destroy', $charge) }}" method="POST" style="display:inline"
                      onsubmit="return confirm('Supprimer cette charge ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">Aucune charge trouvée</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div>
    {{ $charges->links() }}
</div>

@endsection