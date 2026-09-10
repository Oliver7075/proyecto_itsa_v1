<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursa', function (Blueprint $table) {
            $table->unsignedBigInteger('id_persona');
            $table->unsignedBigInteger('id_carrera');
            $table->unsignedBigInteger('id_mencion')->nullable();
            $table->integer('nivelinicio')->nullable();

            // Clave Primaria Compuesta
            $table->primary(['id_persona', 'id_carrera']);

            $table->foreign('id_persona')
                  ->references('id_persona')
                  ->on('personas')
                  ->onDelete('cascade');

            $table->foreign('id_carrera')
                  ->references('id_carrera')
                ->on('carreras')
                  ->onDelete('cascade');

            // Descomentar si la tabla 'mencion' existe:
            // $table->foreign('id_mencion')->references('id_mencion')->on('mencion')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursa');
    }
};