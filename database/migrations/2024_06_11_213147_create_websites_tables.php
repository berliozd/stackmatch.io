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
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('name')->nullable();
            $table->timestamps();
        });
        Schema::create('websites_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')->constrained()->onDelete('cascade');
            $table->string('city')->nullable();
            $table->string('postcode')->nullable();
            $table->string('country')->nullable();
            $table->timestamps();
        });
        Schema::create('websites_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')->constrained()->onDelete('cascade');
            $table->string('email');
            $table->timestamps();
        });
        Schema::create('websites_phones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')->constrained()->onDelete('cascade');
            $table->string('phone');
            $table->timestamps();
        });
        Schema::create('websites_socials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')->constrained()->onDelete('cascade');
            $table->string('social');
            $table->timestamps();
        });
        Schema::create('websites_techs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')->constrained()->onDelete('cascade');
            $table->foreignId('tech_id')->references('id')->on('techs')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('user_website', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('website_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->dropsTables();
    }

    private function dropsTables(): void
    {
        Schema::dropIfExists('websites_addresses');
        Schema::dropIfExists('websites_emails');
        Schema::dropIfExists('websites_phones');
        Schema::dropIfExists('websites_socials');
        Schema::dropIfExists('websites_techs');
        Schema::dropIfExists('user_website');
        Schema::dropIfExists('websites');
    }
};
