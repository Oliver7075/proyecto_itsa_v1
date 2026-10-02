<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscrito', function (Blueprint $table) {
            $table->id('id_inscrito');
            $table->unsignedBigInteger('codigo')->nullable()->unique();
            $table->date('fecha')->nullable();
            $table->integer('numero')->nullable();
            $table->integer('tipo')->nullable();
            $table->unsignedBigInteger('id_carrera');
            $table->unsignedBigInteger('id_persona');
            $table->unsignedBigInteger('id_gestionacademica');
            $table->boolean('becado')->default(false);
            $table->timestamps();

            $table->foreign('id_carrera')->references('id_carrera')->on('carreras')->onDelete('cascade');
            $table->foreign('id_persona')->references('id_persona')->on('personas')->onDelete('cascade');
            $table->foreign('id_gestionacademica')->references('id_gestionacademica')->on('gestionacademica')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscrito');
    }
};