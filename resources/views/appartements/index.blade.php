@extends('layouts.app')

@section('title', 'Appartements')
@section('breadcrumb', 'Accueil / Appartements')

@section('content')

<form method="GET" action="{{ route('appartements.index') }}">
    <div>
        <label>Immeuble</label>
        <select name="immeuble_id">
            <option value="">Tous les immeubles</option>
            @foreach($immeubles as $imm)
                <option value="{{ $imm->id }}" {{ request('immeuble_id') == $imm->id ? 'selected' : '' }}>
                    {{ $imm->nom }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Statut</label>
        <select name="statut">
            <option value="">Tous</option>
            <option value="occupé" {{ request('statut') == 'occupé' ? 'selected' : '' }}>Occupé</option>
            <option value="vacant" {{ request('statut') == 'vacant' ? 'selected' : '' }}>Vacant</option>
        </select>
    </div>

    <button type="submit">Filtrer</button>
    <a href="{{ route('appartements.index') }}">Réinitialiser</a>
</form>

<hr>

<h3>
    Liste des appartements ({{ $appartements->total() }} au total)
</h3>

<a href="{{ route('appartements.create') }}">Ajouter un appartement</a>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Numéro</th>
            <th>Immeuble</th>
            <th>Étage</th>
            <th>Superficie</th>
            <th>Statut</th>
            <th>Occupant</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($appartements as $appart)
        <tr>
            <td>{{ $appart->numero }}</td>
            <td>{{ $appart->immeuble->nom }}</td>
            <td>{{ $appart->etage ?? '—' }}</td>
            <td>{{ $appart->superficie ? $appart->superficie . ' m²' : '—' }}</td>
            <td>{{ $appart->statut }}</td>
            <td>{{ $appart->occupants->first()->nom ?? '—' }}</td>
            <td>
                <a href="{{ route('appartements.show', $appart) }}">Voir</a>
                <a href="{{ route('appartements.edit', $appart) }}">Modifier</a>
                <form action="{{ route('appartements.destroy', $appart) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">Aucun appartement trouvé.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div>
    {{ $appartements->links() }}
</div>

@endsection