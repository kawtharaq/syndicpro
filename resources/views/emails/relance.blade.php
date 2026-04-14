<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container {
            max-width: 600px; margin: auto;
            background: white; border-radius: 10px;
            overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header { background: #1e3a5f; color: white; padding: 30px; text-align: center; }
        .header h1 { font-size: 22px; margin: 0; }
        .body { padding: 30px; color: #333; line-height: 1.7; }
        .montant {
            background: #fee2e2; border: 2px solid #dc2626;
            border-radius: 8px; padding: 15px 20px;
            text-align: center; margin: 20px 0;
        }
        .montant .label { font-size: 12px; color: #888; }
        .montant .value { font-size: 28px; font-weight: bold; color: #dc2626; }
        .footer { background: #f8fafc; padding: 20px; text-align: center; font-size: 11px; color: #aaa; }
        .btn {
            display: inline-block; background: #1e3a5f; color: white;
            padding: 12px 25px; border-radius: 6px; text-decoration: none;
            font-weight: bold; margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🏢 SyndicPro</h1>
        <p style="margin:5px 0 0; opacity:0.8;">Rappel de paiement</p>
    </div>
    <div class="body">
        <p>Bonjour <strong>{{ $occupant->nom }}</strong>,</p>

        <p>
            Nous vous contactons concernant une charge impayée pour votre appartement
            <strong>{{ $occupant->appartement->numero }}</strong>
            à <strong>{{ $occupant->appartement->immeuble->nom }}</strong>.
        </p>

        <div class="montant">
            <div class="label">Montant dû pour {{ $charge->mois->format('F Y') }}</div>
            <div class="value">{{ number_format($charge->montant, 2) }} MAD</div>
        </div>

        <p>
            Nous vous prions de bien vouloir régulariser votre situation dans les
            plus brefs délais afin d'éviter tout désagrément.
        </p>

        <p>Pour toute question, n'hésitez pas à nous contacter.</p>

        <p>Cordialement,<br><strong>L'équipe SyndicPro</strong></p>
    </div>
    <div class="footer">
        Cet email a été envoyé automatiquement par SyndicPro — SUPREMEIT
    </div>
</div>
</body>
</html>