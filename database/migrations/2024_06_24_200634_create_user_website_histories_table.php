<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_website_histories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->longText('content');
            $table->foreignId('user_website_id')->references('id')->on('user_website')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_website_histories');
    }
};
