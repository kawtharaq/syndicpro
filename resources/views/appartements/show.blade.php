@extends('layouts.app')

@section('title', 'Appartement ' . $appartement->numero)
@section('breadcrumb', 'Accueil / Appartements / ' . $appartement->numero)

@section('content')

{{-- Info --}}
<div>
    <h3>Appartement {{ $appartement->numero }}</h3>

    <p>
        {{ $appartement->immeuble->nom }}
        —
        {{ $appartement->etage !== null ? 'Étage ' . $appartement->etage : 'RDC' }}
    </p>

    <p>
        Statut :
        {{ $appartement->statut }}
    </p>

    <a href="{{ route('appartements.edit', $appartement) }}">
        Modifier
    </a>

    <div>
        <p>Superficie : {{ $appartement->superficie ? $appartement->superficie . ' m²' : '—' }}</p>
        <p>Charges payées : {{ $appartement->charges->where('statut', 'payée')->count() }}</p>
        <p>Charges impayées : {{ $appartement->charges->where('statut', '!=', 'payée')->count() }}</p>
    </div>
</div>

<hr>

{{-- Occupant --}}
<div>
    <h4>Occupant actuel</h4>

    <a href="{{ route('occupants.create') }}?appartement_id={{ $appartement->id }}">
        Ajouter occupant
    </a>

    @if($appartement->occupants->first())
        @php $occ = $appartement->occupants->first(); @endphp

        <div>
            <p><strong>{{ $occ->nom }}</strong></p>
            <p>
                {{ ucfirst($occ->type) }}
                - {{ $occ->telephone ?? '—' }}
                - {{ $occ->email ?? '—' }}
            </p>
            <p>
                Depuis :
                {{ $occ->date_entree ? $occ->date_entree->format('d/m/Y') : '—' }}
            </p>
        </div>
    @else
        <p>Aucun occupant.</p>
    @endif
</div>

<hr>

{{-- Charges --}}
<div>
    <h4>Historique des charges</h4>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Mois</th>
                <th>Montant</th>
                <th>Description</th>
                <th>Statut</th>
            </tr>
        </thead>

        <tbody>
            @forelse($appartement->charges->sortByDesc('mois') as $charge)
            <tr>
                <td>{{ $charge->mois->format('m/Y') }}</td>
                <td>{{ number_format($charge->montant, 2) }} MAD</td>
                <td>{{ $charge->description ?? '—' }}</td>
                <td>{{ $charge->statut }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Aucune charge enregistrée.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection