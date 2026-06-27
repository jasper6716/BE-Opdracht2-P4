<?php

namespace App\Http\Controllers;

use App\Models\Instructeur;

class InstructeurController extends Controller
{
    public function overzicht()
    {
        $instructeurs = Instructeur::sortedBySterren()->get();
        return view('instructeurs.overzicht', compact('instructeurs'));
    }
}