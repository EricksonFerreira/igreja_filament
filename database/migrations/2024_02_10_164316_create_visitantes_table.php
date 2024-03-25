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
        Schema::create('visitantes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sexo');
            $table->string('telefone')->nullable();

            $table->unsignedBigInteger('membro_convidou_id')->nullable();
            $table->foreign('membro_convidou_id')->references('id')->on('membros');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitantes');
    }
};
