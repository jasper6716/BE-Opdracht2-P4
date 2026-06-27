<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voertuig verwijderd</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta http-equiv="refresh" content="3;url={{ $context == 'instructeur' ? route('voertuigen.instructeur', $instructeurId) : route('voertuigen.alle') }}">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8 text-center">
        <div class="text-green-500 text-6xl mb-4">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1 class="text-2xl font-bold mb-4">Het door u geselecteerde voertuig is verwijderd</h1>
        <p class="text-gray-600 mb-4">U wordt over 3 seconden doorgestuurd...</p>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="bg-green-500 h-2.5 rounded-full animate-pulse" style="width: 100%"></div>
        </div>
        <a href="{{ $context == 'instructeur' ? route('voertuigen.instructeur', $instructeurId) : route('voertuigen.alle') }}" 
           class="inline-block mt-4 text-blue-600 hover:underline">
            Klik hier als u niet wordt doorgestuurd
        </a>
    </div>
</body>
</html>