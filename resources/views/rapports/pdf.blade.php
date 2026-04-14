<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport — {{ $immeuble->nom }} — {{ $mois->format('m/Y') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }

        .header {
            background: #1e3a5f;
            color: white;
            padding: 20px 30px;
            margin-bottom: 20px;
        }
        .header h1 { font-size: 22px; font-weight: bold; }
        .header p  { font-size: 12px; opacity: 0.8; margin-top: 4px; }
        .header .mois { font-size: 16px; font-weight: bold; float: right; margin-top: -30px; }

        .section { margin: 0 30px 20px 30px; }
        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #1e3a5f;
            border-bottom: 2px solid #1e3a5f;
            padding-bottom: 5px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        table { width: 100%; border-collapse: collapse; font-size: 11px; }
        th {
            background: #f1f5f9;
            padding: 7px 10px;
            text-align: left;
            font-weight: bold;
            color: #555;
            border: 1px solid #e2e8f0;
        }
        td {
            padding: 6px 10px;
            border: 1px solid #e2e8f0;
        }
        tr:nth-child(even) td { background: #f8fafc; }

        .badge-payee    { color: #16a34a; font-weight: bold; }
        .badge-imapyee  { color: #d97706; font-weight: bold; }
        .badge-retard   { color: #dc2626; font-weight: bold; }

        .stats-grid {
            display: table;
            width: 100%;
            margin: 0 30px 20px 30px;
            width: calc(100% - 60px);
        }
        .stat-box {
            display: table-cell;
            width: 20%;
            padding: 12px;
            text-align: center;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
        }
        .stat-box .label { font-size: 10px; color: #888; margin-bottom: 4px; }
        .stat-box .value { font-size: 14px; font-weight: bold; }
        .green  { color: #16a34a; }
        .red    { color: #dc2626; }
        .blue   { color: #2563eb; }
        .orange { color: #ea580c; }

        .footer {
            margin: 30px 30px 0 30px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            font-size: 10px;
            color: #aaa;
            text-align: center;
        }

        .solde-box {
            margin: 0 30px 20px 30px;
            padding: 15px 20px;
            border-radius: 8px;
            text-align: center;
        }
        .solde-positif { background: #dcfce7; border: 2px solid #16a34a; }
        .solde-negatif { background: #fee2e2; border: 2px solid #dc2626; }
        .solde-box .solde-label { font-size: 12px; color: #555; }
        .solde-box .solde-value { font-size: 22px; font-weight: bold; margin-top: 4px; }
    </style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    <h1>🏢 SyndicPro — Rapport Mensuel</h1>
    <p>{{ $immeuble->nom }} • {{ $immeuble->adresse }}</p>
    <div class="mois">{{ $mois->format('F Y') }}</div>
</div>

{{-- STATS RÉSUMÉ --}}
<div class="stats-grid">
    <div class="stat-box">
        <div class="label">Total charges</div>
        <div class="value blue">{{ number_format($totalCharges, 2) }} MAD</div>
    </div>
    <div class="stat-box">
        <div class="label">Paiements reçus</div>
        <div class="value green">{{ number_format($totalPaiements, 2) }} MAD</div>
    </div>
    <div class="stat-box">
        <div class="label">Impayés</div>
        <div class="value red">{{ number_format($totalImpayes, 2) }} MAD</div>
    </div>
    <div class="stat-box">
        <div class="label">Dépenses</div>
        <div class="value orange">{{ number_format($totalDepenses, 2) }} MAD</div>
    </div>
    <div class="stat-box">
        <div class="label">Solde net</div>
        <div class="value {{ $soldeNet >= 0 ? 'green' : 'red' }}">
            {{ number_format($soldeNet, 2) }} MAD
        </div>
    </div>
</div>

{{-- CHARGES --}}
<div class="section">
    <div class="section-title">📋 Charges du mois</div>
    <table>
        <thead>
            <tr>
                <th>Appartement</th>
                <th>Description</th>
                <th>Montant</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($charges as $charge)
            <tr>
                <td>Appart. {{ $charge->appartement->numero }}</td>
                <td>{{ $charge->description ?? 'Charges communes' }}</td>
                <td>{{ number_format($charge->montant, 2) }} MAD</td>
                <td>
                    @if($charge->statut === 'payée')
                        <span class="badge-payee">✓ Payée</span>
                    @elseif($charge->statut === 'en retard')
                        <span class="badge-retard">⚠ En retard</span>
                    @else
                        <span class="badge-imapyee">⏳ Impayée</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center; color:#aaa;">Aucune charge ce mois</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- PAIEMENTS --}}
<div class="section">
    <div class="section-title">💳 Paiements reçus</div>
    <table>
        <thead>
            <tr>
                <th>Occupant</th>
                <th>Appartement</th>
                <th>Date</th>
                <th>Mode</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            @forelse($paiements as $paiement)
            <tr>
                <td>{{ $paiement->occupant->nom }}</td>
                <td>Appart. {{ $paiement->charge->appartement->numero }}</td>
                <td>{{ $paiement->date_paiement->format('d/m/Y') }}</td>
                <td>{{ ucfirst($paiement->mode ?? '—') }}</td>
                <td class="badge-payee">{{ number_format($paiement->montant, 2) }} MAD</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center; color:#aaa;">Aucun paiement ce mois</td></tr>
            @endforelse
            @if($paiements->count() > 0)
            <tr>
                <td colspan="4" style="font-weight:bold; text-align:right;">Total encaissé :</td>
                <td class="badge-payee" style="font-weight:bold;">{{ number_format($totalPaiements, 2) }} MAD</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

{{-- DÉPENSES --}}
<div class="section">
    <div class="section-title">📤 Dépenses du mois</div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Catégorie</th>
                <th>Description</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            @forelse($depenses as $depense)
            <tr>
                <td>{{ $depense->date->format('d/m/Y') }}</td>
                <td>{{ ucfirst($depense->categorie) }}</td>
                <td>{{ $depense->description ?? '—' }}</td>
                <td class="red">{{ number_format($depense->montant, 2) }} MAD</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center; color:#aaa;">Aucune dépense ce mois</td></tr>
            @endforelse
            @if($depenses->count() > 0)
            <tr>
                <td colspan="3" style="font-weight:bold; text-align:right;">Total dépenses :</td>
                <td class="red" style="font-weight:bold;">{{ number_format($totalDepenses, 2) }} MAD</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

{{-- SOLDE NET --}}
<div class="solde-box {{ $soldeNet >= 0 ? 'solde-positif' : 'solde-negatif' }}">
    <div class="solde-label">Solde net du mois (Paiements — Dépenses)</div>
    <div class="solde-value {{ $soldeNet >= 0 ? 'green' : 'red' }}">
        {{ $soldeNet >= 0 ? '+' : '' }}{{ number_format($soldeNet, 2) }} MAD
    </div>
</div>

{{-- FOOTER --}}
<div class="footer">
    Rapport généré le {{ now()->format('d/m/Y à H:i') }} — SyndicPro by SUPREMEIT
</div>

</body>
</html>