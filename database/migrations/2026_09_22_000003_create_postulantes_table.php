<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postulante', function (Blueprint $table) {
            $table->id('id_postulante');
            $table->string('caractercolegio')->nullable();
            $table->string('celular')->nullable();
            $table->string('celularcontacto')->nullable();
            $table->string('ci')->nullable();
            $table->string('codigo')->nullable()->unique();
            $table->string('deposito')->nullable();
            $table->boolean('diplomabachiller')->default(false);
            $table->string('direccion')->nullable();
            $table->string('egresocolegio')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('fecha')->nullable();
            $table->date('fechanacimiento')->nullable();
            $table->string('foto')->nullable();
            $table->string('lugarexpedicion')->nullable();
            $table->string('lugarnacimiento')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->string('nombre');
            $table->string('nombrecolegio')->nullable();
            $table->string('nombrecontacto')->nullable();
            $table->string('parentescocontacto')->nullable();
            $table->string('primerapellido')->nullable();
            $table->string('segundoapellido')->nullable();
            $table->string('sexo')->nullable();
            $table->string('telefono')->nullable();
            $table->unsignedBigInteger('id_carrera');
            $table->unsignedBigInteger('id_gestionacademica');
            $table->timestamps();

            $table->foreign('id_carrera')->references('id_carrera')->on('carreras')->onDelete('cascade');
            $table->foreign('id_gestionacademica')->references('id_gestionacademica')->on('gestionacademica')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postulante');
    }
};