<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeVoertuig extends Model
{
    protected $table = 'type_voertuig';
    public $timestamps = false;

    protected $fillable = ['TypeVoertuig', 'Rijbewijscategorie'];
}