<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Door instructeur gebruikte voertuigen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-7xl mx-auto">
        <a href="{{ route('instructeurs.overzicht') }}" class="text-blue-600 hover:underline mb-4 inline-block">
            ← Terug naar instructeurs
        </a>

        <h1 class="text-3xl font-bold mb-6">
            Door instructeur gebruikte voertuigen van {{ $instructeur->volledige_naam }}
        </h1>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left">Kenteken</th>
                        <th class="px-6 py-3 text-left">Type</th>
                        <th class="px-6 py-3 text-left">Bouwjaar</th>
                        <th class="px-6 py-3 text-left">Brandstof</th>
                        <th class="px-6 py-3 text-left">Rijbewijscategorie</th>
                        <th class="px-6 py-3 text-left">Toegewezen</th>
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
                        <td class="px-6 py-4 text-center">
                            @php
                                $isActief = $voertuig->actieveToewijzing && 
                                           $voertuig->actieveToewijzing->InstructeurId == $instructeur->Id;
                            @endphp
                            @if($isActief)
                                <i class="fas fa-check-circle text-green-500 text-2xl" title="Toegewezen"></i>
                            @elseif($voertuig->wasToegewezenAan($instructeur->Id))
                                <form action="{{ route('voertuig.terug-toewijzen', $voertuig->Id) }}" 
                                      method="POST" 
                                      class="inline-block">
                                    @csrf
                                    <input type="hidden" name="instructeur_id" value="{{ $instructeur->Id }}">
                                    <button type="submit" 
                                            class="text-red-500 hover:text-red-700 text-2xl"
                                            title="Klik om terug toe te wijzen">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('voertuig.wijzigen', $voertuig->Id) }}" 
                                   class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 inline-block text-sm">
                                    <i class="fas fa-edit"></i> Wijzigen
                                </a>
                                @if($voertuig->actieveToewijzing && $voertuig->actieveToewijzing->InstructeurId == $instructeur->Id)
                                <form action="{{ route('voertuig.verwijder', $voertuig->Id) }}" 
                                      method="POST" 
                                      class="inline-block"
                                      onsubmit="return confirm('Weet u zeker dat u dit voertuig wilt verwijderen?');">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="instructeur_id" value="{{ $instructeur->Id }}">
                                    <input type="hidden" name="context" value="instructeur">
                                    <button type="submit" 
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                                        <i class="fas fa-trash"></i> Verwijderen
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Geen voertuigen toegewezen.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $voertuigen->links() }}
        </div>

        <div class="mt-4">
            <a href="{{ route('voertuigen.beschikbaar', $instructeur->Id) }}" 
               class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 inline-block">
                <i class="fas fa-plus"></i> Toevoegen Voertuig
            </a>
        </div>
    </div>
</body>
</html>