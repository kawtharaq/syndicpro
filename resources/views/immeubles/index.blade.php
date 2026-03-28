@extends('layouts.app')
@section('title', 'Immeubles')
@section('breadcrumb', 'Accueil / Immeubles')

@section('content')

<div>
    <h3>Liste des immeubles</h3>
    <a href="{{ route('immeubles.create') }}">
        Ajouter un immeuble
    </a>
</div>

<div>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Étages</th>
                <th>Appartements</th>
                <th>Ajouté le</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($immeubles as $immeuble)
            <tr>
                <td>{{ $immeuble->id }}</td>
                <td>{{ $immeuble->nom }}</td>
                <td>{{ $immeuble->adresse }}</td>
                <td>{{ $immeuble->nb_etages ?? '—' }}</td>
                <td>{{ $immeuble->appartements_count }} appart.</td>
                <td>{{ $immeuble->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('immeubles.show', $immeuble) }}">Voir</a>
                    |
                    <a href="{{ route('immeubles.edit', $immeuble) }}">Modifier</a>
                    |
                    <form action="{{ route('immeubles.destroy', $immeuble) }}" method="POST" style="display:inline;"
                          onsubmit="return confirm('Supprimer cet immeuble ? Tous les appartements seront supprimés.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    Aucun immeuble ajouté pour l'instant.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        {{ $immeubles->links() }}
    </div>
</div>

@endsection