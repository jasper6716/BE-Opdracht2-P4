<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wijzigen voertuiggegevens</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-lg mx-auto">
        <a href="{{ route('voertuigen.instructeur', $huidigeInstructeurId ?? $contextInstructeurId) }}" class="text-blue-600 hover:underline mb-4 inline-block">
            ← Terug naar voertuigen
        </a>

        <h1 class="text-3xl font-bold mb-6">Wijzigen voertuiggegevens</h1>

        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('voertuig.update') }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf
            <input type="hidden" name="id" value="{{ $voertuig->Id }}">
            <input type="hidden" name="oudeInstructeurId" value="{{ $huidigeInstructeurId }}">
            <input type="hidden" name="context_instructeur_id" value="{{ $contextInstructeurId }}">

            <div class="mb-4">
                <label for="Kenteken" class="block text-gray-700 font-bold mb-2">Kenteken:</label>
                <input type="text" id="Kenteken" name="Kenteken" 
                       value="{{ old('Kenteken', $voertuig->Kenteken) }}"
                       class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="Type" class="block text-gray-700 font-bold mb-2">Type:</label>
                <input type="text" id="Type" name="Type" 
                       value="{{ old('Type', $voertuig->Type) }}"
                       class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="Bouwjaar" class="block text-gray-700 font-bold mb-2">Bouwjaar:</label>
                <input type="text" id="Bouwjaar" name="Bouwjaar" 
                       value="{{ date('d-m-Y', strtotime($voertuig->Bouwjaar)) }}"
                       class="w-full px-3 py-2 border rounded-lg