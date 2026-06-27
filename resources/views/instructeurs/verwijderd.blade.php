<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructeur verwijderd</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @if($status == 'success')
        <meta http-equiv="refresh" content="3;url={{ route('instructeurs.overzicht') }}">
    @else
        <meta http-equiv="refresh" content="3;url={{ route('instructeurs.overzicht') }}">
    @endif
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8 text-center">
        @if($status == 'success')
            <div class="text-green-500 text-6xl mb-4">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1 class="text-2xl font-bold mb-4">
                Instructeur {{ $instructeur->volledige_naam }} is definitief verwijderd en al zijn eerder toegewezen voertuigen zijn vrijgegeven
            </h1>
        @else
            <div class="text-red-500 text-6xl mb-4">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <h1 class="text-2xl font-bold mb-4">
                Instructeur {{ $instructeur->volledige_naam }} kan niet definitief worden verwijderd, verander eerst de status ziekte/verlof
            </h1>
        @endif
        <p class="text-gray-600 mb-4">U wordt over 3 seconden doorgestuurd...</p>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="bg-{{ $status == 'success' ? 'green' : 'red' }}-500 h-2.5 rounded-full animate-pulse" style="width: 100%"></div>
        </div>
        <a href="{{ route('instructeurs.overzicht') }}" 
           class="inline-block mt-4 text-blue-600 hover:underline">
            Klik hier als u niet wordt doorgestuurd
        </a>
    </div>
</body>
</html>