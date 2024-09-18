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
        Schema::create('logements', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('adresse');
            $table->enum('type', ['appartement', 'maison']);
            $table->enum('statut', ['en vente', 'en location', 'deja vendu', 'deja loue'])->default('en vente');
            $table->string('image')->nullable();
            $table->string('ville');
            $table->string('region');
            $table->string('quartier');
            $table->integer('nombreChambre');
            $table->integer('nombreToilette');
            $table->integer('nombreEtage')->nullable();
            $table->integer('surface');
            $table->text('description');
            $table->decimal('prix', 10, 2);
            $table->foreignId('proprietaire_id')->constrained('proprietaires')->onDelete('cascade');
            $table->foreignId('categorie_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logements');
    }
};
