<?php

use App\Models\Culto;
use App\Models\Membro;
use App\Models\Visitante;
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
        Schema::create('participacoes_cultos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Culto::class);
            $table->foreignIdFor(Membro::class)->nullable();
            $table->foreignIdFor(Visitante::class)->nullable();
            $table->boolean('participou')->default(0);
            $table->boolean('entrei_contato')->default(0);
            $table->text('descricao')->nullable();

            $table->foreign('culto_id')
            ->references('id')
            ->on('cultos')
            ->onDelete('cascade'); // Define ação de exclusão em cascata

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participacaos');
    }
};
