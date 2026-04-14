@extends('layouts.app')
@section('title', 'Ajouter paiement')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 shadow rounded">

<form method="POST" action="{{ route('paiements.store') }}">
@csrf

<label>Charge</label>
<select name="charge_id" class="w-full border p-2">
    @foreach($charges as $c)
        <option value="{{ $c->id }}">
            {{ $c->appartement->numero }} - {{ $c->mois->format('m/Y') }}
        </option>
    @endforeach
</select>

<label class="mt-2">Occupant</label>
<select name="occupant_id" class="w-full border p-2">
    @foreach($occupants as $o)
        <option value="{{ $o->id }}">{{ $o->nom }}</option>
    @endforeach
</select>

<label class="mt-2">Montant</label>
<input type="number" name="montant" class="w-full border p-2">

<label class="mt-2">Date</label>
<input type="date" name="date_paiement" class="w-full border p-2">

<label class="mt-2">Mode</label>
<select name="mode" class="w-full border p-2">
    <option value="espèces">Espèces</option>
    <option value="virement">Virement</option>
    <option value="chèque">Chèque</option>
</select>

<button class="bg-green-600 text-white px-4 py-2 mt-4">
    Enregistrer
</button>

</form>

</div>

@endsection