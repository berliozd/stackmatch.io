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
//        Schema::create('websites', function (Blueprint $table) {
//            $table->id();
//            $table->string('url');
//            $table->string('name');
//            $table->string('city');
//            $table->string('postcode');
//            $table->string('country');
//            $table->timestamps();
//        });
//        Schema::create('websites_emails', function (Blueprint $table) {
//            $table->id();
//            $table->string('email');
//            $table->foreignId('website_id')->constrained()->onDelete('cascade');
//            $table->timestamps();
//        });
//        Schema::create('websites_phones', function (Blueprint $table) {
//            $table->id();
//            $table->string('phone');
//            $table->foreignId('website_id')->constrained()->onDelete('cascade');
//            $table->timestamps();
//        });
//        Schema::create('websites_socials', function (Blueprint $table) {
//            $table->id();
//            $table->string('social');
//            $table->foreignId('website_id')->constrained()->onDelete('cascade');
//            $table->timestamps();
//        });
        Schema::create('websites_techs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tech_id')->references('id')->on('techs')->onDelete('cascade');
            $table->foreignId('website_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites_tables');
    }
};
