@extends('layouts.app')
@section('title', $immeuble->nom)
@section('breadcrumb', 'Accueil / Immeubles / ' . $immeuble->nom)

@section('content')

<div>
    <div>
        <div>
            <h3>{{ $immeuble->nom }}</h3>
            <p>{{ $immeuble->adresse }}</p>
        </div>
        <a href="{{ route('immeubles.edit', $immeuble) }}">
            Modifier
        </a>
    </div>

    <br>

    <div>
        <div>
            <p>{{ $immeuble->nb_etages ?? '—' }}</p>
            <p>Étages</p>
        </div>

        <div>
            <p>{{ $appartements->where('statut', 'occupé')->count() }}</p>
            <p>Occupés</p>
        </div>

        <div>
            <p>{{ $appartements->where('statut', 'vacant')->count() }}</p>
            <p>Vacants</p>
        </div>
    </div>
</div>

<br>

{{-- Liste des appartements --}}
<div>
    <div>
        <h4>Appartements de cet immeuble</h4>
        <a href="{{ route('appartements.create') }}?immeuble_id={{ $immeuble->id }}">
            Ajouter
        </a>
    </div>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Étage</th>
                <th>Superficie</th>
                <th>Statut</th>
                <th>Occupant</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appartements as $appart)
            <tr>
                <td>{{ $appart->numero }}</td>
                <td>{{ $appart->etage ?? '—' }}</td>
                <td>{{ $appart->superficie ? $appart->superficie . ' m²' : '—' }}</td>
                <td>
                    @if($appart->statut === 'occupé')
                        Occupé
                    @else
                        Vacant
                    @endif
                </td>
                <td>
                    {{ $appart->occupants->first()->nom ?? '—' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">
                    Aucun appartement dans cet immeuble.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection