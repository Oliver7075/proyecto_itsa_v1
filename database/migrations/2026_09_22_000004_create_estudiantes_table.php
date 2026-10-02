<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estudiante', function (Blueprint $table) {
            $table->unsignedBigInteger('id_persona')->primary();
            $table->date('fecha')->nullable();
            $table->unsignedBigInteger('matricula')->nullable()->unique();
            $table->boolean('diplomabachiller')->default(false);
            $table->string('nombrecontacto')->nullable();
            $table->string('celularcontacto')->nullable();
            $table->unsignedBigInteger('id_gestionacademica');
            $table->string('parentescocontacto')->nullable();
            $table->string('nombrecolegio')->nullable();
            $table->string('caractercolegio')->nullable();
            $table->string('egresocolegio')->nullable();
            $table->unsignedBigInteger('id_postulante')->nullable();
            $table->timestamps();

            $table->foreign('id_persona')->references('id_persona')->on('personas')->onDelete('cascade');
            $table->foreign('id_gestionacademica')->references('id_gestionacademica')->on('gestionacademica')->onDelete('cascade');
            $table->foreign('id_postulante')->references('id_postulante')->on('postulante')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estudiante');
    }
};