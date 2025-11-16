<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rsvps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->string('name');                                          // nama pengisi RSVP
            $table->enum('status', ['hadir', 'tidak_hadir']);                // sesuai permintaan: hadir / tidak
            $table->unsignedSmallInteger('total_attendees')->default(1);     // jumlah yang hadir
            $table->timestamps();

            $table->index(['invitation_id', 'created_at']);
            $table->index(['invitation_id', 'status']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('rsvps');
    }
};
