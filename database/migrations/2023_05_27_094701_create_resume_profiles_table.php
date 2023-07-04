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
        Schema::create('resume_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable();
            $table->string('mobile')->nullable();
            $table->string('cover_photo')->nullable();
            $table->text('introduction')->nullable();
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_profiles');
    }
};
