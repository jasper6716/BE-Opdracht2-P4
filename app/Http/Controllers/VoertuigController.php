<?php

namespace App\Http\Controllers;

use App\Models\Voertuig;
use App\Models\Instructeur;
use App\Models\VoertuigInstructeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoertuigController extends Controller
{
    // Overzicht van voertuigen van één instructeur
    public function voertuigenVanInstructeur($instructeurId)
    {
        $instructeur = Instructeur::findOrFail($instructeurId);

        $voertuigen = Voertuig::select('voertuig.*', 'type_voertuig.Rijbewijscategorie')
            ->join('type_voertuig', 'voertuig.TypeVoertuigId', '=', 'type_voertuig.Id')
            ->join('voertuig_instructeur', 'voertuig.Id', '=', 'voertuig_instructeur.VoertuigId')
            ->where('voertuig_instructeur.InstructeurId', $instructeurId)
            ->where('voertuig_instructeur.IsActief', 1)
            ->orderBy('type_voertuig.Rijbewijscategorie')
            ->paginate(4);

        return view('voertuigen.instructeur', compact('voertuigen', 'instructeur'));
    }

    // Lijst met alle beschikbare voertuigen (nog niet toegewezen)
    public function beschikbareVoertuigen($instructeurId)
    {
        $instructeur = Instructeur::findOrFail($instructeurId);

        $voertuigen = Voertuig::whereDoesntHave('actieveToewijzing')
            ->join('type_voertuig', 'voertuig.TypeVoertuigId', '=', 'type_voertuig.Id')
            ->select('voertuig.*', 'type_voertuig.Rijbewijscategorie')
            ->orderBy('type_voertuig.Rijbewijscategorie')
            ->paginate(4);

        return view('voertuigen.beschikbaar', compact('voertuigen', 'instructeur'));
    }

    // Wijzigingsformulier tonen
    public function wijzigen($voertuigId, Request $request)
    {
        $voertuig = Voertuig::with('typeVoertuig')->findOrFail($voertuigId);
        $instructeurs = Instructeur::where('IsActief', 1)->orderBy('Achternaam')->get();

        // Bestaande actieve toewijzing ophalen
        $huidigeToewijzing = VoertuigInstructeur::where('VoertuigId', $voertuigId)
            ->where('IsActief', 1)
            ->first();
        $huidigeInstructeurId = $huidigeToewijzing ? $huidigeToewijzing->InstructeurId : null;

        // instructeur_id uit de querystring (komt van "Toevoegen Voertuig")
        $contextInstructeurId = $request->query('instructeur_id');

        // Als het voertuig nog niet is toegewezen, gebruik dan de context-instructeur als voorselectie
        $geselecteerdeInstructeurId = $huidigeInstructeurId ?? $contextInstructeurId;

        return view('voertuigen.wijzigen', compact(
            'voertuig',
            'instructeurs',
            'huidigeInstructeurId',
            'contextInstructeurId',
            'geselecteerdeInstructeurId'
        ));
    }

    // Update verwerken
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:voertuig,Id',
            'Type' => 'required|string|max:50',
            'Brandstof' => 'required|string|max:20',
            'Kenteken' => ['required', 'string', 'max:10', 'regex:/^[A-Z0-9]{2,3}-[A-Z0-9]{2}-[A-Z0-9]{1,2}$/i'],
            'InstructeurId' => 'required|exists:instructeur,Id',
            'oudeInstructeurId' => 'nullable|exists:instructeur,Id',
            'context_instructeur_id' => 'nullable|exists:instructeur,Id',
        ]);

        $voertuig = Voertuig::findOrFail($request->id);
        $voertuig->update([
            'Type' => $request->Type,
            'Brandstof' => $request->Brandstof,
            'Kenteken' => strtoupper($request->Kenteken),
        ]);

        // Bepaal de redirect-instructeur
        if ($request->oudeInstructeurId) {
            // Scenario 01/02: voertuig was al toegewezen
            if ($request->InstructeurId != $request->oudeInstructeurId) {
                DB::transaction(function () use ($request) {
                    VoertuigInstructeur::where('VoertuigId', $request->id)
                        ->where('IsActief', 1)
                        ->update(['IsActief' => 0]);
                    VoertuigInstructeur::create([
                        'VoertuigId' => $request->id,
                        'InstructeurId' => $request->InstructeurId,
                        'DatumToekenning' => now()->toDateString(),
                        'IsActief' => 1,
                    ]);
                });
            }
            $redirectInstructeur = $request->oudeInstructeurId;
        } else {
            // Scenario 03: voertuig was nog niet toegewezen
            VoertuigInstructeur::create([
                'VoertuigId' => $request->id,
                'InstructeurId' => $request->InstructeurId,
                'DatumToekenning' => now()->toDateString(),
                'IsActief' => 1,
            ]);
            // Redirect naar de instructeur uit de context (of de zojuist gekozen)
            $redirectInstructeur = $request->context_instructeur_id ?? $request->InstructeurId;
        }

        return redirect()->route('voertuigen.instructeur', $redirectInstructeur)
            ->with('success', 'Voertuig succesvol gewijzigd.');
    }
}