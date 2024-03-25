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
        Schema::create('empresta_veiculos', function (Blueprint $table) {
            $table->id();
            $table->string('data');

            $table->unsignedBigInteger('veiculo_id');
            $table->foreign('veiculo_id')->references('id')->on('veiculos');
            $table->unsignedBigInteger('preco_id');
            $table->foreign('preco_id')->references('id')->on('precos');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresta_veiculos');
    }
};
