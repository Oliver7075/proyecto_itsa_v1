<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('cursa') && Schema::hasColumn('cursa', 'id_mencion')) {
            Schema::table('cursa', function (Blueprint $table) {
                $table->dropColumn('id_mencion');
            });
        }

        Schema::dropIfExists('mencion');
    }

    public function down(): void
    {
        Schema::create('mencion', function (Blueprint $table) {
            $table->id('id_mencion');
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->unsignedBigInteger('id_carrera');
            $table->foreign('id_carrera')->references('id_carrera')->on('carreras')->onDelete('cascade');
            $table->timestamps();
        });

        if (Schema::hasTable('cursa') && !Schema::hasColumn('cursa', 'id_mencion')) {
            Schema::table('cursa', function (Blueprint $table) {
                $table->unsignedBigInteger('id_mencion')->nullable();
            });
        }
    }
};