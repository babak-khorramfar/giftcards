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
        Schema::create('category_gift_card', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('gift_card_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['category_id', 'gift_card_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_gift_card');
    }

};
