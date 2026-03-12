<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('document_type_id')
                  ->constrained('document_types')
                  ->onDelete('cascade');
            $table->string('numero_reference', 20)->unique();
            $table->enum('statut', [
                'en_attente',
                'en_traitement',
                'approuve',
                'rejete'
            ])->default('en_attente');
            $table->json('fichiers')->nullable();
            $table->text('commentaire_admin')->nullable();
            $table->text('notes_citoyen')->nullable();
            $table->timestamp('date_traitement')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_requests');
    }
};