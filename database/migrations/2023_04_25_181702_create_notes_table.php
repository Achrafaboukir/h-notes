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
        Schema::create('notes', function (Blueprint $table) {
            $table->id('idnote');
            $table->integer('valeur');
            $table->foreignId('idexam');
            $table->foreignId('idstagiere');

            $table->foreign('idexam')->references('idexam')->on('exam')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('idstagiere')->references('idstagiere')->on('stagieres')->onDelete('cascade')->onUpdate('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
