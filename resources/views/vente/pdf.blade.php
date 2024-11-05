<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .header {
            text-align: center;
        }
        .content {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .total {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Optic house</h1>
        <h3>Facture #{{ $vente->id }}</h3>
        <p>Date de la vente : {{ $vente->date_vente->format('d/m/Y') }}</p>
    </div>

    <div class="content">
        <h4>Informations sur le client</h4>
        <p>
            Nom : {{ $vente->client->nom }} {{ $vente->client->prenom }}<br>
            Téléphone : {{ $vente->client->telephone }}<br>
            Email : {{ $vente->client->email }}<br/>
            Adresse : {{ $vente->client->adresse }}
        </p>

        <h4>Détails de la vente</h4>
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $vente->produit->name }}</td>
                    <td>{{ number_format($vente->produit->price, 2) }} FCFA</td>
                    <td>{{ $vente->quantite }}</td>
                    <td>{{ number_format($vente->produit->price * $vente->quantite, 2) }} FCFA</td>
                </tr>
            </tbody>
        </table>

        <h3 class="total">Montant total : {{ number_format($vente->produit->price * $vente->quantite, 2) }} FCFA</h3>
    </div>
</body>

</html>
