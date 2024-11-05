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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('opticien_id')->constrained()->onDelete('cascade');
            $table->date('date_examen');
            $table->decimal('spherique_od', 5, 2);
            $table->decimal('spherique_og', 5, 2);
            $table->decimal('cylindrique_od', 5, 2)->nullable();
            $table->decimal('cylindrique_og', 5, 2)->nullable();
            $table->integer('axe_od')->nullable();
            $table->integer('axe_og')->nullable();
            $table->decimal('addition', 5, 2)->nullable();
            $table->decimal('distance_pupillaire', 5, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
