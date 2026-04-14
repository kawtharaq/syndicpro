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
    Schema::create('occupants', function (Blueprint $table) {
        $table->id();
        $table->foreignId('appartement_id')->constrained('appartements')->onDelete('cascade');
        $table->string('nom', 100);
        $table->string('telephone', 20)->nullable();
        $table->string('email', 150)->nullable();
        $table->enum('type', ['propriétaire', 'locataire']);
        $table->date('date_entree')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupants');
    }
};
