<?php

namespace App\Http\Controllers;

use App\Models\Instructeur;
use App\Models\VoertuigInstructeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstructeurController extends Controller
{
    // Overzicht van alle instructeurs
    public function overzicht()
    {
        $instructeurs = Instructeur::sortedBySterren()->get();
        return view('instructeurs.overzicht', compact('instructeurs'));
    }

    // Toggle status (actief/deactiveren voor ziekte/verlof)
    public function toggleStatus($id, Request $request)
    {
        $instructeur = Instructeur::findOrFail($id);
        $nieuweStatus = !$instructeur->IsActief;
        
        DB::transaction(function () use ($instructeur, $nieuweStatus) {
            $instructeur->update(['IsActief' => $nieuweStatus]);
            
            if (!$nieuweStatus) {
                VoertuigInstructeur::where('InstructeurId', $instructeur->Id)
                    ->where('IsActief', 1)
                    ->update(['IsActief' => 0]);
            }
        });

        return redirect()->route('instructeur.status-melding', [
            'id' => $instructeur->Id,
            'status' => $nieuweStatus ? 'actief' : 'inactief'
        ]);
    }

    // Toon status melding (3 seconden)
    public function statusMelding($id, Request $request)
    {
        $instructeur = Instructeur::findOrFail($id);
        $status = $request->query('status', 'actief');
        
        return view('instructeurs.status-melding', compact('instructeur', 'status'));
    }

    // Instructeur definitief verwijderen
    public function verwijder($id, Request $request)
    {
        try {
            $instructeur = Instructeur::findOrFail($id);
            $instructeurNaam = $instructeur->volledige_naam;

            // Check of instructeur ziek/verlof heeft (IsActief = 0)
            if (!$instructeur->IsActief) {
                return redirect()->route('instructeur.verwijderd', [
                    'id' => $id,
                    'status' => 'error'
                ]);
            }

            DB::transaction(function () use ($instructeur) {
                // 1. Deactiveer alle toewijzingen
                VoertuigInstructeur::where('InstructeurId', $instructeur->Id)
                    ->where('IsActief', 1)
                    ->update(['IsActief' => 0]);
                
                // 2. Deactiveer de instructeur (soft delete)
                $instructeur->update(['IsActief' => 0]);
            });

            return redirect()->route('instructeur.verwijderd', [
                'id' => $id,
                'status' => 'success'
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Er is een fout opgetreden: ' . $e->getMessage());
        }
    }

    // Toon verwijderd melding (3 seconden)
    public function verwijderdMelding($id, Request $request)
    {
        $instructeur = Instructeur::findOrFail($id);
        $status = $request->query('status', 'success');
        
        return view('instructeurs.verwijderd', compact('instructeur', 'status'));
    }
}