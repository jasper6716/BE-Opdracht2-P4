<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructeurs in dienst</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Instructeurs in dienst</h1>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left">Naam</th>
                        <th class="px-6 py-3 text-left">Mobiel</th>
                        <th class="px-6 py-3 text-left">Datum in dienst</th>
                        <th class="px-6 py-3 text-left">Aantal sterren</th>
                        <th class="px-6 py-3 text-left">Voertuigen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($instructeurs as $instructeur)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $instructeur->volledige_naam }}</td>
                        <td class="px-6 py-4">{{ $instructeur->Mobiel }}</td>
                        <td class="px-6 py-4">{{ date('d-m-Y', strtotime($instructeur->DatumInDienst)) }}</td>
                        <td class="px-6 py-4">{{ $instructeur->AantalSterren }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('voertuigen.instructeur', $instructeur->id) }}" 
                               class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 inline-block">
                                Voertuigen
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>