<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructeur extends Model
{
    protected $table = 'instructeur';
    public $timestamps = false;

    protected $fillable = [
        'Voornaam', 'Tussenvoegsel', 'Achternaam', 'Mobiel', 'DatumInDienst', 'AantalSterren'
    ];

    public function getVolledigeNaamAttribute()
    {
        return trim($this->Voornaam . ' ' . ($this->Tussenvoegsel ? $this->Tussenvoegsel . ' ' : '') . $this->Achternaam);
    }

    public function voertuigInstructeurs()
    {
        return $this->hasMany(VoertuigInstructeur::class, 'InstructeurId')->where('IsActief', 1);
    }

    public function scopeSortedBySterren($query)
    {
        return $query->where('IsActief', 1)->orderByRaw('LENGTH(AantalSterren) DESC')->orderBy('AantalSterren', 'DESC');
    }
}