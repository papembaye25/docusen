<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('docusen_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('request_id')->constrained('document_requests')->onDelete('cascade');
            $table->string('message');
            $table->enum('type', ['email', 'sms', 'both'])->default('email');
            $table->enum('statut_concerne', [
                'en_attente',
                'en_traitement',
                'approuve',
                'rejete'
            ]);
            $table->boolean('lu')->default(false);
            $table->timestamp('lu_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docusen_notifications');
    }
};