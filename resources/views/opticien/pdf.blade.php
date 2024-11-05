<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Opticiens - Optic House</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Optic House - Liste des Opticiens</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($opticiens as $opticien)
                <tr>
                    <td>{{ $opticien->nom }}</td>
                    <td>{{ $opticien->prenom }}</td>
                    <td>{{ $opticien->email }}</td>
                    <td>{{ $opticien->telephone }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
