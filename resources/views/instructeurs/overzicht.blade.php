<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructeurs in dienst</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Instructeurs in dienst</h1>

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
                        <th class="px-6 py-3 text-left">Naam</th>
                        <th class="px-6 py-3 text-left">Mobiel</th>
                        <th class="px-6 py-3 text-left">Datum in dienst</th>
                        <th class="px-6 py-3 text-left">Sterren</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Voertuigen</th>
                        <th class="px-6 py-3 text-left">Ziekte/Verlof</th>
                        <th class="px-6 py-3 text-left">Verwijderen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($instructeurs as $instructeur)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $instructeur->volledige_naam }}</td>
                        <td class="px-6 py-4">{{ $instructeur->Mobiel }}</td>
                        <td class="px-6 py-4">{{ date('d-m-Y', strtotime($instructeur->DatumInDienst)) }}</td>
                        <td class="px-6 py-4">
                            @for($i = 0; $i < $instructeur->AantalSterren; $i++)
                                <i class="fas fa-star text-yellow-400"></i>
                            @endfor
                        </td>
                        <td class="px-6 py-4">
                            @if($instructeur->IsActief)
                                <span class="text-green-600"><i class="fas fa-check-circle"></i> Actief</span>
                            @else
                                <span class="text-red-600"><i class="fas fa-times-circle"></i> Inactief</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('voertuigen.instructeur', $instructeur->Id) }}" 
                               class="text-blue-600 hover:text-blue-800 text-xl">
                                <i class="fas fa-car"></i>
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('instructeur.toggle-status', $instructeur->Id) }}" 
                                  method="POST" 
                                  class="inline-block"
                                  onsubmit="return confirm('Weet u zeker dat u de status wilt wijzigen?');">
                                @csrf
                                <button type="submit" 
                                        class="text-2xl hover:scale-110 transition-transform">
                                    @if($instructeur->IsActief)
                                        <i class="fas fa-thumbs-up text-green-500"></i>
                                    @else
                                        <i class="fas fa-bandage text-red-500"></i>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('instructeur.verwijder', $instructeur->Id) }}" 
                                  method="POST" 
                                  class="inline-block"
                                  onsubmit="return confirm('Weet u zeker dat u deze instructeur definitief wilt verwijderen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-2xl text-red-500 hover:text-red-700 hover:scale-110 transition-transform">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            Geen instructeurs gevonden.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="{{ route('voertuigen.alle') }}" class="text-blue-600 hover:underline">
                Alle voertuigen bekijken →
            </a>
        </div>
    </div>
</body>
</html>