<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alle beschikbare voertuigen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto">
        <a href="{{ route('voertuigen.instructeur', $instructeur->id) }}" class="text-blue-600 hover:underline mb-4 inline-block">
            ← Terug naar voertuigen van {{ $instructeur->volledige_naam }}
        </a>

        <h1 class="text-3xl font-bold mb-6">Alle beschikbare voertuigen</h1>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left">Kenteken</th>
                        <th class="px-6 py-3 text-left">Type</th>
                        <th class="px-6 py-3 text-left">Bouwjaar</th>
                        <th class="px-6 py-3 text-left">Brandstof</th>
                        <th class="px-6 py-3 text-left">Rijbewijscategorie</th>
                        <th class="px-6 py-3 text-left">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($voertuigen as $voertuig)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $voertuig->Kenteken }}</td>
                        <td class="px-6 py-4">{{ $voertuig->Type }}</td>
                        <td class="px-6 py-4">{{ date('d-m-Y', strtotime($voertuig->Bouwjaar)) }}</td>
                        <td class="px-6 py-4">{{ $voertuig->Brandstof }}</td>
                        <td class="px-6 py-4">{{ $voertuig->Rijbewijscategorie }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('voertuig.wijzigen', ['id' => $voertuig->id, 'instructeur_id' => $instructeur->id]) }}" 
                               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 inline-block">
                                Wijzigen
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Geen beschikbare voertuigen.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $voertuigen->links() }}
        </div>
    </div>
</body>
</html>