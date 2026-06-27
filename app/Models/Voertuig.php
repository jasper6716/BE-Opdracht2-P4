<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voertuig extends Model
{
    protected $table = 'voertuig';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Kenteken', 'Type', 'Bouwjaar', 'Brandstof', 'TypeVoertuigId', 'IsActief'
    ];

    public function typeVoertuig()
    {
        return $this->belongsTo(TypeVoertuig::class, 'TypeVoertuigId');
    }

    public function voertuigInstructeurs()
    {
        return $this->hasMany(VoertuigInstructeur::class, 'VoertuigId');
    }

    public function actieveToewijzing()
    {
        return $this->hasOne(VoertuigInstructeur::class, 'VoertuigId')
            ->where('IsActief', 1)
            ->with('instructeur');
    }

    public function alleToewijzingen()
    {
        return $this->hasMany(VoertuigInstructeur::class, 'VoertuigId');
    }

    public function isToegewezenAan($instructeurId)
    {
        return $this->alleToewijzingen()
            ->where('InstructeurId', $instructeurId)
            ->where('IsActief', 1)
            ->exists();
    }

    public function wasToegewezenAan($instructeurId)
    {
        return $this->alleToewijzingen()
            ->where('InstructeurId', $instructeurId)
            ->where('IsActief', 0)
            ->exists();
    }
}