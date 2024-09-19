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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->enum('statut', ['en attente', 'acceptee', 'declinee']);
            $table->foreignId('logement_id')->constrained('logements')->onDelete('cascade');
            $table->foreignId('locataire_id')->constrained('locataires')->onDelete('cascade');
            $table->boolean('deleted_by_owner')->default(false);
            $table->boolean('deleted_by_tenant')->default(false);
            $table->timestamp('archived_by_tenant_at')->nullable();
            $table->timestamp('archived_by_owner_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
