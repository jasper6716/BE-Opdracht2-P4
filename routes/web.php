<?php

use App\Http\Controllers\InstructeurController;
use App\Http\Controllers\VoertuigController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/instructeurs');
});

// Instructeur routes
Route::get('/instructeurs', [InstructeurController::class, 'overzicht'])->name('instructeurs.overzicht');

// Voertuig routes
Route::get('/instructeur/{id}/voertuigen', [VoertuigController::class, 'voertuigenVanInstructeur'])->name('voertuigen.instructeur');
Route::get('/voertuig/wijzigen/{id}', [VoertuigController::class, 'wijzigen'])->name('voertuig.wijzigen');
Route::post('/voertuig/update', [VoertuigController::class, 'update'])->name('voertuig.update');
Route::get('/voertuigen/beschikbaar/{instructeurId}', [VoertuigController::class, 'beschikbareVoertuigen'])->name('voertuigen.beschikbaar');
Route::delete('/voertuig/verwijder/{id}', [VoertuigController::class, 'verwijder'])->name('voertuig.verwijder');
Route::get('/voertuig/verwijderd/{id}', [VoertuigController::class, 'verwijderdMelding'])->name('voertuig.verwijderd');
Route::get('/voertuigen/alle', [VoertuigController::class, 'alleVoertuigen'])->name('voertuigen.alle');