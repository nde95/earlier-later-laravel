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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('image_id')->unique();
            $table->string('user_id');
            $table->date('taken_date');
            $table->string('username');
            $table->string('real_name')->nullable();
            $table->string('title');
            $table->string('format')->nullable();
            $table->string('image_secret');
            $table->string('url');
            $table->string('page_type');
            $table->string('server_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
