@extends('layouts.app')
@section('title', 'Modifier paiement')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 shadow rounded">

<form method="POST" action="{{ route('paiements.update', $paiement) }}">
@csrf
@method('PUT')

<input name="montant" value="{{ $paiement->montant }}" class="w-full border p-2">

<input type="date" name="date_paiement"
       value="{{ $paiement->date_paiement->format('Y-m-d') }}"
       class="w-full border p-2 mt-2">

<button class="bg-yellow-500 text-white px-4 py-2 mt-4">
    Update
</button>

</form>

</div>

@endsection