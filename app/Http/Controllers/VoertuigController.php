<?php

namespace App\Http\Controllers;

use App\Models\Voertuig;
use App\Models\Instructeur;
use App\Models\VoertuigInstructeur;
use App\Models\TypeVoertuig;
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
            ->orderBy('type_voertuig.Rijbewijscategorie', 'DESC')
            ->paginate(4);

        return view('voertuigen.instructeur', compact('voertuigen', 'instructeur'));
    }

    // Alle voertuigen (voor scenario_02)
    public function alleVoertuigen()
    {
        $voertuigen = Voertuig::with(['typeVoertuig', 'actieveToewijzing.instructeur'])
            ->join('type_voertuig', 'voertuig.TypeVoertuigId', '=', 'type_voertuig.Id')
            ->leftJoin('voertuig_instructeur', function($join) {
                $join->on('voertuig.Id', '=', 'voertuig_instructeur.VoertuigId')
                     ->where('voertuig_instructeur.IsActief', 1);
            })
            ->leftJoin('instructeur', 'voertuig_instructeur.InstructeurId', '=', 'instructeur.Id')
            ->select('voertuig.*', 'type_voertuig.Rijbewijscategorie')
            ->orderBy('voertuig.Bouwjaar', 'DESC')
            ->orderBy('instructeur.Achternaam', 'DESC')
            ->paginate(4);

        return view('voertuigen.alle', compact('voertuigen'));
    }

    // Lijst met alle beschikbare voertuigen (nog niet toegewezen)
    public function beschikbareVoertuigen($instructeurId)
    {
        $instructeur = Instructeur::findOrFail($instructeurId);

        $voertuigen = Voertuig::whereDoesntHave('actieveToewijzing')
            ->join('type_voertuig', 'voertuig.TypeVoertuigId', '=', 'type_voertuig.Id')
            ->select('voertuig.*', 'type_voertuig.Rijbewijscategorie')
            ->orderBy('type_voertuig.Rijbewijscategorie', 'DESC')
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

        $contextInstructeurId = $request->query('instructeur_id');
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
            'Kenteken' => ['required', 'string', 'max:10'],
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

        if ($request->oudeInstructeurId) {
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
            VoertuigInstructeur::create([
                'VoertuigId' => $request->id,
                'InstructeurId' => $request->InstructeurId,
                'DatumToekenning' => now()->toDateString(),
                'IsActief' => 1,
            ]);
            $redirectInstructeur = $request->context_instructeur_id ?? $request->InstructeurId;
        }

        return redirect()->route('voertuigen.instructeur', $redirectInstructeur)
            ->with('success', 'Voertuig succesvol gewijzigd.');
    }

    // Verwijder een voertuig
    public function verwijder($id, Request $request)
    {
        try {
            DB::transaction(function () use ($id) {
                $toewijzing = VoertuigInstructeur::where('VoertuigId', $id)
                    ->where('IsActief', 1)
                    ->first();

                if (!$toewijzing) {
                    throw new \Exception('Voertuig is niet toegewezen aan een instructeur.');
                }

                $toewijzing->update(['IsActief' => 0]);
            });

            $instructeurId = $request->query('instructeur_id', 0);
            $context = $request->query('context', 'instructeur');

            return redirect()->route('voertuig.verwijderd', [
                'id' => $id,
                'instructeur_id' => $instructeurId,
                'context' => $context
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Er is een fout opgetreden: ' . $e->getMessage());
        }
    }

    // Toon de verwijderd melding
    public function verwijderdMelding($id, Request $request)
    {
        $instructeurId = $request->query('instructeur_id', 0);
        $context = $request->query('context', 'instructeur');
        
        return view('voertuigen.verwijderd', compact('id', 'instructeurId', 'context'));
    }
}