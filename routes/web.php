<?php

use App\Http\Controllers\InstructeurController;
use App\Http\Controllers\VoertuigController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/instructeurs');
});

Route::get('/instructeurs', [InstructeurController::class, 'overzicht'])->name('instructeurs.overzicht');
Route::get('/instructeur/{id}/voertuigen', [VoertuigController::class, 'voertuigenVanInstructeur'])->name('voertuigen.instructeur');
Route::get('/voertuig/wijzigen/{id}', [VoertuigController::class, 'wijzigen'])->name('voertuig.wijzigen');
Route::post('/voertuig/update', [VoertuigController::class, 'update'])->name('voertuig.update');
Route::get('/voertuigen/beschikbaar/{instructeurId}', [VoertuigController::class, 'beschikbareVoertuigen'])->name('voertuigen.beschikbaar');