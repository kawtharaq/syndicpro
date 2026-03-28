<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport — {{ $immeuble->nom }} — {{ $mois->format('m/Y') }}</title>
</head>

<body>

<h2>Rapport Financier Mensuel</h2>

<p>
    Immeuble : {{ $immeuble->nom }}<br>
    Adresse : {{ $immeuble->adresse }}<br>
    Période : {{ $mois->format('F Y') }}<br>
    Généré le : {{ now()->format('d/m/Y H:i') }}
</p>

<hr>

<h3>Résumé</h3>

<p>Total Charges : {{ number_format($totalCharges, 2) }} MAD</p>
<p>Total Encaissé : {{ number_format($totalPaiements, 2) }} MAD</p>
<p>Total Impayés : {{ number_format($totalImpayes, 2) }} MAD</p>
<p>Total Dépenses : {{ number_format($totalDepenses, 2) }} MAD</p>
<p>
    Solde Net :
    {{ number_format($soldeNet, 2) }} MAD
</p>

<hr>

<h3>Charges</h3>

@if($charges->count())
<table border="1" width="100%" cellpadding="5">
    <tr>
        <th>Appartement</th>
        <th>Description</th>
        <th>Montant</th>
        <th>Payé</th>
        <th>Reste</th>
        <th>Statut</th>
    </tr>

    @foreach($charges as $charge)
        @php
            $paye = $charge->paiements->sum('montant');
            $reste = $charge->montant - $paye;
        @endphp

        <tr>
            <td>{{ $charge->appartement->numero }}</td>
            <td>{{ $charge->description }}</td>
            <td>{{ $charge->montant }}</td>
            <td>{{ $paye }}</td>
            <td>{{ $reste }}</td>
            <td>{{ $charge->statut }}</td>
        </tr>
    @endforeach
</table>
@else
<p>Aucune charge.</p>
@endif

<hr>

<h3>Paiements</h3>

@if($paiements->count())
<table border="1" width="100%" cellpadding="5">
    <tr>
        <th>Occupant</th>
        <th>Appartement</th>
        <th>Date</th>
        <th>Montant</th>
    </tr>

    @foreach($paiements as $p)
        <tr>
            <td>{{ $p->occupant->nom }}</td>
            <td>{{ $p->charge->appartement->numero }}</td>
            <td>{{ $p->date_paiement->format('d/m/Y') }}</td>
            <td>{{ $p->montant }}</td>
        </tr>
    @endforeach
</table>
@else
<p>Aucun paiement.</p>
@endif

<hr>

<h3>Dépenses</h3>

@if($depenses->count())
<table border="1" width="100%" cellpadding="5">
    <tr>
        <th>Date</th>
        <th>Catégorie</th>
        <th>Description</th>
        <th>Montant</th>
    </tr>

    @foreach($depenses as $d)
        <tr>
            <td>{{ $d->date->format('d/m/Y') }}</td>
            <td>{{ $d->categorie }}</td>
            <td>{{ $d->description }}</td>
            <td>{{ $d->montant }}</td>
        </tr>
    @endforeach
</table>
@else
<p>Aucune dépense.</p>
@endif

<hr>

<h3>Solde Net</h3>
<p><strong>{{ $soldeNet }} MAD</strong></p>

<br>

<p>Rapport généré automatiquement - SyndicPro</p>

</body>
</html>