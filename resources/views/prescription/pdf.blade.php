<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <title>Prescription</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333;
        }

        .prescription-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 40px;
            border: 1px solid #000;
            border-radius: 10px;
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .header-left {
            text-align: left;
        }

        .header-right {
            text-align: right;
        }

        .header-left p,
        .header-right p {
            margin: 5px 0;
            font-size: 14px;
        }

        .logo {
            width: 100px;
            height: auto;
        }

        .section-title {
            font-weight: bold;
            margin-top: 20px;
            text-transform: uppercase;
        }

        .info {
            margin: 15px 0;
        }

        .info p {
            margin: 5px 0;
        }

        .notes-section {
            margin-top: 20px;
        }

        .footer {
            text-align: right;
            margin-top: 30px;
            font-size: 12px;
            color: #000;
        }

        .signature {
            text-align: right;
            margin-top: 50px;
        }

        .signature p {
            font-size: 14px;
            margin-bottom: 0;
        }

        th {
            font-size: 12px;
            padding: 5px;
            font-weight: 600;
            color: #333
        }

        td {
            padding: 5px;
            font-size: 12px;
            border: 1px solid gray
        }

        .title1 {
            font-size: 24px;
            height: 60px;
            width: 80px;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            background:rgb(58, 135, 250);
            font-weight: 600;
        }

        .title2 {
            font-size: 24px;
            height: 60px;
            width: 100%;
            display: flex;
            padding: 10px;
            align-items: center;
            font-weight: 600;
            border-top: 5px solid rgb(58, 135, 250);
            border-right: 5px solid rgb(58, 135, 250);
        }

        h5 {
            text-align: left
        }
    </style>
</head>

<body>

    <div class="prescription-container">
        <div class="header">
                <h1 style="color: rgb(0, 68, 255)">Optic House</h1>
            <div class="header-left">
                
                <h4>Opticien</h4>
                <p>{{ $prescription->opticien->nom }} {{ $prescription->opticien->prenom }}</p>
                <p>{{ $prescription->opticien->email }}</p>
                <p>{{ $prescription->opticien->telephone }}</p>
            </div>
            <div class="header-right">
                <p style="margin-top: 10px">Date de rédaction : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                <p>{{ $prescription->client->nom }} {{ $prescription->client->prenom }}</p>
                <p>{{ $prescription->client->adresse }}</p>
                <p>{{ $prescription->client->telephone }}</p>
            </div>
        </div>

        <h3 style="text-align: center">Prescription Médicale</h3>
        <div class="info">
            <p style="margin-top: 10px; font-weight:500"><span>Date de l'examen :</span>
                {{ $prescription->date_examen }}</p>
            <p><span>Sphère OD :</span> {{ $prescription->spherique_od }}</p>
            <p><span>Sphère OG :</span> {{ $prescription->spherique_og }}</p>
            <p><span>Distance Pupillaire :</span> {{ $prescription->distance_pupillaire }} mm</p>
        </div>

        <div class="notes-section">
            <p class="section-title">Notes :</p>
            <p>{{ $prescription->notes }}</p>
        </div>

        <div class="footer">
            <p>Prescription émise le {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        </div>

        <div class="signature">
            <p>Signature du médecin</p>
        </div>
    </div>

</body>

</html>
