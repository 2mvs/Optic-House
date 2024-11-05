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
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('opticien_id')->constrained()->onDelete('cascade');
            $table->date('date')->default(now());
            $table->string('numero_devis')->unique();
            $table->decimal('sous_total_ht', 10, 2);
            $table->decimal('remise', 10, 2)->nullable();
            $table->decimal('total_ht', 10, 2);
            $table->decimal('tva', 10, 2);
            $table->decimal('total_ttc', 10, 2);
            $table->text('modalites_paiement')->nullable();
            $table->date('validite_devis');
            $table->string('status')->default('en attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis');
    }
};
