@extends('layouts.app')
@section('title', 'Paiements')

@section('content')

<div class="grid grid-cols-2 gap-4 mb-6">
    <div class="bg-white p-4 rounded shadow">
        <p>Total encaissé</p>
        <p class="text-green-600 font-bold text-xl">
            {{ number_format($totalEncaisse, 2) }} MAD
        </p>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p>Nombre paiements</p>
        <p class="text-blue-600 font-bold text-xl">
            {{ $paiements->total() }}
        </p>
    </div>
</div>

<a href="{{ route('paiements.create') }}"
   class="bg-green-600 text-white px-4 py-2 rounded">
   Nouveau paiement
</a>

<table class="w-full mt-4 bg-white shadow rounded">
    <thead>
        <tr>
            <th>Occupant</th>
            <th>Appartement</th>
            <th>Montant</th>
            <th>Date</th>
        </tr>
    </thead>

    <tbody>
        @foreach($paiements as $p)
        <tr>
            <td>{{ $p->occupant->nom }}</td>
            <td>{{ $p->charge->appartement->numero }}</td>
            <td>{{ $p->montant }}</td>
            <td>{{ $p->date_paiement }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $paiements->links() }}

@endsection