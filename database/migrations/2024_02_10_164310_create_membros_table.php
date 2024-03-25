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
        Schema::create('membros', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('data_nasc')->nullable();
            $table->string('sexo')->nullable();
            $table->boolean('batizado')->default(0);
            $table->string('data_batismo')->nullable();
            $table->boolean('professou_fe')->default(0);
            $table->string('data_profissao_fe')->nullable();
            $table->string('casado')->nullable();

            $table->unsignedBigInteger('status_membro_id');
            $table->foreign('status_membro_id')->references('id')->on('status_membros');

            $table->unsignedBigInteger('estado_civil_id');
            $table->foreign('estado_civil_id')->references('id')->on('estado_civil');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membros');
    }
};
