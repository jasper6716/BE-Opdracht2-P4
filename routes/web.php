<?php

use App\Http\Controllers\InstructeurController;
use App\Http\Controllers\VoertuigController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/instructeurs');
});

// Instructeur routes
Route::get('/instructeurs', [InstructeurController::class, 'overzicht'])->name('instructeurs.overzicht');

// Instructeur status toggle (ziek/verlof)
Route::post('/instructeur/toggle-status/{id}', [InstructeurController::class, 'toggleStatus'])->name('instructeur.toggle-status');
Route::get('/instructeur/status-melding/{id}', [InstructeurController::class, 'statusMelding'])->name('instructeur.status-melding');

// Instructeur definitief verwijderen
Route::delete('/instructeur/verwijder/{id}', [InstructeurController::class, 'verwijder'])->name('instructeur.verwijder');
Route::get('/instructeur/verwijderd/{id}', [InstructeurController::class, 'verwijderdMelding'])->name('instructeur.verwijderd');

// Voertuig routes
Route::get('/instructeur/{id}/voertuigen', [VoertuigController::class, 'voertuigenVanInstructeur'])->name('voertuigen.instructeur');
Route::get('/voertuig/wijzigen/{id}', [VoertuigController::class, 'wijzigen'])->name('voertuig.wijzigen');
Route::post('/voertuig/update', [VoertuigController::class, 'update'])->name('voertuig.update');
Route::get('/voertuigen/beschikbaar/{instructeurId}', [VoertuigController::class, 'beschikbareVoertuigen'])->name('voertuigen.beschikbaar');
Route::delete('/voertuig/verwijder/{id}', [VoertuigController::class, 'verwijder'])->name('voertuig.verwijder');
Route::get('/voertuig/verwijderd/{id}', [VoertuigController::class, 'verwijderdMelding'])->name('voertuig.verwijderd');
Route::get('/voertuigen/alle', [VoertuigController::class, 'alleVoertuigen'])->name('voertuigen.alle');
Route::post('/voertuig/terug-toewijzen/{id}', [VoertuigController::class, 'terugToewijzen'])->name('voertuig.terug-toewijzen');