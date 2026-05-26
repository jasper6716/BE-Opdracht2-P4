<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instructeur', function (Blueprint $table) {
            $table->id();
            $table->string('Voornaam', 50);
            $table->string('Tussenvoegsel', 10)->nullable();
            $table->string('Achternaam', 50);
            $table->string('Mobiel', 15);
            $table->date('DatumInDienst');
            $table->string('AantalSterren', 5);
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 250)->nullable();
            $table->dateTime('DatumAangemaakt')->useCurrent();
            $table->dateTime('DatumGewijzigd')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instructeur');
    }
};