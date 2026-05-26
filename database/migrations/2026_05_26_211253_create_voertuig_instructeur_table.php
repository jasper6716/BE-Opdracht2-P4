<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('voertuig_instructeur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('VoertuigId')->constrained('voertuig');
            $table->foreignId('InstructeurId')->constrained('instructeur');
            $table->date('DatumToekenning');
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 250)->nullable();
            $table->dateTime('DatumAangemaakt')->useCurrent();
            $table->dateTime('DatumGewijzigd')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('voertuig_instructeur');
    }
};