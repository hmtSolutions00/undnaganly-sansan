<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('wishes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->string('name');                   // nama pengirim ucapan
            $table->text('message');                  // isi ucapan
            $table->boolean('is_public')->default(true);
            $table->timestamps();

            $table->index(['invitation_id', 'created_at']);
            $table->index(['invitation_id', 'is_public']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('wishes');
    }
};
