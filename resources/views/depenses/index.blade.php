@extends('layouts.app')
@section('title', 'Dépenses')
@section('breadcrumb', 'Accueil / Dépenses')

@section('content')

<h3>Statistiques</h3>

<p>Total dépenses (filtre actuel) : {{ number_format($totalDepenses, 2) }} MAD</p>

@foreach($parCategorie as $cat)
    <p>
        {{ ucfirst($cat->categorie) }} : {{ number_format($cat->total, 2) }} MAD
    </p>
@endforeach

<hr>

<h3>Filtres</h3>

<form method="GET" action="{{ route('depenses.index') }}">

    <label>Mois</label>
    <input type="month" name="mois" value="{{ request('mois') }}">

    <label>Immeuble</label>
    <select name="immeuble_id">
        <option value="">Tous</option>
        @foreach($immeubles as $imm)
            <option value="{{ $imm->id }}" {{ request('immeuble_id') == $imm->id ? 'selected' : '' }}>
                {{ $imm->nom }}
            </option>
        @endforeach
    </select>

    <label>Catégorie</label>
    <select name="categorie">
        <option value="">Toutes</option>
        @foreach(['nettoyage','réparation','gardien','électricité','autre'] as $cat)
            <option value="{{ $cat }}" {{ request('categorie') == $cat ? 'selected' : '' }}>
                {{ ucfirst($cat) }}
            </option>
        @endforeach
    </select>

    <button type="submit">Filtrer</button>
    <a href="{{ route('depenses.index') }}">Réinitialiser</a>

</form>

<hr>

<h3>
    Liste des dépenses ({{ $depenses->total() }} au total)
</h3>

<a href="{{ route('depenses.create') }}">Ajouter une dépense</a>

<hr>

<table border="1" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>Date</th>
            <th>Immeuble</th>
            <th>Catégorie</th>
            <th>Description</th>
            <th>Montant</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($depenses as $depense)
        <tr>
            <td>{{ $depense->date->format('d/m/Y') }}</td>
            <td>{{ $depense->immeuble->nom }}</td>

            <td>
                {{ ucfirst($depense->categorie) }}
            </td>

            <td>{{ $depense->description ?? '—' }}</td>

            <td>{{ number_format($depense->montant, 2) }} MAD</td>

            <td>
                <a href="{{ route('depenses.show', $depense) }}">Voir</a> |
                <a href="{{ route('depenses.edit', $depense) }}">Modifier</a> |

                <form action="{{ route('depenses.destroy', $depense) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Supprimer cette dépense ?')">
                        Supprimer
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">Aucune dépense trouvée.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div>
    {{ $depenses->links() }}
</div>

@endsection