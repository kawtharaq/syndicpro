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
    Schema::table('appartements', function (Blueprint $table) {
        $table->text('description')->nullable()->after('superficie');
        $table->decimal('prix_charge', 10, 2)->nullable()->after('description');
        $table->boolean('charges_payees')->default(false)->after('prix_charge');
    });
}

public function down(): void
{
    Schema::table('appartements', function (Blueprint $table) {
        $table->dropColumn(['description', 'prix_charge', 'charges_payees']);
    });
}
};
