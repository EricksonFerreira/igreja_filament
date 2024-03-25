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
        Schema::create('cultos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('inicio_evento')->nullable();
            $table->dateTime('fim_evento')->nullable();
            $table->dateTime('prev_inicio_evento');
            $table->dateTime('prev_fim_evento');
            $table->boolean('evento_agendado')->default(true);
            $table->boolean('evento_ocorreu')->default(false);

            $table->unsignedBigInteger('tipo_culto_id');
            $table->foreign('tipo_culto_id')->references('id')->on('tipos_culto');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cultos');
    }
};
