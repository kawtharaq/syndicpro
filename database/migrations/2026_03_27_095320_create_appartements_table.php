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
        Schema::create('appartements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('immeuble_id')->constrained('immeubles')->onDelete('cascade');
            $table->string('numero', 10);
            $table->integer('etage')->nullable();
            $table->decimal('superficie', 6, 2)->nullable();
            $table->enum('statut', ['occupé', 'vacant'])->default('vacant');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appartements');
    }
};
