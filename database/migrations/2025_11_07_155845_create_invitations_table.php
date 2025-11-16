<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // HAPUS
            $table->string('invitee_name');
            $table->string('slug')->unique();
            $table->boolean('is_opened')->default(false);
            $table->timestamps();

            // $table->index(['user_id', 'created_at']); // HAPUS
        });
    }

    public function down(): void {
        Schema::dropIfExists('invitations');
    }
};
