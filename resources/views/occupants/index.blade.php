@extends('layouts.app')

@section('title', 'Occupants')
@section('breadcrumb', 'Accueil / Occupants')

@section('content')

{{-- Filtres --}}
<form method="GET" action="{{ route('occupants.index') }}">
    <div>
        <label>Recherche</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom de l'occupant...">
    </div>

    <div>
        <label>Type</label>
        <select name="type">
            <option value="">Tous</option>
            <option value="propriétaire" {{ request('type') == 'propriétaire' ? 'selected' : '' }}>Propriétaire</option>
            <option value="locataire" {{ request('type') == 'locataire' ? 'selected' : '' }}>Locataire</option>
        </select>
    </div>

    <button type="submit">Filtrer</button>
    <a href="{{ route('occupants.index') }}">Réinitialiser</a>
</form>

<hr>

{{-- Header --}}
<h3>
    Liste des occupants ({{ $occupants->total() }} au total)
</h3>

<a href="{{ route('occupants.create') }}">Ajouter un occupant</a>

{{-- Table --}}
<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Type</th>
            <th>Appartement</th>
            <th>Immeuble</th>
            <th>Téléphone</th>
            <th>Date d'entrée</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($occupants as $occupant)
        <tr>
            <td>{{ $occupant->nom }}</td>

            <td>{{ $occupant->type }}</td>

            <td>{{ $occupant->appartement->numero }}</td>

            <td>{{ $occupant->appartement->immeuble->nom }}</td>

            <td>{{ $occupant->telephone ?? '—' }}</td>

            <td>
                {{ $occupant->date_entree ? $occupant->date_entree->format('d/m/Y') : '—' }}
            </td>

            <td>
                <a href="{{ route('occupants.show', $occupant) }}">Voir</a>
                <a href="{{ route('occupants.edit', $occupant) }}">Modifier</a>

                <form action="{{ route('occupants.destroy', $occupant) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        onclick="return confirm('Supprimer cet occupant ? L\'appartement sera libéré.')">
                        Supprimer
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">Aucun occupant trouvé.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div>
    {{ $occupants->links() }}
</div>

@endsection