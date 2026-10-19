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
        Schema::create('draft_photos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('draft_id')->constrained()->cascadeOnDelete();
    $table->text('photo_url');
    $table->unsignedInteger('position')->default(0);
    $table->jsonb('config')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draft_photos');
    }
};
