@extends('layouts.app')
@section('title', 'Rapports PDF')
@section('breadcrumb', 'Accueil / Rapports')

@section('content')

<div>

    {{-- Info --}}
    <div>
        <p>Rapport mensuel PDF</p>
        <p>
            Sélectionnez un mois et un immeuble pour générer un rapport financier complet
            incluant les charges, paiements, impayés, dépenses et solde net.
        </p>
    </div>

    {{-- Formulaire --}}
    <div>
        <h3>Générer un rapport</h3>

        <form action="{{ route('rapports.pdf') }}" method="GET">

            <div>
                <label>Mois *</label>
                <input type="month" name="mois" value="{{ date('Y-m') }}">
                @error('mois')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label>Immeuble *</label>
                <select name="immeuble_id">
                    <option value="">-- Sélectionner un immeuble --</option>
                    @foreach($immeubles as $imm)
                        <option value="{{ $imm->id }}">{{ $imm->nom }}</option>
                    @endforeach
                </select>
                @error('immeuble_id')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <button type="submit">
                Télécharger le rapport PDF
            </button>

        </form>
    </div>

    {{-- Historique --}}
    <div>
        <h4>Rapports disponibles par immeuble</h4>

        @foreach($immeubles as $imm)
            <div>
                <p>{{ $imm->nom }}</p>
                <p>{{ $imm->adresse }}</p>

                <a href="{{ route('rapports.pdf') }}?mois={{ date('Y-m') }}&immeuble_id={{ $imm->id }}">
                    Ce mois
                </a>
            </div>
        @endforeach

    </div>

</div>

@endsection