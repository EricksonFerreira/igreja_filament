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
        Schema::create('precos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('valor');
            $table->boolean('ativo')->default(1);

            $table->unsignedBigInteger('veiculo_id');
            $table->foreign('veiculo_id')->references('id')->on('veiculos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precos');
    }
};
