<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stagieres', function (Blueprint $table) {
            $table->id('idstagiere');
            $table->string('nom');
            $table->string('prenom');
            $table->foreignId('idgroupe');
            $table->foreign('idgroupe')->references('idgroupe')->on('groupes')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stagieres');
    }
};
